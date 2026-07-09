<?php

namespace App\Services;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SchedulingService
{
    private array $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    private array $timeSlots = [
        '07:00', '08:00', '09:00', '10:00', '11:00',
        '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
    ];

    private array $facultyLoad = [];
    private array $facultyTimeSlots = [];
    private array $roomTimeSlots = [];

    public function generate(string $academicYear, string $semester): Collection
    {
        $subjects = Subject::active()->where('semester', $semester)->get();
        $sections = Section::active()->where('semester', $semester)
            ->where('academic_year', $academicYear)->get();
        $faculties = Faculty::active()->where('employment_status', 'full-time')
            ->with('qualifications')->get();
        $rooms = Room::active()->get();

        $this->facultyLoad = $faculties->pluck('max_load', 'faculty_id')->toArray();
        $this->facultyTimeSlots = [];
        $this->roomTimeSlots = [];

        $this->loadExistingSchedules($academicYear, $semester);

        $created = collect();
        $sectionsByYear = $sections->groupBy('year_level');

        foreach ($subjects as $subject) {
            $yearSections = $sectionsByYear->get($subject->year_level, collect());
            if ($yearSections->isEmpty()) {
                continue;
            }

            $qualifiedFaculties = $faculties->filter(fn($f) => $f->qualifications->contains('id', $subject->id));
            if ($qualifiedFaculties->isEmpty()) {
                continue;
            }

            $assignedFaculty = null;
            foreach ($qualifiedFaculties as $faculty) {
                $remaining = $this->facultyLoad[$faculty->faculty_id] ?? 0;
                if ($remaining >= $subject->units) {
                    $assignedFaculty = $faculty;
                    break;
                }
            }

            if (!$assignedFaculty) {
                continue;
            }

            $this->facultyLoad[$assignedFaculty->faculty_id] -= $subject->units;
            $roomType = $subject->lab_hours > 0 ? 'lab' : 'lecture';

            foreach ($yearSections as $section) {
                $slot = $this->findSlot($assignedFaculty->faculty_id, $roomType, $rooms, $subject);
                if (!$slot) {
                    continue;
                }

                $this->bookSlot($assignedFaculty->faculty_id, $slot['room_id'], $slot['day'], $slot['start_time'], $slot['end_time']);

                $created->push(Schedule::create([
                    'faculty_id' => $assignedFaculty->faculty_id,
                    'subject_id' => $subject->id,
                    'section_id' => $section->id,
                    'room_id' => $slot['room_id'],
                    'day' => $slot['day'],
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'status' => 'draft',
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                    'created_by' => Auth::id(),
                ]));
            }
        }

        return $created;
    }

    private function loadExistingSchedules(string $academicYear, string $semester): void
    {
        $existing = Schedule::where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->get(['faculty_id', 'room_id', 'day', 'start_time', 'end_time']);

        foreach ($existing as $s) {
            $this->bookSlot($s->faculty_id, $s->room_id, $s->day, $s->start_time, $s->end_time);
        }
    }

    private function bookSlot(int $facultyId, int $roomId, string $day, string $start, string $end): void
    {
        $this->facultyTimeSlots[$facultyId][$day][] = ['start' => $start, 'end' => $end];
        $this->roomTimeSlots[$roomId][$day][] = ['start' => $start, 'end' => $end];
    }

    private function findSlot(int $facultyId, string $roomType, Collection $rooms, Subject $subject): ?array
    {
        $hours = max(1, $subject->lecture_hours + $subject->lab_hours);

        foreach ($this->days as $day) {
            foreach ($this->timeSlots as $startStr) {
                $end = $this->addHours($startStr, $hours);
                if ($this->isFacultyFree($facultyId, $day, $startStr, $end)) {
                    $room = $this->findFreeRoom($roomType, $rooms, $day, $startStr, $end);
                    if ($room) {
                        return [
                            'day' => $day,
                            'start_time' => $startStr,
                            'end_time' => $end,
                            'room_id' => $room->id,
                        ];
                    }
                }
            }
        }

        return null;
    }

    private function isFacultyFree(int $facultyId, string $day, string $start, string $end): bool
    {
        foreach ($this->facultyTimeSlots[$facultyId][$day] ?? [] as $booked) {
            if ($this->overlaps($start, $end, $booked['start'], $booked['end'])) {
                return false;
            }
        }
        return true;
    }

    private function findFreeRoom(string $roomType, Collection $rooms, string $day, string $start, string $end): ?Room
    {
        foreach ($rooms->where('room_type', $roomType) as $room) {
            $free = true;
            foreach ($this->roomTimeSlots[$room->id][$day] ?? [] as $booked) {
                if ($this->overlaps($start, $end, $booked['start'], $booked['end'])) {
                    $free = false;
                    break;
                }
            }
            if ($free) {
                return $room;
            }
        }
        return null;
    }

    private function overlaps(string $s1, string $e1, string $s2, string $e2): bool
    {
        return $s1 < $e2 && $s2 < $e1;
    }

    private function addHours(string $time, int $hours): string
    {
        $h = (int)explode(':', $time)[0] + $hours;
        return sprintf('%02d:00', $h);
    }
}

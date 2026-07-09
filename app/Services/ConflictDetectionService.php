<?php

namespace App\Services;

use App\Models\Faculty;
use App\Models\Schedule;
use Illuminate\Support\Collection;

class ConflictDetectionService
{
    public function checkAll(array $data): Collection
    {
        $errors = collect();

        $facultyOverlap = $this->checkFacultyTimeOverlap($data);
        if ($facultyOverlap) $errors->push($facultyOverlap);

        $roomOverlap = $this->checkRoomDoubleBooking($data);
        if ($roomOverlap) $errors->push($roomOverlap);

        $loadExceeded = $this->checkLoadLimit($data);
        if ($loadExceeded) $errors->push($loadExceeded);

        $qualified = $this->checkQualification($data);
        if (!$qualified) $errors->push('Faculty is not qualified for the selected subject.');

        $duplicate = $this->checkDuplicate($data);
        if ($duplicate) $errors->push('This assignment already exists.');

        return $errors;
    }

    public function checkFacultyTimeOverlap(array $data): ?string
    {
        $query = Schedule::where('faculty_id', $data['faculty_id'])
            ->where('day', $data['day'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('start_time', '<=', $data['start_time'])
                         ->where('end_time', '>=', $data['end_time']);
                  });
            });

        if (!empty($data['schedule_id'])) {
            $query->where('id', '!=', $data['schedule_id']);
        }

        $conflict = $query->first();
        if ($conflict) {
            return "Faculty has a time conflict with schedule #{$conflict->id} on {$conflict->day} {$conflict->start_time}-{$conflict->end_time}.";
        }

        return null;
    }

    public function checkRoomDoubleBooking(array $data): ?string
    {
        $query = Schedule::where('room_id', $data['room_id'])
            ->where('day', $data['day'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('start_time', '<=', $data['start_time'])
                         ->where('end_time', '>=', $data['end_time']);
                  });
            });

        if (!empty($data['schedule_id'])) {
            $query->where('id', '!=', $data['schedule_id']);
        }

        $conflict = $query->first();
        if ($conflict) {
            return "Room is already booked for schedule #{$conflict->id} on {$conflict->day} {$conflict->start_time}-{$conflict->end_time}.";
        }

        return null;
    }

    public function checkLoadLimit(array $data): ?string
    {
        $faculty = Faculty::find($data['faculty_id']);
        if (!$faculty) return null;

        $totalUnits = Schedule::where('faculty_id', $data['faculty_id'])
            ->where('id', '!=', $data['schedule_id'] ?? 0)
            ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->sum('subjects.units');

        $subject = \App\Models\Subject::find($data['subject_id']);
        $newTotal = $totalUnits + ($subject->units ?? 0);

        if ($newTotal > $faculty->max_load) {
            return "Faculty load would be {$newTotal} units, exceeding max load of {$faculty->max_load} units.";
        }

        return null;
    }

    public function checkQualification(array $data): bool
    {
        $faculty = Faculty::with('qualifications')->find($data['faculty_id']);
        if (!$faculty) return false;

        return $faculty->qualifications->contains('id', $data['subject_id']);
    }

    public function checkDuplicate(array $data): ?string
    {
        $exists = Schedule::where('faculty_id', $data['faculty_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('section_id', $data['section_id'])
            ->where('id', '!=', $data['schedule_id'] ?? 0)
            ->exists();

        return $exists ? 'Duplicate assignment found.' : null;
    }
}

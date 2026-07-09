<?php

namespace App\Services;

use App\Models\Faculty;

class LoadComputationService
{
    public function compute(Faculty $faculty): array
    {
        $schedules = $faculty->schedules()->with('subject')->get();
        $totalUnits = $schedules->sum(fn($s) => $s->subject->units ?? 0);

        $maxLoad = $faculty->max_load;
        $remaining = max(0, $maxLoad - $totalUnits);

        $classification = 'regular';
        if ($totalUnits > $maxLoad && $totalUnits <= $maxLoad + 9) {
            $classification = 'overload';
        } elseif ($totalUnits > $maxLoad + 9) {
            $classification = 'emergency';
        } elseif ($faculty->employment_status === 'part-time') {
            $classification = 'part-time';
        }

        return [
            'total_units' => $totalUnits,
            'max_load' => $maxLoad,
            'remaining' => $remaining,
            'classification' => $classification,
            'schedule_count' => $schedules->count(),
        ];
    }
}

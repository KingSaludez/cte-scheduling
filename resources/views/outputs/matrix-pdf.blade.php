<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Master Schedule Matrix</title>
<style>
    body { font-family: 'Courier New', monospace; font-size: 9px; }
    h1 { text-align:center; font-size:16px; margin-bottom:4px; }
    h2 { text-align:center; font-size:12px; font-weight:normal; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #333; padding:3px 4px; text-align:center; vertical-align:middle; font-size:8px; }
    th { background:#1e40af; color:#fff; font-weight:600; -webkit-print-color-adjust:exact; }
    .time-col { font-weight:700; text-align:center; width:60px; background:#f8fafc; -webkit-print-color-adjust:exact; }
    .lunch td { background:#fef3c7; font-weight:700; text-align:center; -webkit-print-color-adjust:exact; }
    .lunch .time-col { background:#fde68a; -webkit-print-color-adjust:exact; }
    .sched { padding:2px; }
    .sched .subj { font-weight:700; font-size:8px; }
    .sched .inst { font-size:7px; color:#555; }
    .empty { color:#ccc; }
</style>
</head>
<body>
<h1>MASTER SCHEDULE MATRIX</h1>
<h2>{{ $selectedDay }} — CTE NEMSU Tagbina ({{ $academicYear }}, {{ $semester }} semester)</h2>
<table>
    <tr><th style="width:60px;">Time</th>@foreach($columns as $col)<th>{{ $col['room']->room_number }} | {{ $col['section']->name }}</th>@endforeach</tr>
    @php $lunchSlots = ['12:00', '12:30']; @endphp
    @foreach($timeSlots as $i => $time)
        @php $isLunch = in_array($time, $lunchSlots); @endphp
        <tr class="{{ $isLunch ? 'lunch' : '' }}">
            <td class="time-col">{{ $timeLabels[$time] ?? $time }}</td>
            @if($isLunch)
                <td colspan="{{ count($columns) }}">LUNCH BREAK</td>
            @else
                @foreach($columns as $col)
                    @php
                        $key = $col['key'];
                        $state = $cellStates[$key][$time] ?? 'empty';
                        $info = $cellMeta[$key][$time] ?? null;
                    @endphp
                    @if($state === 'schedule' && $info)
                        <td>
                            <div class="sched">
                                <div class="subj">{{ $info['schedule']->subject->code ?? '' }}</div>
                                <div class="inst">{{ $info['schedule']->faculty->full_name ?? '' }}</div>
                            </div>
                        </td>
                    @elseif($state === 'skip')
                    @else
                        <td><span class="empty">—</span></td>
                    @endif
                @endforeach
            @endif
        </tr>
    @endforeach
</table>
</body>
</html>

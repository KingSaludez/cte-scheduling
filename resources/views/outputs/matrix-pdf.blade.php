<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Master Schedule Matrix</title>
<style>
    body { font-family: 'Courier New', monospace; font-size: 10px; }
    h1 { text-align:center; font-size:16px; margin-bottom:4px; }
    h2 { text-align:center; font-size:13px; font-weight:normal; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #333; padding:4px 6px; text-align:center; vertical-align:middle; font-size:9px; }
    th { background:#1e40af; color:#fff; font-weight:600; }
    .time-col { font-weight:700; text-align:center; width:70px; }
    .lunch td { background:#fef3c7; font-weight:700; text-align:center; }
    .sched { padding:2px; }
    .sched .section { font-weight:700; }
    .sched .subj { font-size:8px; }
    .sched .inst { font-size:8px; color:#555; font-style:italic; }
    .empty { color:#ccc; }
</style>
</head>
<body>
<h1>MASTER SCHEDULE MATRIX</h1>
<h2>{{ $selectedDay }} — CTE NEMSU Tagbina</h2>
<table>
    <tr><th style="width:70px;">Time</th>@foreach($rooms as $room)<th>{{ $room->room_number }}</th>@endforeach</tr>
    @foreach($timeSlots as $i => $time)
        @php $isLunch = $time === '12:00'; @endphp
        <tr class="{{ $isLunch ? 'lunch' : '' }}">
            <td class="time-col">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</td>
            @if($isLunch)
                <td colspan="{{ count($rooms) }}">🍽️ LUNCH BREAK</td>
            @else
                @foreach($rooms as $room)
                    <td>
                        @php $s = $matrix[$selectedDay][$room->id][$time] ?? null; @endphp
                        @if($s)
                            <div class="sched">
                                <div class="section">{{ $s->section->name ?? '' }}</div>
                                <div class="subj">{{ $s->subject->code ?? '' }}</div>
                                <div class="inst">{{ $s->faculty->full_name ?? '' }}</div>
                            </div>
                        @else<span class="empty">—</span>@endif
                    </td>
                @endforeach
            @endif
        </tr>
    @endforeach
</table>
</body>
</html>
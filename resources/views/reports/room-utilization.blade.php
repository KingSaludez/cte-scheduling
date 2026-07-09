<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Room Utilization</title>
<style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
    th { background: #4f46e5; color: white; }
    h1 { text-align: center; color: #333; }
    h2 { color: #4f46e5; margin-top: 20px; }
</style>
</head>
<body>
    <h1>Room Utilization Report</h1>
    @foreach($rooms as $room)
        <h2>{{ $room->room_number }} ({{ $room->building ?? 'N/A' }}) - {{ ucfirst($room->room_type) }} - Capacity: {{ $room->capacity }}</h2>
        @php $hasSchedules = false; @endphp
        @foreach($days as $day)
            @php $daySchedules = $room->schedules->where('day', $day); @endphp
            @if($daySchedules->isNotEmpty())
                @php $hasSchedules = true; @endphp
                <table>
                    <caption style="font-weight: bold; margin-top: 10px;">{{ $day }}</caption>
                    <thead><tr><th>Time</th><th>Subject</th><th>Faculty</th><th>Section</th></tr></thead>
                    <tbody>
                        @foreach($daySchedules as $s)
                        <tr>
                            <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                            <td>{{ $s->subject->code ?? 'N/A' }}</td>
                            <td>{{ $s->faculty->full_name ?? 'N/A' }}</td>
                            <td>{{ $s->section->name ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
        @if(!$hasSchedules)
            <p class="text-gray-500">No schedules for this room.</p>
        @endif
    @endforeach
</body>
</html>

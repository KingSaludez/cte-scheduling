<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>{{ $faculty->full_name }} - Schedule</title>
<style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
    th { background: #4f46e5; color: white; }
    h1 { text-align: center; color: #333; }
    h2 { color: #4f46e5; margin-top: 20px; }
</style>
</head>
<body>
    <h1>{{ $faculty->full_name }} - Schedule</h1>
    <p>Rank: {{ $faculty->academic_rank ?? 'N/A' }} | Status: {{ ucfirst($faculty->employment_status) }} | Max Load: {{ $faculty->max_load }}</p>
    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
        @if(isset($schedules[$day]))
            <h2>{{ $day }}</h2>
            <table>
                <thead><tr><th>Time</th><th>Subject</th><th>Section</th><th>Room</th></tr></thead>
                <tbody>
                    @foreach($schedules[$day] as $s)
                    <tr>
                        <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                        <td>{{ $s->subject->code ?? 'N/A' }}</td>
                        <td>{{ $s->section->name ?? 'N/A' }}</td>
                        <td>{{ $s->room->room_number ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>
</html>

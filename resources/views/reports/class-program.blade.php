<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Class Program</title>
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
    <h1>Class Program</h1>
    @foreach($schedules as $section => $entries)
        <h2>{{ $section }}</h2>
        <table>
            <thead><tr><th>Day</th><th>Time</th><th>Subject</th><th>Faculty</th><th>Room</th></tr></thead>
            <tbody>
                @foreach($entries as $s)
                <tr>
                    <td>{{ $s->day }}</td>
                    <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                    <td>{{ $s->subject->code ?? 'N/A' }}</td>
                    <td>{{ $s->faculty->full_name ?? 'N/A' }}</td>
                    <td>{{ $s->room->room_number ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>

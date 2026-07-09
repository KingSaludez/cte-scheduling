<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Subject Assignments</title>
<style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #4f46e5; color: white; }
    h1 { text-align: center; color: #333; }
</style>
</head>
<body>
    <h1>Subject Assignment Report</h1>
    <table>
        <thead><tr><th>Code</th><th>Title</th><th>Units</th><th>Year</th><th>Semester</th><th>Faculty</th><th>Section</th></tr></thead>
        <tbody>
            @foreach($subjects as $subject)
                @forelse($subject->schedules as $schedule)
                <tr>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->title }}</td>
                    <td>{{ $subject->units }}</td>
                    <td>{{ $subject->year_level }}</td>
                    <td>{{ $subject->semester }}</td>
                    <td>{{ $schedule->faculty->full_name ?? 'N/A' }}</td>
                    <td>{{ $schedule->section->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->title }}</td>
                    <td>{{ $subject->units }}</td>
                    <td>{{ $subject->year_level }}</td>
                    <td>{{ $subject->semester }}</td>
                    <td colspan="2" class="text-gray-400">Not assigned</td>
                </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>
</body>
</html>

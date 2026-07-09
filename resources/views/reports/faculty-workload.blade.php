<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Faculty Workload Report</title>
<style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #4f46e5; color: white; }
    h1 { text-align: center; color: #333; }
</style>
</head>
<body>
    <h1>Faculty Workload Report</h1>
    <table>
        <thead><tr><th>Faculty</th><th>Status</th><th>Rank</th><th>Max Load</th><th>Total Units</th></tr></thead>
        <tbody>
            @foreach($faculties as $f)
            <tr>
                <td>{{ $f->full_name }}</td>
                <td>{{ ucfirst($f->employment_status) }}</td>
                <td>{{ $f->academic_rank ?? 'N/A' }}</td>
                <td>{{ $f->max_load }}</td>
                <td>{{ $f->total_units }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

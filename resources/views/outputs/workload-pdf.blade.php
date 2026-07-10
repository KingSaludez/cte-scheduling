<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Faculty Workload - {{ $faculty->full_name }}</title>
<style>
    body { font-family: 'Times New Roman', serif; font-size: 12px; line-height:1.5; }
    h1 { text-align:center; font-size:16px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px; }
    .subtitle { text-align:center; font-size:12px; color:#555; margin-bottom:24px; }
    .info { width:100%; margin-bottom:16px; }
    .info td { padding:4px 8px; font-size:12px; }
    .info .val { border-bottom:1px solid #999; padding:0 8px; }
    .load-types { margin-bottom:20px; font-size:11px; }
    .load-types label { margin-right:16px; }
    table { width:100%; border-collapse:collapse; margin-bottom:16px; }
    th { background:#1e40af; color:#fff; padding:6px 8px; text-align:left; font-size:11px; border:1px solid #1e40af; }
    td { padding:5px 8px; border:1px solid #ccc; font-size:11px; }
    .totals { margin-bottom:24px; font-size:12px; }
    .totals div { margin-bottom:4px; }
    .sig { width:100%; margin-top:40px; border-top:2px solid #333; padding-top:24px; }
    .sig td { text-align:center; border:none; font-size:12px; }
    .sig .line { border-top:1px solid #333; padding-top:6px; margin-top:40px; font-weight:700; }
</style>
</head>
<body>
<h1>FACULTY WORKLOAD</h1>
<div class="subtitle">College of Teacher Education — NEMSU Tagbina Campus</div>

<table class="info">
    <tr><td width="150"><strong>Name:</strong></td><td class="val">{{ $faculty->full_name }}</td>
        <td width="150"><strong>Years in Service:</strong></td><td class="val">__________</td></tr>
    <tr><td><strong>Status:</strong></td><td class="val">{{ ucfirst($faculty->employment_status) }}</td>
        <td><strong>Educational Qualification:</strong></td><td class="val">{{ $faculty->educational_attainment ?? '—' }}</td></tr>
    <tr><td><strong>Major:</strong></td><td class="val">{{ $faculty->specialization ?? '—' }}</td>
        <td><strong>Academic Rank:</strong></td><td class="val">{{ $faculty->academic_rank ?? '—' }}</td></tr>
</table>

<div class="load-types">
    <label>☐ Regular Load: □ 15 □ 18</label>
    <label>☐ Overload: 9</label>
    <label>☐ Emergency Load: 3</label>
    <label>☐ Praise Load: 6</label>
</div>

<table>
    <thead><tr><th>Course No.</th><th>Description</th><th>Course/Year</th><th>No. of Students</th><th>Units</th><th>Room No.</th><th>Time and Day</th></tr></thead>
    <tbody>
        @forelse($faculty->schedules as $s)
        <tr>
            <td>{{ $s->subject->code ?? '—' }}</td>
            <td>{{ $s->subject->title ?? '—' }}</td>
            <td>{{ $s->section->name ?? '—' }}</td>
            <td style="text-align:center;">{{ $s->section->student_count ?? '—' }}</td>
            <td style="text-align:center;">{{ $s->subject->units ?? '—' }}</td>
            <td style="text-align:center;">{{ $s->room->room_number ?? '—' }}</td>
            <td>{{ $s->day }} {{ substr($s->start_time,0,5) }}-{{ substr($s->end_time,0,5) }}</td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#999;">No schedules assigned.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="totals">
    <div><strong>Total Units:</strong> {{ $totalUnits }}</div>
    <div><strong>Number of Preparations:</strong> {{ $preparations }}</div>
</div>

<div><strong>Additional Designation:</strong> ______________________________</div>
<div style="margin-bottom:32px;"><strong>Special Assignment:</strong> ______________________________</div>

<table class="sig">
    <tr><td style="width:33%;"><div class="line">Prepared by:</div></td>
        <td style="width:33%;"><div class="line">Checked by:</div></td>
        <td style="width:33%;"><div class="line">Noted by:</div></td></tr>
</table>
</body>
</html>
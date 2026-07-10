<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Class Program - {{ $program->name ?? $section->name }}</title>
<style>
    body { font-family: 'Times New Roman', serif; font-size: 12px; line-height:1.5; }
    h1 { text-align:center; font-size:16px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px; }
    .subtitle { text-align:center; font-size:12px; color:#555; margin-bottom:24px; }
    .info { width:100%; margin-bottom:20px; }
    .info td { padding:4px 8px; font-size:12px; }
    .info .val { border-bottom:1px solid #999; padding:0 8px; }
    table { width:100%; border-collapse:collapse; margin-bottom:20px; }
    th { background:#1e40af; color:#fff; padding:6px 8px; text-align:left; font-size:11px; border:1px solid #1e40af; }
    td { padding:5px 8px; border:1px solid #ccc; font-size:11px; }
    .sig { width:100%; margin-top:40px; border-top:2px solid #333; padding-top:24px; }
    .sig td { text-align:center; border:none; font-size:12px; }
    .sig .line { border-top:1px solid #333; padding-top:6px; margin-top:40px; font-weight:700; }
</style>
</head>
<body>
@php $p = $program ?? $section; $scheds = $schedules ?? collect(); @endphp
<h1>CLASS PROGRAM</h1>
<div class="subtitle">College of Teacher Education — NEMSU Tagbina Campus</div>

<table class="info">
    <tr><td width="180"><strong>Academic Year:</strong></td><td class="val">{{ $scheds->first()->academic_year ?? '—' }}</td>
        <td width="120"><strong>Semester:</strong></td><td class="val">{{ $scheds->first()->semester ?? '—' }}</td></tr>
    <tr><td><strong>Program, Year & Section:</strong></td><td class="val" colspan="3">{{ $p->name }}</td></tr>
</table>

<table>
    <thead><tr><th>Course Code</th><th>Title</th><th>Time</th><th>Day</th><th>Room</th><th>Units</th><th>Instructor</th></tr></thead>
    <tbody>
        @forelse($scheds as $s)
        <tr>
            <td>{{ $s->subject->code ?? '—' }}</td>
            <td>{{ $s->subject->title ?? '—' }}</td>
            <td>{{ substr($s->start_time,0,5) }}-{{ substr($s->end_time,0,5) }}</td>
            <td>{{ $s->day }}</td>
            <td>{{ $s->room->room_number ?? '—' }}</td>
            <td style="text-align:center;">{{ $s->subject->units ?? '—' }}</td>
            <td>{{ $s->faculty->full_name ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#999;">No schedules for this section.</td></tr>
        @endforelse
    </tbody>
</table>

<table class="sig">
    <tr><td style="width:33%;"><div class="line">Prepared by:</div></td>
        <td style="width:33%;"><div class="line">Checked by:</div></td>
        <td style="width:33%;"><div class="line">Noted by:</div></td></tr>
</table>
</body>
</html>
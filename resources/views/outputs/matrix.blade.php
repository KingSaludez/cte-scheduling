<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 16px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .topbar-brand { font-weight: 700; font-size: 18px; color: #1e40af; text-decoration: none; }
        .topbar-brand span { color: #94a3b8; }
        .hamburger { background: none; border: none; font-size: 24px; cursor: pointer; color: #475569; padding: 4px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-right .user-name { font-size: 14px; font-weight: 500; color: #475569; }
        .logout-form button { background: none; border: 1px solid #e2e8f0; color: #64748b; padding: 6px 14px; border-radius: 8px; font-size: 13px; font-family: inherit; cursor: pointer; transition: all 0.15s; }
        .logout-form button:hover { background: #f1f5f9; color: #ef4444; border-color: #fca5a5; }
        .sidebar { position: fixed; top: 60px; left: -260px; width: 260px; bottom: 0; background: #fff; border-right: 1px solid #e2e8f0; transition: left 0.2s; z-index: 40; overflow-y: auto; padding: 16px 0; }
        .sidebar.open { left: 0; }
        .sidebar-overlay { position: fixed; top: 60px; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 39; display: none; }
        .sidebar-overlay.show { display: block; }
        .sidebar a { display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #475569; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.15s; }
        .sidebar a:hover { background: #f1f5f9; color: #1e40af; }
        .sidebar a.active { background: #eff6ff; color: #1d4ed8; font-weight: 600; border-right: 3px solid #1d4ed8; }
        .sidebar a svg { width: 20px; height: 20px; flex-shrink: 0; }
        .sidebar .nav-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; padding: 16px 24px 6px; }
        .main { padding: 20px 16px 40px; max-width: 1400px; margin: 0 auto; }
        .page-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        .page-header h1 { font-size: 22px; font-weight: 700; color: #0f172a; }
        .page-header h1 span { color: #94a3b8; font-weight: 400; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: inherit; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #1d4ed8; color: #fff; box-shadow: 0 2px 8px rgba(29,78,216,0.2); }
        .btn-primary:hover { background: #1e40af; transform: translateY(-1px); }
        .btn-golden { background: #d97706; color: #fff; }
        .btn-golden:hover { background: #b45309; }
        .btn-sm { padding: 6px 14px; font-size: 13px; border-radius: 8px; }
        .btn-outline { background: transparent; color: #475569; border: 1.5px solid #e2e8f0; }
        .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .card-body { padding: 16px; }
        .filter-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-bottom: 12px; }
        .filter-form { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .filter-form input, .filter-form select { padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; }
        .filter-form input:focus, .filter-form select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .day-btn { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; border: 2px solid #e2e8f0; background: #fff; color: #475569; font-weight: 600; font-size: 14px; font-family: inherit; text-decoration: none; cursor: pointer; transition: all 0.15s; }
        .day-btn:hover { border-color: #60a5fa; color: #1d4ed8; }
        .day-btn.active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
        .info-text { font-size: 13px; color: #94a3b8; margin-bottom: 12px; }
        .info-text span { color: #1d4ed8; font-weight: 500; }
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 16px; display: none; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; display: block; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; display: block; }
        .alert-warning { background: #fef9c3; border: 1px solid #fde68a; color: #92400e; display: block; }
        .matrix-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .matrix { border-collapse: collapse; font-size: 11px; min-width: 800px; width: 100%; }
        .matrix th, .matrix td { border: 1px solid #e2e8f0; padding: 6px 8px; text-align: center; vertical-align: middle; }
        .matrix th { background: #1e40af; color: #fff; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; }
        .matrix .time-col { background: #f8fafc; font-weight: 600; color: #475569; white-space: nowrap; width: 80px; min-width: 80px; }
        .lunch-row td { background: #fef3c7; font-weight: 600; color: #92400e; font-size: 12px; }
        .lunch-row .time-col { background: #fde68a; }
        .slot-filled { padding: 4px 6px; border-radius: 4px; line-height: 1.3; cursor: pointer; transition: all 0.15s; }
        .slot-filled:hover { background: #dbeafe; }
        .slot-filled .subject-code { font-weight: 600; color: #1e40af; display: block; font-size: 11px; }
        .slot-filled .instructor { color: #64748b; font-size: 10px; display: block; }
        .slot-empty-cell { cursor: pointer; transition: all 0.15s; min-width: 80px; }
        .slot-empty-cell:hover { background: #eff6ff; }
        .slot-empty { color: #cbd5e1; font-size: 14px; font-weight: 500; }
        .matrix .day-header th { background: #1e40af; font-size: 13px; padding: 10px 8px; letter-spacing: 1px; }
        .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 60; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-overlay.show { display: flex; }
        .modal { background: #fff; border-radius: 16px; padding: 28px; width: 100%; max-width: 520px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 80px rgba(0,0,0,0.15); }
        .modal h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #0f172a; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; }
        .form-group input:focus, .form-group select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-group input[readonly] { background: #f1f5f9; color: #64748b; cursor: not-allowed; }
        .form-group select { cursor: pointer; }
        .day-checkboxes { display: flex; gap: 8px; flex-wrap: wrap; }
        .day-checkboxes label { display: flex; align-items: center; gap: 4px; font-size: 13px; font-weight: 500; color: #475569; cursor: pointer; }
        .day-checkboxes input[type="checkbox"] { width: auto; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; }
        .no-columns { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 15px; }
        @media (max-width: 1023px) {
            .matrix { font-size: 10px; }
            .matrix th, .matrix td { padding: 4px 6px; }
            .page-header h1 { font-size: 18px; }
        }
        @media (min-width: 1024px) { .sidebar { left: 0; } .hamburger { display: none; } .sidebar-overlay { display: none !important; } .main { margin-left: 260px; padding: 24px 32px; } }
        @media print {
            body { background: #fff; }
            .topbar, .sidebar, .sidebar-overlay, .filter-bar, .page-header .btn, .page-header h1 span, .info-text, .no-columns, .slot-empty-cell, .slot-empty { display: none !important; }
            .main { margin: 0; padding: 0.3in; max-width: none; }
            .card { box-shadow: none; border: 1px solid #ddd; border-radius: 0; }
            .card-body { padding: 0; }
            .matrix th { background: #1e40af !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .lunch-row td { background: #fef3c7 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .lunch-row .time-col { background: #fde68a !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .matrix .time-col { background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .matrix-wrap { overflow: visible; }
            .matrix { min-width: 100%; }
            @page { size: landscape; margin: 0.3in; }
        }
    </style>
</head>
<body>
<div class="topbar">
    <div style="display:flex;align-items:center;gap:12px;"><button class="hamburger" onclick="document.querySelector('.sidebar').classList.toggle('open');document.querySelector('.sidebar-overlay').classList.toggle('show');">☰</button><a href="{{ route('dashboard') }}" class="topbar-brand">CT<span>E</span></a></div>
    <div class="topbar-right"><span class="user-name">{{ Auth::user()->name }}</span><form method="POST" action="{{ route('logout') }}" class="logout-form">@csrf<button>Log out</button></form></div>
</div>
<div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('open');document.querySelector('.sidebar-overlay').classList.remove('show');"></div>
<nav class="sidebar" onclick="if(window.innerWidth<1024){document.querySelector('.sidebar').classList.remove('open');document.querySelector('.sidebar-overlay').classList.remove('show');}">
    <div class="nav-label">Menu</div>
    <a href="{{ route('dashboard') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a>
    <a href="{{ route('faculties.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Faculties</a>
    <a href="{{ route('programs.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>Programs</a>
    <a href="{{ route('sections.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Sections</a>
    <a href="{{ route('rooms.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Rooms</a>
    <a href="{{ route('schedules.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Schedules</a>
    <a href="{{ route('outputs.matrix') }}" class="active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>Master Matrix</a>
    <a href="{{ route('outputs.workload') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Workload Forms</a>
    <a href="{{ route('outputs.class-program') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>Class Programs</a>
    <a href="{{ route('archives.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>Archives</a>
</nav>
<div class="main">
    <div class="page-header">
        <h1>{{ $pageTitle }} <span>· {{ $selectedDay }}</span></h1>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('outputs.matrix', array_merge(request()->query(), ['pdf' => 1])) }}" class="btn btn-golden btn-sm">📄 Export PDF</a>
            <a href="#" onclick="window.print();return false;" class="btn btn-primary btn-sm">🖨️ Print</a>
        </div>
    </div>

    <div class="card"><div class="card-body">
        <div class="filter-bar">
            @foreach($dayLabels as $code => $label)
                <a href="{{ route('outputs.matrix', ['day' => $code, 'academic_year' => $academicYear, 'semester' => $semester]) }}" class="day-btn {{ $selectedDayCode === $code ? 'active' : '' }}" title="{{ $label }}">{{ $code }}</a>
            @endforeach
            <form method="GET" action="{{ route('outputs.matrix') }}" class="filter-form">
                <input type="hidden" name="day" value="{{ $selectedDayCode }}">
                <input type="text" name="academic_year" value="{{ $academicYear }}" placeholder="A.Y. (e.g. 2024-2025)" style="width:140px;">
                <select name="semester">
                    <option value="1st" {{ $semester === '1st' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd" {{ $semester === '2nd' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="summer" {{ $semester === 'summer' ? 'selected' : '' }}>Summer</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Go</button>
            </form>
        </div>

        <div class="info-text"><span>Add manually:</span> Click any empty cell (<span>+</span>) to add a schedule entry. Click existing entries to delete.</div>

        <div id="alertContainer"></div>

        @if(count($columns) === 0)
            <div class="no-columns">
                <p>No sections assigned to rooms yet.</p>
                <p style="font-size:13px;margin-top:8px;">Assign sections to rooms first, then the matrix will display here.</p>
            </div>
        @else
            @php
                $lunchSlots = ['12:00', '12:30'];
                $cellStates = [];
                $cellMeta = [];

                foreach ($columns as $col) {
                    $key = $col['key'];
                    $scheds = $matrix[$key] ?? [];
                    $states = [];
                    $meta = [];

                    foreach ($timeSlots as $t) {
                        $states[$t] = in_array($t, $lunchSlots) ? 'lunch' : 'empty';
                        $meta[$t] = null;
                    }

                    foreach ($scheds as $startTime => $sched) {
                        $startIdx = array_search($startTime, $timeSlots);
                        if ($startIdx === false) continue;
                        $endIdx = array_search($sched->end_time, $timeSlots);
                        if ($endIdx === false || $endIdx <= $startIdx) $endIdx = count($timeSlots);

                        $lunchIdx = array_search('12:00', $timeSlots);
                        if ($lunchIdx !== false && $startIdx < $lunchIdx && $endIdx > $lunchIdx) {
                            $endIdx = $lunchIdx;
                        }

                        $rowspan = $endIdx - $startIdx;
                        if ($rowspan <= 0) continue;

                        $states[$startTime] = 'schedule';
                        $meta[$startTime] = ['schedule' => $sched, 'rowspan' => $rowspan];
                        for ($j = $startIdx + 1; $j < $endIdx; $j++) {
                            if (!in_array($timeSlots[$j], $lunchSlots)) {
                                $states[$timeSlots[$j]] = 'skip';
                            }
                        }
                    }

                    $cellStates[$key] = $states;
                    $cellMeta[$key] = $meta;
                }
            @endphp

            <div class="matrix-wrap">
                <table class="matrix">
                    <thead>
                        <tr class="day-header"><th colspan="{{ count($columns) + 1 }}" style="text-align:center;">{{ $selectedDay }} — Master Schedule Matrix</th></tr>
                        <tr>
                            <th style="width:80px;min-width:80px;">Time</th>
                            @foreach($columns as $col)
                                <th>{{ $col['room']->room_number }} | {{ $col['section']->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $i => $time)
                            @php $isLunch = in_array($time, $lunchSlots); @endphp
                            <tr class="{{ $isLunch ? 'lunch-row' : '' }}">
                                <td class="time-col">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</td>
                                @if($isLunch)
                                    <td colspan="{{ count($columns) }}" style="text-align:center;font-weight:600;">🍽️ LUNCH BREAK</td>
                                @else
                                    @foreach($columns as $col)
                                        @php
                                            $key = $col['key'];
                                            $state = $cellStates[$key][$time] ?? 'empty';
                                        @endphp
                                        @if($state === 'skip')
                                        @elseif($state === 'schedule')
                                            @php $info = $cellMeta[$key][$time] ?? null; @endphp
                                            @if($info)
                                                <td rowspan="{{ $info['rowspan'] }}" style="background:#eff6ff;padding:4px 6px;cursor:pointer;vertical-align:middle;" onclick="confirmDelete({{ $info['schedule']->id }})">
                                                    <div class="slot-filled">
                                                        <span class="subject-code">{{ $info['schedule']->subject->code ?? '—' }}</span>
                                                        <span class="instructor">{{ $info['schedule']->faculty->full_name ?? '—' }}</span>
                                                    </div>
                                                </td>
                                            @endif
                                        @else
                                            <td class="slot-empty-cell" onclick="openAddModal('{{ $key }}', '{{ $time }}', '{{ addslashes($col['section']->name) }}')">
                                                <span class="slot-empty">+</span>
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div></div>
</div>

<div id="addModal" class="modal-overlay">
    <div class="modal">
        <h2>Add Schedule Entry</h2>
        <form id="addForm">
            <input type="hidden" name="section_id" id="add_section_id">
            <input type="hidden" name="start_time" id="add_start_time">
            <input type="hidden" name="academic_year" value="{{ $academicYear }}">
            <input type="hidden" name="semester" value="{{ $semester }}">

            <div class="form-group">
                <label>Section</label>
                <input type="text" id="add_section_display" readonly>
            </div>
            <div class="form-group">
                <label>Day</label>
                <div class="day-checkboxes">
                    @foreach($dayLabels as $code => $label)
                        <label><input type="checkbox" name="days[]" value="{{ $code }}" {{ $selectedDayCode === $code ? 'checked' : '' }}> {{ $code }}</label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="text" id="add_start_time_display" readonly>
            </div>
            <div class="form-group">
                <label>End Time</label>
                <select name="end_time" id="add_end_time" required></select>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select name="subject_id" required>
                    <option value="">— Select Subject —</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->code }} — {{ $subject->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Instructor</label>
                <select name="faculty_id" required>
                    <option value="">— Select Instructor —</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->faculty_id }}">{{ $faculty->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="font-size:13px;color:#64748b;">
                Academic Year: <strong>{{ $academicYear }}</strong> &middot; Semester: <strong>{{ $semester }}</strong>
            </div>
            <div id="add_warnings" class="alert-warning" style="display:none;margin-bottom:12px;"></div>
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Schedule</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const timeSlots = {!! json_encode($timeSlots) !!};
    const lunchSlots = ['12:00', '12:30'];
    const storeUrl = '{{ route('outputs.matrix.store') }}';
    const destroyUrlBase = '{{ route('outputs.matrix.destroy', '__ID__') }}';

    function formatTime(time) {
        const parts = time.split(':');
        const h = parseInt(parts[0], 10);
        const m = parts[1];
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        return h12 + ':' + m + ' ' + ampm;
    }

    function showAlert(message, type) {
        const container = document.getElementById('alertContainer');
        const div = document.createElement('div');
        div.className = 'alert alert-' + type;
        div.textContent = message;
        container.appendChild(div);
        setTimeout(function() { div.remove(); }, 5000);
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.remove('show');
        document.getElementById('add_warnings').style.display = 'none';
    }

    function openAddModal(columnKey, startTime, sectionName) {
        const parts = columnKey.split('-');
        const sectionId = parts[0];

        document.getElementById('add_section_id').value = sectionId;
        document.getElementById('add_section_display').value = sectionName;
        document.getElementById('add_start_time').value = startTime;
        document.getElementById('add_start_time_display').value = formatTime(startTime);

        const endSelect = document.getElementById('add_end_time');
        endSelect.innerHTML = '<option value="">— Select End Time —</option>';
        const startIdx = timeSlots.indexOf(startTime);
        if (startIdx >= 0) {
            for (var i = startIdx + 1; i < timeSlots.length; i++) {
                var t = timeSlots[i];
                if (lunchSlots.indexOf(t) !== -1) continue;
                var opt = document.createElement('option');
                opt.value = t;
                opt.textContent = formatTime(t);
                endSelect.appendChild(opt);
            }
        }

        document.getElementById('add_warnings').style.display = 'none';
        document.getElementById('addModal').classList.add('show');
    }

    function confirmDelete(scheduleId) {
        if (!confirm('Delete this schedule entry?')) return;
        fetch(destroyUrlBase.replace('__ID__', scheduleId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showAlert('Schedule deleted successfully!', 'success');
                setTimeout(function() { location.reload(); }, 800);
            } else {
                showAlert('Error: ' + (data.error || 'Could not delete schedule.'), 'error');
            }
        })
        .catch(function() {
            showAlert('Network error while deleting schedule.', 'error');
        });
    }

    document.getElementById('addForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var data = {};
        var days = [];
        var inputs = form.querySelectorAll('input, select');
        for (var i = 0; i < inputs.length; i++) {
            var el = inputs[i];
            if (el.type === 'checkbox' && el.name === 'days[]') {
                if (el.checked) days.push(el.value);
            } else if (el.type !== 'checkbox') {
                data[el.name] = el.value;
            }
        }
        data['days'] = days;

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(r) {
            if (!r.ok) {
                return r.json().then(function(e) { throw e; });
            }
            return r.json();
        })
        .then(function(resp) {
            if (resp.warnings) {
                var warnEl = document.getElementById('add_warnings');
                warnEl.textContent = resp.warnings;
                warnEl.style.display = 'block';
            }
            if (resp.success) {
                showAlert(resp.count + ' schedule(s) added successfully!', 'success');
                closeAddModal();
                setTimeout(function() { location.reload(); }, 800);
            }
        })
        .catch(function(err) {
            var msg = 'An error occurred.';
            if (err && err.errors) {
                msg = Object.values(err.errors).flat().join('. ');
            } else if (err && err.error) {
                msg = err.error;
            }
            showAlert(msg, 'error');
        });
    });

    window.openAddModal = openAddModal;
    window.closeAddModal = closeAddModal;
    window.confirmDelete = confirmDelete;
})();
</script>
</body>
</html>

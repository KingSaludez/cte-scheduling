<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Schedule Matrix - {{ config('app.name') }}</title>
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
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .card-body { padding: 20px; }
        .filter-bar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
        .filter-bar select { padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; }
        .filter-bar select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .filter-bar .btn { flex: 0 0 auto; }
        .matrix-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .matrix { border-collapse: collapse; font-size: 11px; min-width: 900px; width: 100%; }
        .matrix th, .matrix td { border: 1px solid #e2e8f0; padding: 6px 8px; text-align: center; vertical-align: middle; }
        .matrix th { background: #1e40af; color: #fff; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; }
        .matrix .time-col { background: #f8fafc; font-weight: 600; color: #475569; white-space: nowrap; width: 80px; }
        .matrix .lunch-row td { background: #fef3c7; font-weight: 600; color: #92400e; font-size: 12px; }
        .matrix .lunch-row .time-col { background: #fde68a; }
        .slot-filled { background: #eff6ff; padding: 4px 6px; border-radius: 4px; line-height: 1.4; }
        .slot-filled .section-name { font-weight: 700; color: #1e40af; display: block; }
        .slot-filled .subject-code { color: #475569; font-size: 10px; }
        .slot-filled .instructor { color: #64748b; font-size: 10px; font-style: italic; }
        .slot-empty { color: #cbd5e1; font-size: 11px; }
        .matrix .day-header th { background: #1e40af; font-size: 13px; padding: 10px 8px; letter-spacing: 1px; }
        @media print {
            body { background: #fff; }
            .topbar, .sidebar, .sidebar-overlay, .filter-bar, .page-header .btn { display: none !important; }
            .main { margin: 0; padding: 0.5in; max-width: none; }
            .card { box-shadow: none; border: 1px solid #ddd; border-radius: 0; }
            .matrix th { background: #1e40af !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .matrix .lunch-row td { background: #fef3c7 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .matrix .lunch-row .time-col { background: #fde68a !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .slot-filled { background: #eff6ff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .matrix .time-col { background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @page { size: landscape; margin: 0.5in; }
        }
        @media (min-width: 1024px) { .sidebar { left: 0; } .hamburger { display: none; } .sidebar-overlay { display: none !important; } .main { margin-left: 260px; padding: 24px 32px; } }
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
    @if(Auth::user()->role !== 'faculty')<a href="{{ route('faculties.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Faculties</a>@endif
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
        <h1>Master Schedule Matrix <span>· Room × Time grid</span></h1>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <form method="GET" action="{{ route('outputs.matrix') }}" style="display:contents;">
                <select name="day">
                    @foreach($days as $d)
                        <option value="{{ $d }}" {{ $selectedDay == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="padding:8px 14px;">View</button>
            </form>
            <a href="{{ route('outputs.matrix', ['day' => $selectedDay, 'pdf' => 1]) }}" class="btn btn-golden btn-sm">📄 Export PDF</a>
            <a href="#" onclick="window.print();return false;" class="btn btn-primary btn-sm">🖨️ Print</a>
        </div>
    </div>

    <div class="card"><div class="card-body" style="padding:16px;">
        <div class="matrix-wrap">
            <table class="matrix">
                <thead>
                    <tr class="day-header"><th colspan="{{ count($rooms) + 1 }}" style="text-align:center;">{{ $selectedDay }} — Master Schedule Matrix</th></tr>
                    <tr>
                        <th style="width:80px;">Time</th>
                        @foreach($rooms as $room)
                            <th>{{ $room->room_number }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeSlots as $i => $time)
                        @php $nextTime = $timeSlots[$i + 1] ?? '18:00'; $isLunch = $time === '12:00'; @endphp
                        <tr class="{{ $isLunch ? 'lunch-row' : '' }}">
                            <td class="time-col">{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</td>
                            @if($isLunch)
                                <td colspan="{{ count($rooms) }}" style="text-align:center;font-weight:600;">🍽️ LUNCH BREAK</td>
                            @else
                                @foreach($rooms as $room)
                                    <td>
                                        @php
                                            $schedule = $matrix[$selectedDay][$room->id][$time] ?? null;
                                        @endphp
                                        @if($schedule)
                                            <div class="slot-filled">
                                                <span class="section-name">{{ $schedule->section->name ?? '—' }}</span>
                                                <span class="subject-code">{{ $schedule->subject->code ?? '—' }}</span>
                                                <span class="instructor">{{ $schedule->faculty->full_name ?? '—' }}</span>
                                            </div>
                                        @else
                                            <span class="slot-empty">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div></div>
</div>
</body>
</html>
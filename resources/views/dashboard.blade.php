<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ config('app.name', 'CTE NEMSU Tagbina') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
        .main { padding: 20px 16px 40px; max-width: 1280px; margin: 0 auto; }
        .page-header h1 { font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        .page-header h1 span { color: #94a3b8; font-weight: 400; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .card-body { padding: 20px; }
        .stat-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); padding: 20px; text-align: center; position: relative; overflow: hidden; }
        .stat-card .num { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .stat-card .label { font-size: 13px; color: #64748b; margin-top: 4px; font-weight: 500; }
        .stat-card .bar { position: absolute; top: 0; left: 0; right: 0; height: 4px; }
        .bar-primary { background: #1d4ed8; } .bar-golden { background: #d97706; } .bar-green { background: #16a34a; }
        .load-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); padding: 24px; border-top: 4px solid #1d4ed8; }
        .load-card.border-golden { border-top-color: #d97706; }
        .load-card h3 { font-size: 16px; font-weight: 600; margin-bottom: 16px; }
        .load-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .load-row:last-child { border-bottom: none; }
        .load-row dt { color: #64748b; }
        .load-row dd { font-weight: 600; }
        .badge { display: inline-block; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-golden { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .schedule-list { margin-top: 12px; }
        .schedule-day { margin-bottom: 16px; }
        .schedule-day h4 { font-size: 14px; font-weight: 600; color: #1e40af; margin-bottom: 8px; }
        .schedule-item { font-size: 13px; color: #475569; padding: 6px 0 6px 12px; border-left: 3px solid #93c5fd; margin-bottom: 4px; }
        .status-section { margin-top: 24px; }
        .status-section h3 { font-size: 16px; font-weight: 600; color: #1e40af; margin-bottom: 12px; }
        .status-row { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .status-row .label { font-size: 13px; color: #64748b; width: 90px; flex-shrink: 0; }
        .status-bar-bg { flex: 1; background: #e2e8f0; border-radius: 20px; height: 10px; overflow: hidden; }
        .status-bar-fill { height: 100%; border-radius: 20px; transition: width 0.3s; }
        .status-bar-fill.bar-blue { background: #1d4ed8; }
        .status-bar-fill.bar-golden { background: #d97706; }
        .status-bar-fill.bar-green { background: #16a34a; }
        .status-row .count { font-size: 13px; font-weight: 600; width: 30px; text-align: right; }
        @media (min-width: 1024px) {
            .sidebar { left: 0; } .hamburger { display: none; } .sidebar-overlay { display: none !important; } .main { margin-left: 260px; padding: 24px 32px; }
            .stat-grid { grid-template-columns: repeat(6, 1fr); }
        }
        @media (min-width: 640px) and (max-width: 1023px) {
            .stat-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div style="display:flex;align-items:center;gap:12px;">
        <button class="hamburger" onclick="document.querySelector('.sidebar').classList.toggle('open');document.querySelector('.sidebar-overlay').classList.toggle('show');">☰</button>
        <a href="{{ route('dashboard') }}" class="topbar-brand">CT<span>E</span></a>
    </div>
    <div class="topbar-right">
        <span class="user-name">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">@csrf<button>Log out</button></form>
    </div>
</div>

<div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('open');document.querySelector('.sidebar-overlay').classList.remove('show');"></div>
<nav class="sidebar" onclick="if(window.innerWidth<1024){document.querySelector('.sidebar').classList.remove('open');document.querySelector('.sidebar-overlay').classList.remove('show');}">
    <div class="nav-label">Menu</div>
    <a href="{{ route('dashboard') }}" class="active">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard</a>
    <a href="{{ route('faculties.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Faculties</a>
    <a href="{{ route('programs.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Programs</a>
    <a href="{{ route('sections.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Sections</a>
    <a href="{{ route('rooms.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Rooms</a>
    <a href="{{ route('schedules.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Schedules</a>
    <a href="{{ route('outputs.matrix') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg> Master Matrix</a>
    <a href="{{ route('outputs.workload') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Workload Forms</a>
    <a href="{{ route('outputs.class-program') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg> Class Programs</a>
    <a href="{{ route('archives.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg> Archives</a>
</nav>

<div class="main">
    <div class="page-header">
        <h1>Dashboard <span>· Overview</span></h1>
    </div>

    @if(isset($stats))
        <div class="stat-grid">
            <div class="stat-card"><div class="bar bar-primary"></div><div class="num" style="color:#1d4ed8">{{ $stats['faculty_count'] }}</div><div class="label">Faculty</div></div>
            <div class="stat-card"><div class="bar bar-primary"></div><div class="num" style="color:#1d4ed8">{{ $stats['subject_count'] }}</div><div class="label">Subjects</div></div>
            <div class="stat-card"><div class="bar bar-primary"></div><div class="num" style="color:#1d4ed8">{{ $stats['section_count'] }}</div><div class="label">Sections</div></div>
            <div class="stat-card"><div class="bar bar-primary"></div><div class="num" style="color:#1d4ed8">{{ $stats['room_count'] }}</div><div class="label">Rooms</div></div>
            <div class="stat-card"><div class="bar bar-golden"></div><div class="num" style="color:#d97706">{{ $stats['draft_schedules'] + $stats['generated_schedules'] }}</div><div class="label">Pending Schedules</div></div>
            <div class="stat-card"><div class="bar bar-green"></div><div class="num" style="color:#16a34a">{{ $stats['finalized_schedules'] }}</div><div class="label">Finalized</div></div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="status-section"><h3>Schedule Status Overview</h3></div>
                @php $total = $stats['draft_schedules'] + $stats['generated_schedules'] + $stats['reviewed_schedules'] + $stats['approved_schedules'] + $stats['finalized_schedules']; @endphp
                @foreach(['draft', 'generated', 'reviewed', 'approved', 'finalized'] as $status)
                <div class="status-row">
                    <span class="label">{{ ucfirst($status) }}</span>
                    <div class="status-bar-bg"><div class="status-bar-fill {{ $status === 'finalized' ? 'bar-green' : ($status === 'approved' ? 'bar-blue' : 'bar-golden') }}" style="width: {{ $total > 0 ? round(($stats[$status.'_schedules'] / $total) * 100) : 0 }}%"></div></div>
                    <span class="count">{{ $stats[$status.'_schedules'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div style="display:grid;grid-template-columns:1fr;gap:20px;">
            <div class="load-card">
                <h3>My Load Summary</h3>
                <div class="load-row"><dt>Total Units</dt><dd style="color:#1d4ed8">{{ $load['total_units'] }}</dd></div>
                <div class="load-row"><dt>Max Load</dt><dd>{{ $load['max_load'] }}</dd></div>
                <div class="load-row"><dt>Remaining</dt><dd style="color:#16a34a">{{ $load['remaining'] }}</dd></div>
                <div class="load-row"><dt>Classification</dt><dd><span class="badge {{ $load['classification'] == 'regular' ? 'badge-green' : ($load['classification'] == 'overload' ? 'badge-golden' : 'badge-red') }}">{{ $load['classification'] }}</span></dd></div>
                <div class="load-row"><dt>Schedules</dt><dd>{{ $load['schedule_count'] }}</dd></div>
            </div>
            <div class="load-card border-golden">
                <h3 style="color:#92400e">Weekly Schedule</h3>
                @forelse($weeklySchedule as $day => $daySchedules)
                <div class="schedule-day">
                    <h4>{{ $day }}</h4>
                    @foreach($daySchedules as $s)
                    <div class="schedule-item">{{ $s->start_time }}-{{ $s->end_time }} | {{ $s->subject->code ?? 'N/A' }} | {{ $s->section->name ?? 'N/A' }} | {{ $s->room->room_number ?? 'N/A' }}</div>
                    @endforeach
                </div>
                @empty
                <p style="font-size:14px;color:#94a3b8;">No schedules assigned.</p>
                @endforelse
            </div>
        </div>
    @endif
</div>

</body>
</html>
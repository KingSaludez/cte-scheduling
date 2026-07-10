<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Schedules - {{ config('app.name', 'CTE NEMSU Tagbina') }}</title>
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
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 16px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .filter-bar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
        .filter-bar input, .filter-bar select { padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; flex: 1; min-width: 140px; }
        .filter-bar input:focus, .filter-bar select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .filter-bar .btn { flex: 0 0 auto; }
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; margin: 0 -4px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; min-width: 700px; }
        thead { background: #f8fafc; }
        th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; }
        td { padding: 12px 16px; border-top: 1px solid #f1f5f9; color: #334155; }
        tr:hover td { background: #f8fafc; }
        .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .empty { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 14px; }
        .pagination { margin-top: 16px; display: flex; flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; color: #475569; text-decoration: none; transition: all 0.15s; }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
        .badge { display: inline-block; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-golden { background: #fef3c7; color: #92400e; }
        @media (min-width: 1024px) { .sidebar { left: 0; } .hamburger { display: none; } .sidebar-overlay { display: none !important; } .main { margin-left: 260px; padding: 24px 32px; } }
        @media (max-width: 639px) { .page-header h1 { font-size: 18px; } .filter-bar { flex-direction: column; } .filter-bar input, .filter-bar select { min-width: 0; } .card-body { padding: 14px; } }
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
    <a href="{{ route('programs.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Programs</a>
    <a href="{{ route('sections.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Sections</a>
    <a href="{{ route('rooms.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Rooms</a>
    <a href="{{ route('schedules.index') }}" class="active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Schedules</a>
    <a href="{{ route('outputs.matrix') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>Master Matrix</a>
    <a href="{{ route('outputs.workload') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Workload Forms</a>
    <a href="{{ route('outputs.class-program') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>Class Programs</a>
    <a href="{{ route('archives.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>Archives</a>
</nav>
<div class="main">
    <div class="page-header"><h1>Schedules <span>· Manage schedules</span></h1><a href="{{ route('schedules.create') }}" class="btn btn-golden">+ Generate Schedule</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card"><div class="card-body">
        <form method="GET" class="filter-bar">
            <input type="text" name="academic_year" placeholder="Academic Year" value="{{ request('academic_year') }}">
            <select name="semester"><option value="">All Semesters</option><option value="1st" @selected(request('semester') == '1st')>1st</option><option value="2nd" @selected(request('semester') == '2nd')>2nd</option><option value="summer" @selected(request('semester') == 'summer')>Summer</option></select>
            <select name="status"><option value="">All Status</option><option value="draft" @selected(request('status') == 'draft')>Draft</option><option value="generated" @selected(request('status') == 'generated')>Generated</option><option value="reviewed" @selected(request('status') == 'reviewed')>Reviewed</option><option value="approved" @selected(request('status') == 'approved')>Approved</option><option value="finalized" @selected(request('status') == 'finalized')>Finalized</option></select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
        <div class="table-wrap"><table><thead><tr><th>Faculty</th><th>Subject</th><th>Section</th><th>Room</th><th>Day</th><th>Time</th><th>Status</th><th>Actions</th></tr></thead><tbody>@forelse($schedules as $schedule)<tr><td>{{ $schedule->faculty->full_name ?? 'N/A' }}</td><td>{{ $schedule->subject->code ?? 'N/A' }}</td><td>{{ $schedule->section->name ?? 'N/A' }}</td><td>{{ $schedule->room->room_number ?? 'N/A' }}</td><td>{{ $schedule->day }}</td><td>{{ $schedule->start_time }}-{{ $schedule->end_time }}</td><td><span class="badge {{ $schedule->status === 'finalized' ? 'badge-green' : ($schedule->status === 'approved' ? 'badge-primary' : 'badge-golden') }}">{{ ucfirst($schedule->status) }}</span></td><td><a href="{{ route('schedules.show', $schedule) }}" class="btn btn-primary btn-sm">Show</a></td></tr>@empty<tr><td colspan="8"><div class="empty">No schedules found.</div></td></tr>@endforelse</tbody></table></div>
        <div class="pagination">{{ $schedules->appends(request()->query())->links() }}</div>
    </div></div>
</div>
</body>
</html>
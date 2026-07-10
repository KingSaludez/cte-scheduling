<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Faculty Workload - {{ config('app.name') }}</title>
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
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: inherit; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #1d4ed8; color: #fff; box-shadow: 0 2px 8px rgba(29,78,216,0.2); }
        .btn-primary:hover { background: #1e40af; transform: translateY(-1px); }
        .btn-golden { background: #d97706; color: #fff; }
        .btn-golden:hover { background: #b45309; }
        .btn-sm { padding: 6px 14px; font-size: 13px; border-radius: 8px; }
        .pagination { margin-top: 16px; display: flex; flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; color: #475569; text-decoration: none; transition: all 0.15s; }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .card-body { padding: 20px; }
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
    <a href="{{ route('faculties.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Faculties</a>
    <a href="{{ route('sections.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Sections</a>
    <a href="{{ route('rooms.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Rooms</a>
    <a href="{{ route('schedules.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Schedules</a>
    <a href="{{ route('outputs.matrix') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>Master Matrix</a>
    <a href="{{ route('outputs.workload') }}" class="active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Workload Forms</a>
    <a href="{{ route('outputs.class-program') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>Class Programs</a>
    <a href="{{ route('archives.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>Archives</a>
</nav>
<div class="main">
    <div class="page-header"><h1>Faculty Workload Forms</h1></div>

        @foreach($faculties as $faculty)
        @php
            $totalUnits = $faculty->schedules->sum(fn($s) => $s->subject->units ?? 0);
            $preparations = $faculty->schedules->pluck('subject_id')->unique()->count();
        @endphp
        <div class="card" style="margin-bottom:32px;">
            <div class="card-body">
                <div style="text-align:center;margin-bottom:24px;">
                    <h2 style="font-size:18px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:0.5px;">FACULTY WORKLOAD</h2>
                    <p style="font-size:13px;color:#64748b;">College of Teacher Education — NEMSU Tagbina Campus</p>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;font-size:14px;">
                    <div><strong>Name:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">{{ $faculty->full_name }}</span></div>
                    <div><strong>Years in Service:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">__________</span></div>
                    <div><strong>Status:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">{{ ucfirst($faculty->employment_status) }}</span></div>
                    <div><strong>Educational Qualification:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">{{ $faculty->educational_attainment ?? '—' }}</span></div>
                    <div><strong>Major:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">{{ $faculty->specialization ?? '—' }}</span></div>
                    <div><strong>Academic Rank:</strong> <span style="border-bottom:1px solid #94a3b8;padding:0 8px;">{{ $faculty->academic_rank ?? '—' }}</span></div>
                </div>

                <div style="display:flex;gap:24px;margin-bottom:24px;font-size:14px;flex-wrap:wrap;">
                    <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" disabled {{ in_array($faculty->max_load, [15, 18]) ? 'checked' : '' }}> Regular Load: □ 15 □ 18</label>
                    <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" disabled {{ $totalUnits > ($faculty->max_load ?? 18) ? 'checked' : '' }}> Overload: 9</label>
                    <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" disabled> Emergency Load: 3</label>
                    <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" disabled> Praise Load: 6</label>
                </div>

                <table style="width:100%;border-collapse:collapse;font-size:12px;margin-bottom:16px;">
                    <thead>
                        <tr style="background:#1e40af;color:#fff;">
                            <th style="padding:8px 10px;text-align:left;border:1px solid #1e40af;">Course No.</th>
                            <th style="padding:8px 10px;text-align:left;border:1px solid #1e40af;">Description</th>
                            <th style="padding:8px 10px;text-align:left;border:1px solid #1e40af;">Course/Year</th>
                            <th style="padding:8px 10px;text-align:center;border:1px solid #1e40af;">No. of Students</th>
                            <th style="padding:8px 10px;text-align:center;border:1px solid #1e40af;">Units</th>
                            <th style="padding:8px 10px;text-align:center;border:1px solid #1e40af;">Room No.</th>
                            <th style="padding:8px 10px;text-align:center;border:1px solid #1e40af;">Time and Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculty->schedules as $s)
                        <tr>
                            <td style="padding:6px 10px;border:1px solid #e2e8f0;">{{ $s->subject->code ?? '—' }}</td>
                            <td style="padding:6px 10px;border:1px solid #e2e8f0;">{{ $s->subject->title ?? '—' }}</td>
                            <td style="padding:6px 10px;border:1px solid #e2e8f0;">{{ $s->section->name ?? '—' }}</td>
                            <td style="padding:6px 10px;text-align:center;border:1px solid #e2e8f0;">{{ $s->section->student_count ?? '—' }}</td>
                            <td style="padding:6px 10px;text-align:center;border:1px solid #e2e8f0;">{{ $s->subject->units ?? '—' }}</td>
                            <td style="padding:6px 10px;text-align:center;border:1px solid #e2e8f0;">{{ $s->room->room_number ?? '—' }}</td>
                            <td style="padding:6px 10px;text-align:center;border:1px solid #e2e8f0;">{{ $s->day }} {{ substr($s->start_time, 0, 5) }}-{{ substr($s->end_time, 0, 5) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="padding:20px;text-align:center;border:1px solid #e2e8f0;color:#94a3b8;">No schedules assigned.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;font-size:13px;margin-bottom:24px;">
                    <div><strong>Total Units:</strong> {{ $totalUnits }}</div>
                    <div><strong>Number of Preparations:</strong> {{ $preparations }}</div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;font-size:13px;margin-bottom:32px;">
                    <div><strong>Additional Designation:</strong> ______________________________</div>
                    <div><strong>Special Assignment:</strong> ______________________________</div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;font-size:13px;margin-top:32px;padding-top:16px;border-top:2px solid #e2e8f0;">
                    <div style="text-align:center;">
                        <div style="margin-top:40px;border-top:1px solid #1e293b;padding-top:6px;font-weight:600;">Prepared by:</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="margin-top:40px;border-top:1px solid #1e293b;padding-top:6px;font-weight:600;">Checked by:</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="margin-top:40px;border-top:1px solid #1e293b;padding-top:6px;font-weight:600;">Noted by:</div>
                    </div>
                </div>

                <div style="text-align:right;margin-top:16px;">
                    <a href="{{ route('outputs.workload-pdf', $faculty) }}" class="btn btn-golden btn-sm">📄 Download PDF</a>
                </div>
            </div>
        </div>
    @endforeach

    <div class="pagination">{{ $faculties->links() }}</div>
</div>
</body>
</html>
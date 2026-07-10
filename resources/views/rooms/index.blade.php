<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rooms - {{ config('app.name', 'CTE NEMSU Tagbina') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"></noscript>
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
        .btn-sm { padding: 6px 14px; font-size: 13px; border-radius: 8px; }
        .btn-xs { padding: 4px 10px; font-size: 12px; border-radius: 6px; }
        .btn-warning { background: #d97706; color: #fff; }
        .btn-warning:hover { background: #b45309; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline { background: transparent; color: #475569; border: 1.5px solid #e2e8f0; }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .card-body { padding: 20px; }
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 16px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .filter-bar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
        .filter-bar input, .filter-bar select { padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; flex: 1; min-width: 140px; }
        .filter-bar input:focus, .filter-bar select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .filter-bar .btn { flex: 0 0 auto; }
        .empty { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 14px; }
        .pagination { margin-top: 16px; display: flex; flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; color: #475569; text-decoration: none; transition: all 0.15s; }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
        .badge { display: inline-block; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-golden { background: #fef3c7; color: #92400e; }
        .badge-blue { background: #e0f2fe; color: #075985; }
        .room-grid { display: flex; flex-direction: column; gap: 16px; }
        .room-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; transition: box-shadow 0.15s; }
        .room-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .room-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; padding: 18px 20px; border-bottom: 1px solid #f1f5f9; }
        .room-info { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .room-info .room-number { font-size: 18px; font-weight: 700; color: #0f172a; }
        .room-info .room-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; font-size: 13px; color: #64748b; }
        .room-info .room-meta span { display: flex; align-items: center; gap: 4px; }
        .room-header-actions { display: flex; flex-wrap: wrap; gap: 6px; }
        .sections-area { padding: 14px 20px 18px; }
        .sections-area .label { font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .sections-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .section-pill { display: inline-flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; padding: 4px 4px 4px 14px; font-size: 13px; color: #334155; transition: all 0.15s; }
        .section-pill:hover { background: #f1f5f9; }
        .section-pill .sec-name { font-weight: 600; }
        .section-pill .sec-year { color: #64748b; font-size: 12px; }
        .section-pill .sec-students { color: #64748b; font-size: 12px; }
        .section-pill .sec-delete { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; border: none; background: transparent; color: #94a3b8; cursor: pointer; font-size: 16px; transition: all 0.15s; }
        .section-pill .sec-delete:hover { background: #fee2e2; color: #ef4444; }
        .no-sections { font-size: 13px; color: #94a3b8; font-style: italic; }
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 100; display: none; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.show { display: flex; }
        .modal { background: #fff; border-radius: 20px; width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.15); padding: 28px; animation: modalIn 0.15s ease-out; }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal h2 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        .modal .form-group { margin-bottom: 16px; }
        .modal .form-group label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .modal .form-group input, .modal .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.15s; }
        .modal .form-group input:focus, .modal .form-group select:focus { border-color: #60a5fa; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .modal .modal-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 24px; }
        .modal .btn-cancel { background: #f1f5f9; color: #475569; }
        .modal .btn-cancel:hover { background: #e2e8f0; }
        .text-muted { color: #94a3b8; }
        @media (min-width: 1024px) { .sidebar { left: 0; } .hamburger { display: none; } .sidebar-overlay { display: none !important; } .main { margin-left: 260px; padding: 24px 32px; } }
        @media (max-width: 639px) { .page-header h1 { font-size: 18px; } .filter-bar { flex-direction: column; } .filter-bar input, .filter-bar select { min-width: 0; } .card-body { padding: 14px; } .room-header { flex-direction: column; align-items: flex-start; } .modal { padding: 20px; } }
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
    <a href="{{ route('programs.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Programs</a>
    <a href="{{ route('rooms.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Sections</a>
    <a href="{{ route('rooms.index') }}" class="active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Rooms</a>
    <a href="{{ route('schedules.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Schedules</a>
    <a href="{{ route('outputs.matrix') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>Master Matrix</a>
    <a href="{{ route('outputs.workload') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Workload Forms</a>
    <a href="{{ route('outputs.class-program') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>Class Programs</a>
    <a href="{{ route('archives.index') }}"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>Archives</a>
</nav>
<div class="main">
    <div class="page-header"><h1>Rooms <span>· Manage rooms &amp; sections</span></h1><button class="btn btn-primary" onclick="openRoomModal()">+ Add Room</button></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card"><div class="card-body">
        <form method="GET" class="filter-bar">
            <input type="text" name="search" placeholder="Search room/building..." value="{{ request('search') }}">
            <select name="room_type"><option value="">All Types</option><option value="lecture" {{ request('room_type') == 'lecture' ? 'selected' : '' }}>Lecture</option><option value="lab" {{ request('room_type') == 'lab' ? 'selected' : '' }}>Lab</option></select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
        @forelse($rooms as $room)
            <div class="room-card" style="{{ !$loop->first ? 'margin-top:16px;' : '' }}">
                <div class="room-header">
                    <div class="room-info">
                        <span class="room-number">{{ $room->room_number }}</span>
                        <div class="room-meta">
                            <span>🏢 {{ $room->building ?? 'N/A' }}</span>
                            <span>·</span>
                            <span>👤 {{ $room->capacity }}</span>
                            <span>·</span>
                            <span class="badge {{ $room->room_type == 'lecture' ? 'badge-primary' : 'badge-golden' }}">{{ ucfirst($room->room_type) }}</span>
                        </div>
                    </div>
                    <div class="room-header-actions">
                        <button class="btn btn-primary btn-xs" onclick="openSectionModal({{ $room->id }})">+ Section</button>
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-primary btn-xs">View</a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning btn-xs">Edit</a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete this room?');" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-xs">Delete</button></form>
                    </div>
                </div>
                <div class="sections-area">
                    <div class="label">Sections</div>
                    @if($room->sections->count() > 0)
                        <div class="sections-list">
                            @foreach($room->sections as $section)
                                <div class="section-pill">
                                    <span class="sec-name">{{ $section->name }}</span>
                                    <span class="sec-year">Y{{ $section->year_level }}</span>
                                    @if($section->student_count > 0)<span class="sec-students">({{ $section->student_count }})</span>@endif
                                    <form action="{{ route('rooms.sections.destroy', [$room, $section]) }}" method="POST" onsubmit="return confirm('Delete section {{ $section->name }}?');" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="sec-delete" title="Delete section">×</button></form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-sections">No sections assigned yet.</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty">No rooms found.</div>
        @endforelse
        <div class="pagination">{{ $rooms->links() }}</div>
    </div></div>
</div>

<div class="modal-overlay" id="roomModal">
    <div class="modal">
        <h2>Add Room</h2>
        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf
            <div class="form-group"><label>Room Number</label><input type="text" name="room_number" required></div>
            <div class="form-group"><label>Building</label><input type="text" name="building"></div>
            <div class="form-group"><label>Capacity</label><input type="number" name="capacity" required min="1"></div>
            <div class="form-group"><label>Room Type</label><select name="room_type" required><option value="lecture">Lecture</option><option value="lab">Lab</option></select></div>
            <div class="modal-actions"><button type="button" class="btn btn-cancel" onclick="closeModal('roomModal')">Cancel</button><button type="submit" class="btn btn-primary">Create Room</button></div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="sectionModal">
    <div class="modal">
        <h2>Add Section</h2>
        <form method="POST" action="" id="sectionForm">
            @csrf
            <input type="hidden" name="room_id" id="sectionRoomId">
            <input type="hidden" name="semester" value="{{ date('n') >= 8 ? '1st' : (date('n') >= 1 && date('n') <= 5 ? '2nd' : 'summer') }}">
            <input type="hidden" name="academic_year" value="{{ date('Y') . '-' . (date('Y') + 1) }}">
            <div class="form-group"><label>Section Name</label><input type="text" name="name" required placeholder="e.g. A, B, 1A"></div>
            <div class="form-group"><label>Year Level</label><select name="year_level" required>@for($i=1;$i<=6;$i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</select></div>
            <div class="form-group"><label>Student Count</label><input type="number" name="student_count" min="0" placeholder="Optional"></div>
            <div class="modal-actions"><button type="button" class="btn btn-cancel" onclick="closeModal('sectionModal')">Cancel</button><button type="submit" class="btn btn-primary">Create Section</button></div>
        </form>
    </div>
</div>

<script>
function openRoomModal() { document.getElementById('roomModal').classList.add('show'); }
function openSectionModal(roomId) {
    document.getElementById('sectionForm').action = '{{ url('rooms') }}/' + roomId + '/sections';
    document.getElementById('sectionModal').classList.add('show');
}
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if(e.target === this) this.classList.remove('show'); });
});
</script>
</body>
</html>
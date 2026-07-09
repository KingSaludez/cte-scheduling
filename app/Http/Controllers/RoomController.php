<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%')
                  ->orWhere('building', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        $rooms = $query->orderBy('building')->orderBy('room_number')->paginate(15);

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        $room->load('schedules.subject', 'schedules.faculty', 'schedules.section');
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}

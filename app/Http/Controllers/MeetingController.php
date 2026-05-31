<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::query();

        if ($request->filled('search')) {
            $search = (string) $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = (string) $request->input('status');
            $query->where('status', $status);
        }

        $meetings = $query->latest('start_time')->paginate(10)->withQueryString();

        $stats = [
            'total'     => Meeting::count(),
            'upcoming'  => Meeting::where('status', 'upcoming')->count(),
            'ongoing'   => Meeting::where('status', 'ongoing')->count(),
            'completed' => Meeting::where('status', 'completed')->count(),
        ];

        return view('meetings.index', compact('meetings', 'stats'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_time'  => ['required', 'date'],
            'end_time'    => ['nullable', 'date', 'after:start_time'],
            'location'    => ['nullable', 'string', 'max:255'],
            'status'      => ['nullable', 'string', 'in:upcoming,ongoing,completed,cancelled'],
        ]);

        $user = $request->user();
        $organizerName = $user ? (string) $user->getAttribute('name') : null;

        Meeting::create([
            'user_id'     => auth()->id(),
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'start_time'  => $request->input('start_time'),
            'end_time'    => $request->input('end_time'),
            'location'    => $request->input('location'),
            'status'      => $request->input('status', 'upcoming'),
            'organizer'   => $organizerName,
        ]);

        return redirect()->route('meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function show(string $id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.show', compact('meeting'));
    }

    public function edit(string $id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, string $id)
    {
        $meeting = Meeting::findOrFail($id);

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_time'  => ['required', 'date'],
            'end_time'    => ['nullable', 'date', 'after:start_time'],
            'location'    => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'string', 'in:upcoming,ongoing,completed,cancelled'],
        ]);

        $meeting->update($request->all());

        return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(string $id)
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->delete();

        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
    }
}
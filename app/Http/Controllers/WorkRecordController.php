<?php

namespace App\Http\Controllers;

use App\Models\WorkRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkRecordController extends Controller
{
    // Display work records belonging to the logged-in user
    public function index(Request $request)
    {
        $userId = Auth::id();

        $selectedMonth = $request->input(
            'month',
            now()->format('Y-m')
        );

        $records = WorkRecord::where('user_id', $userId)
            ->whereYear('work_date', substr($selectedMonth, 0, 4))
            ->whereMonth('work_date', substr($selectedMonth, 5, 2))
            ->orderBy('work_date', 'desc')
            ->get();

        return view('work_records.index', compact('records', 'selectedMonth'));
    }

    // Display the add work record form
    public function create()
    {
        return view('work_records.create');
    }

    // Save a new work record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'hourly_wage' => ['required', 'numeric', 'min:1', 'max:999999'],
        ]);

        // Assign the record to the logged-in user
        $validated['user_id'] = Auth::id();

        WorkRecord::create($validated);

        return redirect('/')
            ->with('success', 'Work record added successfully!');
    }

    // Display the edit form
    public function edit(WorkRecord $workRecord)
    {
        // Check whether this record belongs to the logged-in user
        abort_unless(
            (int) $workRecord->user_id === (int) Auth::id(),
            403
        );

        return view('work_records.edit', compact('workRecord'));
    }

    // Update an existing work record
    public function update(Request $request, WorkRecord $workRecord)
    {
        // Check ownership before updating
        abort_unless(
            (int) $workRecord->user_id === (int) Auth::id(),
            403
        );

        $validated = $request->validate([
            'work_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'hourly_wage' => ['required', 'numeric', 'min:1', 'max:999999'],
        ]);

        $workRecord->update($validated);

        return redirect('/')
            ->with('success', 'Work record updated successfully!');
    }

    // Delete a work record
    public function destroy(WorkRecord $workRecord)
    {
        // Check ownership before deleting
        abort_unless(
            (int) $workRecord->user_id === (int) Auth::id(),
            403
        );

        $workRecord->delete();

        return redirect('/')
            ->with('success', 'Work record deleted successfully!');
    }
}

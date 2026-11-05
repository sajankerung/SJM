<?php

namespace App\Http\Controllers;

use App\Models\WorkRecord;
use Illuminate\Http\Request;

class WorkRecordController extends Controller
{

    public function index(Request $request)
    {
        // Get all work records for our temporary test user.
        $userId = 1;

        //Get the selected month, or use the currect month by default.
        $selectedMonth = $request->input("month", now()->format('Y-m'));

        //Get work records for the selected month
        $records = WorkRecord::where('user_id', $userId)
            ->whereYear('work_date', substr($selectedMonth, 0, 4))
            ->whereMonth('work_date', substr($selectedMonth, 5, 2))
            ->orderBy('work_date', 'desc')
            ->get();

        return view('work_records.index', compact('records', 'selectedMonth'));
    }

    //Display the form
    public function create()
    {
        return view('work_records.create');
    }

    //save the work record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'hourly_wage' => ['required', 'numeric', 'min:1', 'max:999999'],
        ]);

        // Temporary user ID for development.
        // Replace this with Auth::id() when login is implemented.
        $validated['user_id'] = 1;

        WorkRecord::create($validated);
        return redirect('/')
            ->with('success', 'Work record added successfully!');
    }
    public function edit(WorkRecord $workRecord)
    {
        //Temporary: allow editing only records belonging to test user ID 1
        // abort_unless((int) $workRecord->user_id === 1, 403);
        return view('work_records.edit', compact('workRecord'));
    }

    public function update(Request $request, WorkRecord $workRecord)
    {
        // Temporary ownership check for test user ID 1
        // abort_unless((int) $workRecord->user_id === 1, 403);

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

    public function destroy(WorkRecord $workRecord)
    {
        // Temporary ownership check for test user ID 1
        // abort_unless((int) $workRecord->user_id === 1, 403);

        $workRecord->delete();

        return redirect('/')
            ->with('success', 'Work record deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\WorkRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //temporary: use test user ID 1
        $userId = 1;

        //Get this user's work records
        $records = WorkRecord::where('user_id', $userId)
            ->whereYear('work_date', now()->year)
            ->whereMonth('work_date', now()->month)
            ->orderByDesc('work_date')
            ->get();

        //Count records
        $totalRecords = $records->count();

        //Calculate total working hours
        $totalHours = $records->sum(function ($record) {
            $start = Carbon::parse($record->start_time);
            $end = Carbon::parse($record->end_time);

            return $start->diffInMinutes($end) / 60;
        });

        //Calculate total salary
        $totalSalary = $records->sum(function ($record) {
            $start = Carbon::parse($record->start_time);
            $end = Carbon::parse($record->end_time);

            $hours = $start->diffInMinutes($end) / 60;

            return $hours * $record->hourly_wage;
        });

        return view('dashboard', compact(
            'records',
            'totalRecords',
            'totalHours',
            'totalSalary'
        ));
    }
}

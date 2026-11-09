<?php
namespace App\Http\Controllers;

use App\Models\WorkRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        // Temporary test user ID
        // $userId = 1;
        $userId = Auth::id();

        // Get selected month or current month
        $selectedMonth = $request->input(
            'month',
            now()->format('Y-m')
        );

        // Get work records for the selected month
        $records = WorkRecord::where('user_id', $userId)
            ->whereYear('work_date', substr($selectedMonth, 0, 4))
            ->whereMonth('work_date', substr($selectedMonth, 5, 2))
            ->orderBy('work_date', 'desc')
            ->get();

        // Calculate total working hours
        $totalHours = $records->sum(function ($record) {
            $start = Carbon::parse($record->start_time);
            $end = Carbon::parse($record->end_time);

            return $start->diffInMinutes($end) / 60;
        });

        // Calculate total salary
        $totalSalary = $records->sum(function ($record) {
            $start = Carbon::parse($record->start_time);
            $end = Carbon::parse($record->end_time);

            $hours = $start->diffInMinutes($end) / 60;

            return $hours * $record->hourly_wage;
        });

        // Count work records
        $totalRecords = $records->count();

        return view('monthly_reports.index', compact(
            'records',
            'selectedMonth',
            'totalHours',
            'totalSalary',
            'totalRecords'
        ));
    }
}


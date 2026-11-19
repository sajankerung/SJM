<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //Display tasks belonging to the logged-in user

    public function index()
    {
        // Get tasks belonging to the logged-in user
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate task summary
        $totalTasks = $tasks->count();

        $pendingTasks = $tasks->where('status', 'Pending')->count();

        $completedTasks = $tasks->where('status', 'Completed')->count();

        return view('tasks.index', compact(
            'tasks',
            'totalTasks',
            'pendingTasks',
            'completedTasks'
        ));
    }


    // Display the Add Task form
    public function create()
    {
        return view('tasks.create');
    }

    // Save a new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Pending,Completed',
        ]);

        Task::create([...$validated,'user_id' => Auth::id(),]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task added successfully!');
    }
}

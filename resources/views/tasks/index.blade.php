<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJM - Task Management</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
</head>

<body>
    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">SJM</div>

            <div class="subtitle">
                Student Part-Time Job<br>
                Management System
            </div>

            <nav class="nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('work-records.index') }}">Work Records</a>
                <a href="{{ route('monthly-reports.index') }}">Monthly Reports</a>
                <a href="{{ route('tasks.index') }}" class="active">Task Management</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main">

            <!-- Page Header -->
            <header class="topbar">
                <div>
                    <h1>Task Management</h1>
                    <p class="muted">
                        Manage your assignments, study plans, and daily tasks.
                    </p>
                </div>

                <a href="{{ route('tasks.create') }}" class="button">+ Add Task</a>
            </header>

            <!-- Summary Cards -->
            <section class="cards">

                <div class="card">
                    <p>Total Tasks</p>
                    <div class="amount">{{ $totalTasks }}</div>
                </div>

                <div class="card">
                    <p>Pending Tasks</p>
                    <div class="amount">{{ $pendingTasks }}</div>
                </div>

                <div class="card">
                    <p>Completed Tasks</p>
                    <div class="amount">{{ $completedTasks }}</div>
                </div>

            </section>

            <!-- Task List -->
            <section class="panel">
                <h2>My Tasks</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>
                                    <strong>{{ $task->title }}</strong>

                                    @if ($task->description)
                                        <p>{{ $task->description }}</p>
                                    @endif
                                </td>

                                <td>
                                    {{ $task->deadline ? $task->deadline->format('Y-m-d') : 'No deadline' }}
                                </td>

                                <td>
                                    <span
                                        class="task-status {{ $task->status === 'Completed' ? 'status-completed' : 'status-pending' }}">
                                        {{ $task->status }}
                                    </span>
                                </td>

                                <td>
                                    <!-- Edit and Delete buttons will be added later -->
                                    -
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty">
                                    No tasks yet. Add your first task to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </section>

        </main>
    </div>
</body>

</html>

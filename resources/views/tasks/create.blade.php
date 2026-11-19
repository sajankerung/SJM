
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJM - Add Task</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
</head>

<body>
    <div class="layout">

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

        <main class="main">

            <header class="topbar">
                <div>
                    <h1>Add New Task</h1>
                    <p class="muted">Create and manage your tasks.</p>
                </div>
            </header>

            <section class="panel">

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <label>Task Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required>

                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    <label>Description</label>
                    <textarea name="description">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    <label>Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}">

                    @error('deadline')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    <label>Status</label>
                    <select name="status" required>
                        <option value="Pending" {{ old('status', 'Pending') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    @error('status')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="button">Save Task</button>

                    <a href="{{ route('tasks.index') }}" class="button">Cancel</a>

                </form>

            </section>

        </main>
    </div>
</body>

</html>

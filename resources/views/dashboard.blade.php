<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJM - Student Part-Time Job Management</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="logo">SJM</div>
            <div class="subtitle">Student Part-Time Job<br>Management System</div>

            <nav class="nav">
                <a href="/" class="active">Dashboard</a>
                <a href="{{ route('work-records.index') }}">Work Records</a>
                <a href="#">Monthly Reports</a>
                <a href="#">Profile</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div>
                    <h1>Dashboard</h1>
                    <p class="muted">Manage your work hours and earnings.</p>
                </div>
                <a href="{{ route('work-records.create') }}" class="button">+ Add Work Record</a>
            </header>

            <section class="cards">
                <div class="card">
                    <p>Working Hours This Month</p>
                    <div class="amount">{{ number_format($totalHours, 1) }}hours</div>
                </div>

                <div class="card">
                    <p>Estimated Salary This Month</p>
                    <div class="amount">¥{{ number_format($totalSalary) }}</div>
                </div>

                <div class="card">
                    <p>Work Records This Month</p>
                    <div class="amount">{{ $totalRecords }} records</div>
                </div>
            </section>

            <section class="panel">
                <h2>Recent Work Records</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Working Hours</th>
                            <th>Salary</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($records as $record)
                            @php
                                $start = \Carbon\Carbon::parse($record->start_time);
                                $end = \Carbon\Carbon::parse($record->end_time);
                                $hours = $start->diffInMinutes($end) / 60;
                                $salary = $hours * $record->hourly_wage;
                            @endphp

                            <tr>
                                <td>
                                    <a
                                        href="{{ route('work-records.edit', $record) }}"class="action-link edit-button">Edit</a>
                                    <form action="{{ route('work-records.destroy', $record) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this work record?');"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-link delete-button">Delete</button>
                                    </form>
                                </td>
                                <td>{{ $record->work_date->format('Y-m-d') }}</td>
                                <td>{{ $start->format('H:i') }}</td>
                                <td>{{ $end->format('H:i') }}</td>
                                <td>{{ number_format($hours, 1) }} hours</td>
                                <td>¥{{ number_format($salary) }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    No work records yet. Add your first work record to get started.
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

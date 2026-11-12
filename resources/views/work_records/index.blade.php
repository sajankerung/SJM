<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Records - SJM</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/work-records.css') }}">
</head>

<body>

    <div class="layout">

        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>SJM</h2>
                <p>Student Part-Time Job Management System</p>
            </div>

            <nav class="nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('work-records.index') }}" class="active">Work Records</a>
                <a href="{{ route('monthly-reports.index') }}">Monthly Reports</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </aside>

        <main class="main">
            <header class="page-header">
                <div>
                    <h1>Work Records</h1>
                    <p>View and manage your part-time work hours and earnings.</p>
                </div>
            </header>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    Please check your input and try again.
                </div>
            @endif

            <section class="records-section">
                <h2>Work Records by Month</h2>
                <form action="{{ route('work-records.index') }}" method="GET" class="month-filter">
                    <label for="month">Select Month:</label>
                    <input type="month" id="month" name="month" value="{{ $selectedMonth }}" required>
                    <button type="submit" class="button">Filter</button>
                    <a href="{{ route('work-records.index', ['month' => now()->format('Y-m')]) }}" class="button">
                        Current Month
                    </a>
                </form>
                <p class="muted">
                    Showing records for {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y') }}
                </p>

                <div class="table-container">
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
                                        <a href="{{ route('work-records.edit', $record) }}"
                                            class="action-link edit-button">Edit</a>

                                        <form action="{{ route('work-records.destroy', $record) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this work record?');"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-link delete-button">
                                                Delete
                                            </button>
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
                                    <td colspan="6">No work records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>

        </main>
    </div>

</body>

</html>

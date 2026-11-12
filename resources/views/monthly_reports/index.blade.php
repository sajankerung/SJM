<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Reports - SJM</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/work-records.css') }}">
    <link rel="stylesheet" href="{{ asset('css/monthly-reports.css') }}">
</head>

<body>

    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="sidebar-header">
                <h2>SJM</h2>
                <p>Student Part-Time Job Management System</p>
            </div>

            <nav class="nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>

                <a href="{{ route('work-records.index') }}">Work Records</a>

                <a href="{{ route('monthly-reports.index') }}" class="active">Monthly Reports</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>

        </aside>

        <!-- Main Content -->
        <main class="main">

            <header class="page-header">
                <div>
                    <h1>Monthly Reports</h1>
                    <p>Review your monthly working hours and earnings.</p>
                </div>
            </header>

            <!-- Month Filter -->
            <section class="records-section">

                <h2>Select Report Month</h2>

                <form action="{{ route('monthly-reports.index') }}" method="GET" class="month-filter">

                    <label for="month">Select Month:</label>

                    <input type="month" id="month" name="month" value="{{ $selectedMonth }}" required>

                    <button type="submit" class="button">Filter</button>

                    <a href="{{ route('monthly-reports.index', ['month' => now()->format('Y-m')]) }}" class="button">Current Month</a>

                </form>

                <p class="muted">Report for
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y') }}
                </p>

            </section>

            <!-- Monthly Summary -->
            <section class="report-cards">
                <div class="report-card">
                    <p>Total Working Hours</p>
                    <h2>{{ number_format($totalHours, 1) }} hours</h2>
                </div>

                <div class="report-card">
                    <p>Total Monthly Salary</p>
                    <h2>¥{{ number_format($totalSalary) }}</h2>
                </div>

                <div class="report-card">
                    <p>Total Work Records</p>
                    <h2>{{ $totalRecords }} records</h2>
                </div>
            </section>

            <!-- Work Record Details -->
            <section class="records-section">

                <h2>Work Record Details</h2>

                <div class="table-container">

                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Working Hours</th>
                                <th>Hourly Wage</th>
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
                                    <td>{{ $record->work_date->format('Y-m-d') }}</td>
                                    <td>{{ $start->format('H:i') }}</td>
                                    <td>{{ $end->format('H:i') }}</td>
                                    <td>{{ number_format($hours, 1) }} hours</td>
                                    <td>¥{{ number_format($record->hourly_wage) }}</td>
                                    <td>¥{{ number_format($salary) }}</td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6">
                                        No work records found for this month.
                                    </td>
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

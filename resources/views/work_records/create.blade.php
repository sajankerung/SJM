<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Work Record - SJM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/work-records.css') }}">
</head>
<body>
    <main class="main">
        <header class="topbar">
            <div>
                <h1>Add Work Record</h1>
                <p class="muted">Enter your part-time work details.</p>
            </div>
            <a href="/" class="button">Back to Dashboard</a>
        </header>

        @if ($errors->any())
            <div class="form-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('work-records.store') }}" method="POST" class="work-form">
            @csrf

            <label for="work_date">Work Date</label>
            <input type="date" id="work_date" name="work_date"
                   value="{{ old('work_date') }}" required>

            <div class="form-row">
                <div>
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time"
                        value="{{ old('start_time') }}" required>
                </div>

                <div>
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time"
                        value="{{ old('end_time') }}" required>
                </div>
            </div>

            <label for="hourly_wage">Hourly Wage (¥)</label>
            <input type="number" id="hourly_wage" name="hourly_wage"
                   min="1" max="999999" step="1"
                   value="{{ old('hourly_wage', 1200) }}" required>
            <button type="submit" class="button">Save Work Record</button>
        </form>
    </main>
</body>
</html>

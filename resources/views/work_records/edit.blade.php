<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Work Record - SJM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/work-records.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="main">
        <section class="records-section">
            <h1>Edit Work Record</h1>
            <p>Update your work information below.</p>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('work-records.update', $workRecord) }}" method="POST" class="work-form">

                @csrf
                @method('PUT')

                <label for="work_date">Work Date</label>
                <input type="date" id="work_date" name="work_date"
                    value="{{ old('work_date', $workRecord->work_date->format('Y-m-d')) }}" required>

                <div class="form-row">
                    <div>
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time"
                            value="{{ old('start_time', \Carbon\Carbon::parse($workRecord->start_time)->format('H:i')) }}"
                            required>
                    </div>

                    <div>
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time"
                            value="{{ old('end_time', \Carbon\Carbon::parse($workRecord->end_time)->format('H:i')) }}"
                            required>
                    </div>
                </div>

                <label for="hourly_wage">Hourly Wage (¥)</label>
                <input type="number" id="hourly_wage" name="hourly_wage" min="1" max="999999" step="1"
                    value="{{ old('hourly_wage', $workRecord->hourly_wage) }}" required>

                <button type="submit" class="button">Update Record</button>

                <a href="{{ route('work-records.index') }}" class="button cancel-button">Cancel</a>
            </form>
        </section>
    </div>
</body>

</html>

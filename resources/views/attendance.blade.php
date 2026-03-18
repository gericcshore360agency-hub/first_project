<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-10 main-content d-flex align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: 600px;">
                <h2 class="mb-3">Calendar</h2>
                <p class="text-muted mb-4">Your schedule for the month:</p>

                {{-- Calendar will be drawn here it will come from the JS --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-secondary btn-sm" onclick="previousMonth()">Previous</button>
                    <button class="btn btn-secondary btn-sm" onclick="nextMonth()">Next</button>
                </div>
                <div id="calendar" class="text-center flex-grow-1"></div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- I passed the route to the JS to render the dates properly -->
<script>
    const attendanceBaseUrl = "{{ route('attendance.show', ':date') }}";
</script>

<script>
let selectedMonth = new Date().getMonth();
let selectedYear = new Date().getFullYear();
const todayDate = new Date().getDate();
const todayMonth = new Date().getMonth();
const todayYear = new Date().getFullYear();

const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
const dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

function generateCalendar() {
    const calendarEl = document.getElementById('calendar');
    const month = selectedMonth;
    const year = selectedYear;
    const today = todayMonth === month && todayYear === year ? todayDate : null;

    const firstDay = new Date(year, month, 1).getDay();
    const numDays = new Date(year, month + 1, 0).getDate();

    let html = `<div class="mb-3"><h3>${monthNames[month]} ${year}</h3></div>`;
    html += `<table class="table table-bordered text-center" style="table-layout: fixed;">`;
    html += `<thead><tr>`;
    
    dayNames.forEach(day => {
        html += `<th style="height: 60px;">${day}</th>`;
    });

    html += `</tr></thead><tbody><tr>`;

    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        html += `<td></td>`;
    }

    // Days
    for (let day = 1; day <= numDays; day++) {
        const currentDay = (firstDay + day - 1) % 7;
        const isToday = day === today ? 'bg-primary text-white fw-bold rounded' : '';

        const dateStr = `${year}-${String(month + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        const url = attendanceBaseUrl.replace(':date', dateStr);

        html += `
            <td class="${isToday}" 
                style="height: 80px; vertical-align: middle; cursor:pointer;" 
                onclick="window.location='${url}'">
                ${day}
            </td>
        `;

        if (currentDay === 6 && day !== numDays) {
            html += `</tr><tr>`;
        }
    }

    const remaining = (7 - (firstDay + numDays) % 7) % 7;
    for (let i = 0; i < remaining; i++) {
        html += `<td></td>`;
    }

    html += `</tr></tbody></table>`;
    calendarEl.innerHTML = html;
    
    // Update month/year header
    document.getElementById('monthYear').textContent = `${monthNames[month]} ${year}`;
}

function nextMonth() {
    selectedMonth++;
    if (selectedMonth > 11) {
        selectedMonth = 0;
        selectedYear++;
    }
    generateCalendar();
}

function previousMonth() {
    selectedMonth--;
    if (selectedMonth < 0) {
        selectedMonth = 11;
        selectedYear--;
    }
    generateCalendar();
}

generateCalendar();
</script>

</body>
</html>
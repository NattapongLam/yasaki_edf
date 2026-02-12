@extends('layouts.main')

@push('styles')
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📅 Machinery Calendar</h4>
    <div id="calendar"></div>
</div>
@endsection

@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        locale: 'th',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },

        events: '{{ url("/machinery/calendar") }}',

        eventDidMount(info) {
            let status = info.event.extendedProps.status;
            if (status == 0) info.el.style.backgroundColor = '#dc3545'; // ยังไม่สอบเทียบ
            if (status == 1) info.el.style.backgroundColor = '#198754'; // ผ่านแล้ว
        },

        eventClick(info) {
            info.jsEvent.preventDefault(); // กัน default

            let id = info.event.id;
            window.location.href = '{{ url("/machineryplans") }}/' + id;
        }
    });

    calendar.render();
});
</script>
@endpush

<div class="calendar">
    <!-- Calendar Header -->
    <div class="calendar-header flex justify-between items-center p-4 bg-gray-200">
        <button class="prev-month">&lt;</button>
        <h2 class="month-year">{{ $month }} {{ $year }}</h2>
        <button class="next-month">&gt;</button>
    </div>

    <!-- Days of the Week -->
    <div class="calendar-days grid grid-cols-7 text-center bg-gray-100">
        <span>Dom</span>
        <span>Lun</span>
        <span>Mar</span>
        <span>Mié</span>
        <span>Jue</span>
        <span>Vie</span>
        <span>Sáb</span>
    </div>

    <!-- Calendar Dates -->
    <div class="calendar-dates grid grid-cols-7 text-center">
        @foreach ($dates as $date)
            <div class="date {{ $date['isCurrentMonth'] ? '' : 'text-gray-400' }}">
                {{ $date['day'] }}
            </div>
        @endforeach
    </div>
</div>

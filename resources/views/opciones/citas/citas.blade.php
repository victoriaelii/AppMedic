<x-app-layout>
    <div class="min-h-screen py-6 flex items-start" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="w-1/2 ml-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <div class="lg:flex lg:h-full lg:flex-col">
                                <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
                                    <h1 class="text-base font-semibold leading-6 text-gray-900">
                                        <time datetime="2022-01" id="current-month">{{ \Carbon\Carbon::now()->format('F Y') }}</time>
                                    </h1>
                                    <div class="flex items-center">
                                        <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
                                            <button id="prev-month-btn" type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50" onclick="changeMonth(-1)">
                                                <span class="sr-only">Previous month</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
                                            <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block" onclick="goToToday()">Mes</button>
                                            <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
                                            <button type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50" onclick="changeMonth(1)">
                                                <span class="sr-only">Next month</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <a href="{{ route('crearCita') }}" class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                            {{ __('Agregar Cita') }}
                                        </a>
                                    </div>
                                </header>
                                <div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col">
                                    <div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs font-semibold leading-6 text-gray-700 lg:flex-none">
                                        <div class="flex justify-center bg-white py-2">
                                            <span>M</span>
                                            <span class="sr-only sm:not-sr-only">on</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>T</span>
                                            <span class="sr-only sm:not-sr-only">ue</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>W</span>
                                            <span class="sr-only sm:not-sr-only">ed</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>T</span>
                                            <span class="sr-only sm:not-sr-only">hu</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>F</span>
                                            <span class="sr-only sm:not-sr-only">ri</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>S</span>
                                            <span class="sr-only sm:not-sr-only">at</span>
                                        </div>
                                        <div class="flex justify-center bg-white py-2">
                                            <span>S</span>
                                            <span class="sr-only sm:not-sr-only">un</span>
                                        </div>
                                    </div>
                                    <div class="flex bg-gray-200 text-xs leading-6 text-gray-700 lg:flex-auto">
                                        <div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px" id="calendar-grid">
                                            @foreach ($citas as $cita)
                                                <div class="relative bg-white px-3 py-2 h-24 calendar-day {{ $cita->fecha == \Carbon\Carbon::today()->toDateString() ? 'today' : '' }}">
                                                    <time datetime="{{ $cita->fecha }}">{{ \Carbon\Carbon::parse($cita->fecha)->format('j') }}</time>
                                                    <div class="text-xs text-blue-500">
                                                        {{ $cita->hora }} - {{ $cita->paciente->nombres ?? 'Paciente no asignado' }} {{ $cita->paciente->apepat ?? '' }} {{ $cita->paciente->apemat ?? '' }} - {{ $cita->medico->nombres ?? 'Médico no asignado' }} {{ $cita->medico->apepat ?? '' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .calendar-day {
        max-height: 100px; 
        overflow-y: auto;
    }
    .calendar-day div {
        margin-bottom: 4px; 
    }
    .calendar-day::-webkit-scrollbar {
        display: none;
    }
    .calendar-day {
        -ms-overflow-style: none; 
        scrollbar-width: none;  
    }
    .today {
        background-color: #f0f8ff; 
    }
</style>

<script>
    const initialDate = new Date();
    let currentDate = new Date();
    const citas = @json($citas);

    function changeMonth(monthChange) {
        const newDate = new Date(currentDate.setMonth(currentDate.getMonth() + monthChange));
        if (newDate < initialDate) {
            currentDate = initialDate;
        } else {
            currentDate = newDate;
        }
        updateCalendar();
    }

    function goToToday() {
        currentDate = new Date();
        updateCalendar();
    }

    function updateCalendar() {
        const currentMonth = currentDate.toLocaleString('default', { month: 'long' });
        const currentYear = currentDate.getFullYear();
        document.getElementById('current-month').textContent = `${currentMonth} ${currentYear}`;
        
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        
        let calendarGrid = '';
        const today = new Date().toISOString().split('T')[0]; 
        
        const daysInWeek = 7;
        const firstDayIndex = (firstDayOfMonth.getDay() + 6) % daysInWeek; 
        for (let i = 0; i < firstDayIndex; i++) {
            const prevMonthDay = new Date(firstDayOfMonth);
            prevMonthDay.setDate(prevMonthDay.getDate() - (firstDayIndex - i));
            calendarGrid += `<div class="relative bg-gray-50 px-3 py-2 text-gray-500">
                                <time datetime="${prevMonthDay.toISOString().split('T')[0]}">${prevMonthDay.getDate()}</time>
                             </div>`;
        }
        
        for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
            const currentDay = new Date(currentYear, currentDate.getMonth(), i);
            const dateString = currentDay.toISOString().split('T')[0];
            let citaContent = '';

            const dayCitas = citas.filter(cita => cita.fecha === dateString).sort((a, b) => a.hora.localeCompare(b.hora));
            dayCitas.forEach(cita => {
                citaContent += `<div class="text-xs text-blue-500">${cita.hora} - ${cita.paciente.nombres} ${cita.paciente.apepat} ${cita.paciente.apemat} - ${cita.medico.nombres} ${cita.medico.apepat}</div>`;
            });

            const isToday = dateString === today ? 'today' : ''; 

            calendarGrid += `<div class="relative bg-white px-3 py-2 h-24 calendar-day ${isToday}">
                                <time datetime="${dateString}">${i}</time>
                                ${citaContent}
                             </div>`;
        }
        
        const daysInNextMonth = daysInWeek * 6 - (firstDayIndex + lastDayOfMonth.getDate());
        for (let i = 1; i <= daysInNextMonth; i++) {
            const nextMonthDay = new Date(lastDayOfMonth);
            nextMonthDay.setDate(nextMonthDay.getDate() + i);
            calendarGrid += `<div class="relative bg-gray-50 px-3 py-2 text-gray-500">
                                <time datetime="${nextMonthDay.toISOString().split('T')[0]}">${nextMonthDay.getDate()}</time>
                             </div>`;
        }
        
        document.getElementById('calendar-grid').innerHTML = calendarGrid;
        
        document.getElementById('prev-month-btn').disabled = currentDate.getMonth() === initialDate.getMonth() && currentDate.getFullYear() === initialDate.getFullYear();
    }

    document.addEventListener('DOMContentLoaded', updateCalendar);
</script>

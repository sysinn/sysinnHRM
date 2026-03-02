@extends('layouts.app')



@section('content')

    @php
        $isEmployee = auth()->check() && auth()->user()->employee && auth()->user()->employee->department_id !== 9;
         

        $currentEmployeeId = $isEmployee ? auth()->user()->employee->id : null;

    @endphp

    <pre>
    isEmployee: {{ $isEmployee ? 'true' : 'false' }}
    auth check: {{ auth()->check() ? 'true' : 'false' }}
    has employee: {{ auth()->check() && auth()->user()->employee ? 'true' : 'false' }}
    department_id: {{ auth()->check() && auth()->user()->employee ? auth()->user()->employee->department_id : 'N/A' }}
</pre>


    <style>
        .fc-daygrid-day-events {

            display: none;

        }



        .min-h-screen.bg-gray-100.dark\:bg-gray-900 {

            min-height: unset
        }



        /*aside.fixed.lg\:static.inset-y-0.left-0.z-40.w-64.min-h-screen.flex.bg-gradient-to-b.from-white.via-gray-50.to-gray-100.border-r.border-gray-200 {*/

        /*    margin-top: -350px;*/

        /*    z-index: 11111;*/

        /*}*/



        /*main.flex-1.bg-white.p-8.font-\[PlusJakartaSans\].ml-64 {*/

        /*    margin-top: -490px;*/

        /*    position:relative;*/

        /*    z-index: 11111;*/

        /*}*/
    </style>



   

    





    {{-- ================= BOARD VIEW ================= --}}


<div class="flex flex-row justify-between">


  @include('layouts.sidebar')

<div class="w-full">
      {{-- Toggle removed - List View only --}}

        <main class="flex-1 bg-white p-8 font-[PlusJakartaSans]">

        <div class="flex items-center gap-3 justify-center">

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                {{-- Simple Date Input for filtering --}}
                <input type="date" id="dateFilter" 
                    class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    style="max-width: 200px;">
            </div>

            <button id="clearDateFilter"
            class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 border border-gray-200 rounded-md transition-colors duration-200"
            title="Clear date filter">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

            </svg>

            Clear

        </button>

       </div>

 </main>

<div >

        

            {{-- Board View - Hidden by default --}}
            <div id="boardView" class="max-w-7xl mx-auto hidden">



                <!-- Header -->

                <div class="flex justify-between items-center mb-6">

                    <h1 class="text-xl font-semibold text-gray-800">Daily Work Done</h1>





                    <a href="{{ route('daily-work.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2 transition">

                        <ion-icon name="add-circle-outline"></ion-icon>

                        Add New

                    </a>





                </div>



                <!-- Success Message -->

                @if(session('success'))

                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">

                        {{ session('success') }}

                    </div>

                @endif



                <!-- Trello Board -->

                <div class="flex gap-6 overflow-x-auto pb-4 px-[60px] overflow-x-hidden">



                    @php

                        $columns = [

                            'pending' => 'To Do',

                            'in-progress' => 'In Progress',

                            'completed' => 'Done'

                        ];



                        $columnColors = [

                            'pending' => 'border-blue-500 text-blue-600',

                            'in-progress' => 'border-yellow-500 text-yellow-600',

                            'completed' => 'border-green-500 text-green-600'

                        ];



                        $badgeColors = [

                            'pending' => 'bg-blue-100 text-blue-700',

                            'in-progress' => 'bg-yellow-100 text-yellow-700',

                            'completed' => 'bg-green-100 text-green-700'

                        ];

                    @endphp



                    @foreach($columns as $status => $title)

                        <div class="w-1/3 bg-gray-50 rounded-xl p-4 flex-shrink-0 border-t-4 {{ $columnColors[$status] }}">

                            <h2 class="font-semibold mb-4 flex justify-between items-center">

                                <span>{{ $title }}</span>

                                <span class="text-xs bg-white px-2 py-1 rounded shadow">

                                    {{ count($boardWorks[$status] ?? []) }}

                                </span>

                            </h2>



                            <!-- Cards Container -->

                            <div class="cards-container min-h-[320px]" id="{{ $status }}-cards">

                                @foreach($boardWorks[$status] ?? [] as $work)

                                                <div class="bg-white rounded-xl p-4 shadow-sm draggable-card cursor-move

                                    border-l-4 {{ $columnColors[$status] }}

                                    hover:shadow-lg hover:-translate-y-1 transition mb-3" draggable="true" data-id="{{ $work->id }}"
                                                    data-status="{{ $status }}"
                                                    data-date="{{ \Carbon\Carbon::parse($work->date)->format('Y-m-d') }}">





                                                    <div class="flex justify-between items-start mb-1 min-w-0">

                                                        <a href="{{ route('daily-work.show', $work->id) }}"
                                                            class="font-medium text-gray-800 hover:underline break-words min-w-0">

                                                            {{ $work->task_type }}

                                                        </a>



                                                        <span class="status-badge text-xs px-2 py-1 rounded-full {{ $badgeColors[$status] }} flex-shrink-0">

                                                            {{ ucfirst(str_replace('-', ' ', $status)) }}

                                                        </span>

                                                    </div>



                                                    <p class="text-sm text-gray-600 break-words">

                                                        {{ Str::limit($work->detail, 80) }}

                                                    </p>



                                                    <div class="flex justify-between items-center mt-3 text-xs text-gray-400">

                                                        <span>{{ \Carbon\Carbon::parse($work->date)->format('d M Y') }}</span>



                                                        @if($work->employee && $work->employee->user)

                                                            <span class="bg-gray-100 px-2 py-1 rounded">

                                                                {{ $work->employee->user->name }}

                                                            </span>

                                                        @endif

                                                    </div>

                                                </div>

                                @endforeach

                            </div>



                            <!-- Pagination Controls -->

                            <div class="flex justify-between items-center mt-3 text-xs" id="{{ $status }}-pagination"></div>

                        </div>

                    @endforeach



                </div>

            </div>

            {{-- List View - Shown by default --}}
            <div id="listView" class="max-w-7xl mx-auto">



                <div class="flex justify-between items-center mb-6">

                    <h1 class="text-xl font-semibold text-gray-800">Daily Work Done</h1>



                    <a href="{{ route('daily-work.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2 transition">

                        <ion-icon name="add-circle-outline"></ion-icon>

                        Add New

                    </a>

                </div>



                <div class="bg-white shadow-sm rounded p-4 overflow-x-auto">

                    <table id="dailyWorkTablelist" class="min-w-full">

                        <thead class="bg-gray-100 text-sm uppercase">

                            <tr>

                                <th>Date</th>
                                
                                @if(!$isEmployee)

                                    <th>Emp</th>

                                    <th>Team</th>

                                @endif

                                <th>Project</th>

                                <th>Task</th>

                                @if($isEmployee)

                                    <th>Status</th>

                                @endif

                            </tr>

                            {{-- SEARCH ROW --}}

                            <tr>

                                <th><input type="text" class="column-search" placeholder="Search Date"></th>



                                @if(!$isEmployee)

                                    <th><input type="text" class="column-search" placeholder="Search Emp"></th>

                                    <th><input type="text" class="column-search" placeholder="Search Team"></th>

                                @endif



                                <th><input type="text" class="column-search" placeholder="Search Project"></th>

                                <th><input type="text" class="column-search" placeholder="Search Type"></th>



                                @if($isEmployee)

                                    <th><input type="text" class="column-search" placeholder="Search Status"></th>

                                @endif

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($allWorks as $work)

                                <tr data-date="{{ \Carbon\Carbon::parse($work->date)->format('Y-m-d') }}">

                                    <td data-order="{{ $work->date }}">{{ \Carbon\Carbon::parse($work->date)->format('d M Y') }}</td>



                                    @if(!$isEmployee)

                                        <td><a
                                                href="{{ route('daily-work.show', $work->id) }}">{{ $work->employee->user->name ?? '-' }}</a>
                                        </td>

                                        <td><a
                                                href="{{ route('projects.show', $work->id) }}">{{ $work->employee->department->name ?? '-' }}</a>
                                        </td>

                                    @endif



                                    <td><a
                                            href="{{ route('daily-work.show', $work->id) }}">{{ $work->project->name ?? '-' }}</a>
                                    </td>



                                    <td><a href="{{ route('projects.show', $work->project->id) }}">{{ $work->task_type }}</a>
                                    </td>



                                    @if($isEmployee)

                                                        <td>

                                                            <span class="status-badge

                                            {{ $work->status === 'approved' ? 'status-approved' :

                                        ($work->status === 'pending' ? 'status-pending' :

                                            'status-rejected') }}">

                                                                {{ ucfirst($work->status) }}

                                                            </span>

                                                        </td>

                                    @endif

                                </tr>

                            @endforeach



                        </tbody>

                    </table>

                </div>



            </div>

        </main>

    </div>
    
    
    </div>


     </div> 

    </div>





    </div>

@endsection









@section('scripts')



    {{-- FullCalendar CSS removed --}}





    {{-- FullCalendar JS removed --}}













    <script>
        // Drag & Drop functionality for board view (hidden)















    <script>

        const statusStyles = {

            'pending': { border: 'border-blue-500', badge: 'bg-blue-100 text-blue-700', label: 'Pending' },

            'in-progress': { border: 'border-yellow-500', badge: 'bg-yellow-100 text-yellow-700', label: 'In Progress' },

            'completed': { border: 'border-green-500', badge: 'bg-green-100 text-green-700', label: 'Completed' }

        };



        let draggedCard = null;



        // Drag & Drop

        document.querySelectorAll('.draggable-card').forEach(card => {

            card.addEventListener('dragstart', e => {

                draggedCard = card;

                e.dataTransfer.setData('id', card.dataset.id);

            });

        });



        document.querySelectorAll('.cards-container').forEach(container => {

            container.addEventListener('dragover', e => e.preventDefault());

            container.addEventListener('drop', async e => {

                e.preventDefault();

                if (!draggedCard) return;



                const newStatus = container.id.replace('-cards', '');

                const oldStatus = draggedCard.dataset.status;

                const id = draggedCard.dataset.id;

                if (newStatus === oldStatus) return;



                container.appendChild(draggedCard);

                updateCardUI(draggedCard, newStatus);

                draggedCard.dataset.status = newStatus;



                try {

                    await fetch(`/daily-work/${id}/status`, {

                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': '{{ csrf_token() }}',

                            'Content-Type': 'application/json'

                        },

                        body: JSON.stringify({ status: newStatus })

                    });

                } catch {

                    alert('Failed to update status');

                    document.getElementById(oldStatus + '-cards').appendChild(draggedCard);

                    updateCardUI(draggedCard, oldStatus);

                    draggedCard.dataset.status = oldStatus;

                }

            });

        });



        function updateCardUI(card, status) {

            card.classList.remove('border-blue-500', 'border-yellow-500', 'border-green-500');

            card.classList.add(statusStyles[status].border);



            const badge = card.querySelector('.status-badge');

            badge.className = `status-badge text-xs px-2 py-1 rounded-full ${statusStyles[status].badge}`;

            badge.innerText = statusStyles[status].label;

        }



        // Pagination + Search for cards

        function setupPagination(columnId, perPage = 5) {

            const container = document.getElementById(columnId + '-cards');

            const cards = Array.from(container.children);

            const pagination = document.getElementById(columnId + '-pagination');

            let currentPage = 1;



            function renderPage(page) {

                currentPage = page;

                cards.forEach((card, i) => {

                    card.style.display = (i >= (page - 1) * perPage && i < page * perPage) ? 'block' : 'none';

                });



                const totalPages = Math.ceil(cards.length / perPage);

                pagination.innerHTML = `

                <button ${page === 1 ? 'disabled' : ''} class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">Prev</button>

                <span>Page ${page} / ${totalPages}</span>

                <button ${page === totalPages ? 'disabled' : ''} class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">Next</button>

            `;



                pagination.querySelector('button:first-child').onclick = () => { if (page > 1) renderPage(page - 1); };

                pagination.querySelector('button:last-child').onclick = () => { if (page < totalPages) renderPage(page + 1); };

            }



            renderPage(1);



            // Search box

            const searchInput = document.createElement('input');

            searchInput.type = 'text';

            searchInput.placeholder = 'Search cards...';

            searchInput.className = 'w-full mb-2 px-2 py-1 border rounded text-sm';

            container.parentNode.insertBefore(searchInput, container);



            searchInput.addEventListener('input', () => {

                const query = searchInput.value.toLowerCase();

                cards.forEach(card => {

                    const text = card.innerText.toLowerCase();

                    card.style.display = text.includes(query) ? 'block' : 'none';

                });

            });

        }



        // Initialize pagination for each column

        ['pending', 'in-progress', 'completed'].forEach(col => setupPagination(col, 5));





        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');



        body, table, th, td, a, span {

            font - family: 'Plus Jakarta Sans', sans - serif!important;

        }



    .column - search {

            width: 100 %;

            padding: 7px 10px;

            font - size: 12px;

            border: 1px solid #e5e7eb;

            border - radius: 6px;

        }



    .column - search:focus {

            border - color: #0057D8;

            box - shadow: 0 0 0 2px rgba(0, 87, 216, 0.15);

        }



    .status - badge {

            padding: 5px 12px;

            font - size: 12px;

            font - weight: 600;

            border - radius: 9999px;

        }



    .status - approved { background: #dcfce7; color: #166534; }

    .status - pending  { background: #fef9c3; color: #854d0e; }

    .status - rejected { background: #fee2e2; color: #991b1b; }

    </script>



























    <script>
        console.log('=== Daily Work Page Debug ===');
        console.log('Board View element:', document.getElementById('boardView'));
        console.log('Calendar element:', document.getElementById('dateFilter'));
        console.log('=== Daily Work Page Debug ===');
        console.log('List View button:', document.getElementById('listViewBtn'));
        
        // DIAGNOSTIC: Check if jQuery and DataTables are already loaded
        console.log('=== DataTables Debug Info ===');
        console.log('jQuery loaded:', typeof jQuery !== 'undefined');
        console.log('DataTables loaded:', typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined');



        // Check if table is already a DataTable instance

        if (typeof jQuery !== 'undefined') {

            var tableElement = $('#dailyWorkTablelist');

            console.log('Table element exists:', tableElement.length > 0);

            console.log('Table is already DataTable:', tableElement.length > 0 && tableElement.hasClass('dataTable'));

        }

    </script>



    <script>

        $(document).ready(function () {

            console.log('=== DataTables Initialization Started ===');



            // Check if already initialized before creating new instance

            if ($.fn.DataTable.isDataTable('#dailyWorkTablelist')) {

                console.log('Table already initialized, destroying existing instance first');

                $('#dailyWorkTablelist').DataTable().destroy();

            }



            let table = $('#dailyWorkTablelist').DataTable({

                ordering: true,
                order: [[0, 'desc']],

                pageLength: 10,

                lengthChange: true,

                lengthMenu: [10, 25, 50, 100],

                info: true,

                dom: 'lfrtip'

            });

            console.log('DataTable initialized successfully');



            // Column search

            $('#dailyWorkTablelist thead').on('keyup change', '.column-search', function () {

                let index = $(this).parent().index();

                table.column(index).search(this.value).draw();

            });



        });

    </script>

    <script>

        const statusStyles = {

            'pending': { border: 'border-blue-500', badge: 'bg-blue-100 text-blue-700', label: 'Pending' },

            'in-progress': { border: 'border-yellow-500', badge: 'bg-yellow-100 text-yellow-700', label: 'In Progress' },

            'completed': { border: 'border-green-500', badge: 'bg-green-100 text-green-700', label: 'Completed' }

        };



        let draggedCard = null;



        // Drag & Drop

        document.querySelectorAll('.draggable-card').forEach(card => {

            card.addEventListener('dragstart', e => {

                draggedCard = card;

                e.dataTransfer.setData('id', card.dataset.id);

            });

        });



        document.querySelectorAll('.cards-container').forEach(container => {

            container.addEventListener('dragover', e => e.preventDefault());

            container.addEventListener('drop', async e => {

                e.preventDefault();

                if (!draggedCard) return;



                const newStatus = container.id.replace('-cards', '');

                const oldStatus = draggedCard.dataset.status;

                const id = draggedCard.dataset.id;

                if (newStatus === oldStatus) return;



                container.appendChild(draggedCard);

                updateCardUI(draggedCard, newStatus);

                draggedCard.dataset.status = newStatus;



                try {

                    await fetch(`/daily-work/${id}/status`, {

                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': '{{ csrf_token() }}',

                            'Content-Type': 'application/json'

                        },

                        body: JSON.stringify({ status: newStatus })

                    });

                } catch {

                    alert('Failed to update status');

                    document.getElementById(oldStatus + '-cards').appendChild(draggedCard);

                    updateCardUI(draggedCard, oldStatus);

                    draggedCard.dataset.status = oldStatus;

                }

            });

        });



        function updateCardUI(card, status) {

            card.classList.remove('border-blue-500', 'border-yellow-500', 'border-green-500');

            card.classList.add(statusStyles[status].border);



            const badge = card.querySelector('.status-badge');

            badge.className = `status-badge text-xs px-2 py-1 rounded-full ${statusStyles[status].badge}`;

            badge.innerText = statusStyles[status].label;

        }



        // Pagination + Search for cards

        function setupPagination(columnId, perPage = 5) {

            const container = document.getElementById(columnId + '-cards');

            const cards = Array.from(container.children);

            const pagination = document.getElementById(columnId + '-pagination');

            let currentPage = 1;



            function renderPage(page) {

                currentPage = page;

                cards.forEach((card, i) => {

                    card.style.display = (i >= (page - 1) * perPage && i < page * perPage) ? 'block' : 'none';

                });



                const totalPages = Math.ceil(cards.length / perPage);

                pagination.innerHTML = `

                <button ${page === 1 ? 'disabled' : ''} class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">Prev</button>

                <span>Page ${page} / ${totalPages}</span>

                <button ${page === totalPages ? 'disabled' : ''} class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">Next</button>

            `;



                pagination.querySelector('button:first-child').onclick = () => { if (page > 1) renderPage(page - 1); };

                pagination.querySelector('button:last-child').onclick = () => { if (page < totalPages) renderPage(page + 1); };

            }



            renderPage(1);



            // Search box

            const searchInput = document.createElement('input');

            searchInput.type = 'text';

            searchInput.placeholder = 'Search cards...';

            searchInput.className = 'w-full mb-2 px-2 py-1 border rounded text-sm';

            container.parentNode.insertBefore(searchInput, container);



            searchInput.addEventListener('input', () => {

                const query = searchInput.value.toLowerCase();

                cards.forEach(card => {

                    const text = card.innerText.toLowerCase();

                    card.style.display = text.includes(query) ? 'block' : 'none';

                });

            });

        }



        // Initialize pagination for each column

        ['pending', 'in-progress', 'completed'].forEach(col => setupPagination(col, 5));

    </script>










    <script>
        // Date filter functionality







    <script>

        document.addEventListener('DOMContentLoaded', () => {



            const dateInput = document.getElementById('dateFilter');

            const clearBtn = document.getElementById('clearDateFilter');



            // -------- BOARD FILTER --------

            function filterBoardByDate(date) {

                document.querySelectorAll('.draggable-card').forEach(card => {

                    const cardDate = card.dataset.date;

                    card.style.display = (!date || cardDate === date) ? 'block' : 'none';

                });

            }



            // -------- LIST FILTER --------

            // function filterListByDate(date) {

            //     const table = $('#dailyWorkTablelist').DataTable();



            //     if (!date) {

            //         table.search('').draw();

            //         return;

            //     }



            //     table.rows().every(function () {

            //         const row = $(this.node());

            //         row.toggle(row.data('date') === date);

            //     });

            // }



            // ON DATE CHANGE

            dateInput.addEventListener('change', () => {

                const selectedDate = dateInput.value;

                filterBoardByDate(selectedDate);

                filterListByDate(selectedDate);

            });



            // CLEAR FILTER

            clearBtn.addEventListener('click', () => {

                dateInput.value = '';

                filterBoardByDate(null);

                filterListByDate(null);

            });



        });

    </script>











    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('dateFilter');
            const clearBtn = document.getElementById('clearDateFilter');
            
            // Get today's date in YYYY-MM-DD format
            const today = new Date().toISOString().split('T')[0];
            
            // Set default value to today
            dateInput.value = today;
            
            // Function to show/hide message when no date is selected
            function updateNoDateMessage(show) {
                let messageDiv = document.getElementById('noDateMessage');
                if (show) {
                    if (!messageDiv) {
                        messageDiv = document.createElement('div');
                        messageDiv.id = 'noDateMessage';
                        messageDiv.className = 'text-center py-8 text-gray-500';
                        messageDiv.innerHTML = '<p class="text-lg">No date selected. Please select today\'s date.</p>';
                        const tableContainer = document.querySelector('.dataTables_wrapper') || document.querySelector('#dailyWorkTablelist')?.parentElement;
                        if (tableContainer) {
                            tableContainer.insertBefore(messageDiv, tableContainer.firstChild);
                        }
                    }
                    messageDiv.style.display = 'block';
                } else {
                    if (messageDiv) {
                        messageDiv.style.display = 'none';
                    }
                }
            }

            function filterByDate(dateStr) {
                // Hide message when date is selected
                updateNoDateMessage(!dateStr);
                
                if (typeof jQuery !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
                    const table = $('#dailyWorkTablelist').DataTable();
                    $.fn.dataTable.ext.search = [];
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                        const rowDate = table.row(dataIndex).node()?.dataset?.date;
                        return !dateStr || rowDate === dateStr;
                    });
                    table.draw();
                }
                
                // Also filter board view if exists
                document.querySelectorAll('.draggable-card').forEach(card => {
                    const cardDate = card.dataset.date;
                    card.style.display = (!dateStr || cardDate === dateStr) ? 'block' : 'none';
                });
            }

            // Initial filter with today's date
            filterByDate(today);

            dateInput.addEventListener('change', function() {
                filterByDate(this.value);
            });

            clearBtn.addEventListener('click', function() {
                dateInput.value = '';
                filterByDate(null);
            });
        });
    </script>




    @endsection
<style>
</style>







<style>


    .fc-toolbar-title {

        font-size: 1.2rem !important;

    }



    @media (prefers-color-scheme: dark) {

        .dark\:bg-gray-900 {

            background-color: rgba(230, 230, 230, 0.05) !important;



        }
}

button#clearDateFilter {
    display: none !important;
}
</style>

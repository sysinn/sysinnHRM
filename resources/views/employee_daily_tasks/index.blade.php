@extends('layouts.app')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body { font-family:'Plus Jakarta Sans', sans-serif; background:#f8fafc; }
    .draggable-card { transition: all .2s; }
    .draggable-card:hover { transform: translateY(-2px); box-shadow:0 6px 15px rgba(0,0,0,.1); }
    .draggable-card:focus { outline: 2px solid #3b82f6; outline-offset: 2px; }
    [aria-disabled="true"] { opacity: 0.5; cursor: not-allowed; }
    .view-toggle-btn { transition: all .2s; }
    .view-toggle-btn.active { background: #3b82f6; color: white; }
    .list-view-row:hover { background: #f1f5f9; }
    </style>
@endsection

@section('content')
<div class="flex min-h-screen font-[PlusJakartaSans]">
    @include('layouts.sidebar')
    <main class="flex-1 bg-white p-8">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded" role="alert">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded" role="alert">{{ session('error') }}</div>
            @endif
            
            <!-- View Toggle -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Employee Daily Tasks</h1>
                <div class="flex gap-2 bg-gray-100 p-1 rounded-lg">
                    <button id="boardViewBtn" class="view-toggle-btn active px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2" onclick="switchView('board')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 4a1 1 0 011-1h12a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V4z" />
                            <path fill-rule="evenodd" d="M2 9a1 1 0 011-1h12a1 1 0 011 1v7a1 1 0 01-1 1H3a1 1 0 01-1-1V9z" clip-rule="evenodd" />
                        </svg>
                        Board View
                    </button>
                    <button id="listViewBtn" class="view-toggle-btn px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 text-gray-600 hover:text-gray-800" onclick="switchView('list')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        List View
                    </button>
                </div>
            </div>
            
            <!-- Board View -->
            <div id="boardView" class="view-container">
                <div class="flex gap-6 overflow-x-auto pb-4" role="list" aria-label="Task columns">
                    @php
                        $columns = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'];
                        $columnColors = ['pending' => 'border-blue-500 text-blue-600', 'in_progress' => 'border-yellow-500 text-yellow-600', 'completed' => 'border-green-500 text-green-600'];
                        $badgeColors = ['pending' => 'bg-blue-100 text-blue-700', 'in_progress' => 'bg-yellow-100 text-yellow-700', 'completed' => 'bg-green-100 text-green-700'];
                    @endphp
                    @foreach($columns as $status => $title)
                    <div class="w-80 bg-gray-50 rounded-xl p-4 flex-shrink-0 border-t-4 {{ $columnColors[$status] }}">
                        <h2 class="font-semibold mb-2 flex justify-between items-center">
                            <span>{{ $title }}</span>
                            <span class="text-xs bg-white px-2 py-1 rounded shadow">{{ $tasks->where('status', $status)->count() }}</span>
                        </h2>
                        <input type="text" placeholder="Search {{ $title }}" class="w-full px-2 py-1 mb-3 text-sm border rounded search-input" data-column="{{ $status }}" aria-label="Search {{ $title }} tasks">
                        <div class="cards-container min-h-[320px]" id="{{ $status }}-cards" role="listbox" aria-label="{{ $title }} tasks">
                            @foreach($tasks->where('status', $status) as $task)
                            <div class="bg-white rounded-xl p-4 shadow-sm draggable-card cursor-move border-l-4 {{ $columnColors[$status] }} mb-3" draggable="true" data-id="{{ $task->id }}" data-status="{{ $status }}" data-hidden="0" role="listitem" aria-label="Task: {{ $task->task_subject }}" tabindex="0">
                                <div class="flex justify-between items-start mb-1">
                                    <a href="{{ route('employee-daily-tasks.show', $task) }}" class="font-medium text-gray-800 hover:underline">{{ $task->task_subject }}</a>
                                    <span class="status-badge text-xs px-2 py-1 rounded-full {{ $badgeColors[$status] }}">{{ $title }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ Str::limit($task->task_description, 80) }}</p>
                                <div class="flex justify-between items-center mt-3 text-xs text-gray-400">
                                    <span>{{ \Carbon\Carbon::parse($task->task_date)->format('d M Y') }}</span>
                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $task->employee->first_name }} {{ $task->employee->last_name }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center mt-3 text-xs" id="{{ $status }}-pagination" role="navigation" aria-label="{{ $title }} pagination"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- List View -->
            <div id="listView" class="view-container hidden">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tasks as $task)
                            <tr class="list-view-row">
                                <td class="px-6 py-4">
                                    <a href="{{ route('employee-daily-tasks.show', $task) }}" class="font-medium text-gray-800 hover:underline">{{ $task->task_subject }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($task->task_description, 80) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = ['pending' => 'bg-blue-100 text-blue-700', 'in_progress' => 'bg-yellow-100 text-yellow-700', 'completed' => 'bg-green-100 text-green-700'];
                                        $statusTitles = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'];
                                    @endphp
                                    <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$task->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $statusTitles[$task->status] ?? ucfirst($task->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($task->task_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $task->employee->first_name }} {{ $task->employee->last_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <a href="{{ route('employee-daily-tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <a href="{{ route('employee-daily-tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($tasks->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        No tasks found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    const PER_PAGE = 5;
    const CSRF_TOKEN = '{{ csrf_token() }}';
    
    console.log('CSRF Token:', CSRF_TOKEN);
    
    // Column setup with search and pagination
    function setupColumn(status) {
        const container = document.getElementById(status + '-cards');
        const pagination = document.getElementById(status + '-pagination');
        const searchInput = document.querySelector('.search-input[data-column="' + status + '"]');
        
        if (!container || !pagination) {
            console.error('Column elements not found for status:', status);
            return null;
        }
        
        let page = 1;
        
        function getCards() {
            return Array.from(container.children);
        }
        
        function render() {
            const cards = getCards();
            const visibleCards = cards.filter(function(c) { return c.dataset.hidden === '0'; });
            const total = Math.max(1, Math.ceil(visibleCards.length / PER_PAGE));
            
            cards.forEach(function(card, i) {
                const isVisible = card.dataset.hidden === '0' && 
                                  i >= (page - 1) * PER_PAGE && 
                                  i < page * PER_PAGE;
                card.style.display = isVisible ? 'block' : 'none';
            });
            
            pagination.innerHTML = 
                '<button ' + (page === 1 ? 'disabled' : '') + ' class="px-2 py-1 bg-gray-200 rounded" aria-label="Previous page">Prev</button>' +
                '<span aria-live="polite">Page ' + page + ' / ' + total + '</span>' +
                '<button ' + (page === total ? 'disabled' : '') + ' class="px-2 py-1 bg-gray-200 rounded" aria-label="Next page">Next</button>';
            
            var buttons = pagination.querySelectorAll('button');
            if (buttons.length >= 2) {
                buttons[0].onclick = function() { if (page > 1) { page--; render(); }};
                buttons[1].onclick = function() { if (page < total) { page++; render(); }};
            }
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                var q = searchInput.value.toLowerCase();
                var cards = getCards();
                cards.forEach(function(card) {
                    var text = card.innerText || '';
                    card.dataset.hidden = text.toLowerCase().indexOf(q) !== -1 ? '0' : '1';
                });
                page = 1;
                render();
            });
        }
        
        render();
        return { container: container, pagination: pagination, render: render, getCards: getCards };
    }
    
    // Initialize columns
    var columns = {
        pending: setupColumn('pending'),
        in_progress: setupColumn('in_progress'),
        completed: setupColumn('completed')
    };
    
    // Drag and drop handling
    var dragged = null;
    
    document.addEventListener('dragstart', function(e) {
        if (e.target.classList && e.target.classList.contains('draggable-card')) {
            dragged = e.target;
            e.target.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
        }
    });
    
    document.addEventListener('dragend', function(e) {
        if (e.target.classList && e.target.classList.contains('draggable-card')) {
            e.target.classList.remove('dragging');
            dragged = null;
        }
    });
    
    document.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });
    
    document.addEventListener('drop', function(e) {
        var container = e.target.closest('.cards-container');
        if (!container || !dragged) return;
        
        e.preventDefault();
        
        var newStatus = container.id.replace('-cards','');
        var oldStatus = dragged.dataset.status;
        
        if (newStatus === oldStatus) return;
        
        console.log('Moving card from', oldStatus, 'to', newStatus);
        
        // Move card in DOM
        container.appendChild(dragged);
        dragged.dataset.status = newStatus;
        dragged.dataset.hidden = '0';
        
        // Update card styling
        var statusBadge = dragged.querySelector('.status-badge');
        var colors = {
            pending: 'bg-blue-100 text-blue-700',
            in_progress: 'bg-yellow-100 text-yellow-700',
            completed: 'bg-green-100 text-green-700'
        };
        var titles = {
            pending: 'Pending',
            in_progress: 'In Progress',
            completed: 'Completed'
        };
        var borderColors = {
            pending: 'border-blue-500 text-blue-600',
            in_progress: 'border-yellow-500 text-yellow-600',
            completed: 'border-green-500 text-green-600'
        };
        
        if (statusBadge) {
            statusBadge.className = 'status-badge text-xs px-2 py-1 rounded-full ' + colors[newStatus];
            statusBadge.textContent = titles[newStatus];
        }
        
        // Update border color
        dragged.classList.remove('border-blue-500', 'border-yellow-500', 'border-green-500', 'text-blue-600', 'text-yellow-600', 'text-green-600');
        var newBorderColors = borderColors[newStatus].split(' ');
        for (var i = 0; i < newBorderColors.length; i++) {
            dragged.classList.add(newBorderColors[i]);
        }
        
        // Re-render columns
        if (columns[oldStatus] && columns[oldStatus].render) columns[oldStatus].render();
        if (columns[newStatus] && columns[newStatus].render) columns[newStatus].render();
        
        // Make API call
        var taskId = dragged.dataset.id;
        var url = '/employee-daily-tasks/' + taskId + '/status';
        
        console.log('Sending request to:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(function(response) {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            console.log('Status updated successfully:', data);
        })
        .catch(function(error) {
            console.error('Error updating task status:', error);
            
            // Revert changes on error
            var originalContainer = document.getElementById(oldStatus + '-cards');
            if (originalContainer) {
                originalContainer.appendChild(dragged);
                dragged.dataset.status = oldStatus;
                
                // Revert badge
                if (statusBadge) {
                    statusBadge.className = 'status-badge text-xs px-2 py-1 rounded-full ' + colors[oldStatus];
                    statusBadge.textContent = titles[oldStatus];
                }
                
                // Revert border
                dragged.classList.remove('border-blue-500', 'border-yellow-500', 'border-green-500', 'text-blue-600', 'text-yellow-600', 'text-green-600');
                var oldBorderColors = borderColors[oldStatus].split(' ');
                for (var i = 0; i < oldBorderColors.length; i++) {
                    dragged.classList.add(oldBorderColors[i]);
                }
            }
            
            if (columns[oldStatus] && columns[oldStatus].render) columns[oldStatus].render();
            if (columns[newStatus] && columns[newStatus].render) columns[newStatus].render();
            
            alert('Failed to update task status: ' + error.message);
        });
    });
    
    console.log('Kanban board initialized');
    
    // View toggle functionality
    window.switchView = function(view) {
        var boardView = document.getElementById('boardView');
        var listView = document.getElementById('listView');
        var boardBtn = document.getElementById('boardViewBtn');
        var listBtn = document.getElementById('listViewBtn');
        
        if (view === 'board') {
            boardView.classList.remove('hidden');
            listView.classList.add('hidden');
            boardBtn.classList.add('active');
            boardBtn.classList.remove('text-gray-600', 'hover:text-gray-800');
            listBtn.classList.remove('active');
            listBtn.classList.add('text-gray-600', 'hover:text-gray-800');
            // Save preference
            localStorage.setItem('taskViewPreference', 'board');
        } else {
            boardView.classList.add('hidden');
            listView.classList.remove('hidden');
            listBtn.classList.add('active');
            listBtn.classList.remove('text-gray-600', 'hover:text-gray-800');
            boardBtn.classList.remove('active');
            boardBtn.classList.add('text-gray-600', 'hover:text-gray-800');
            // Save preference
            localStorage.setItem('taskViewPreference', 'list');
        }
    };
    
    // Load saved preference
    var savedView = localStorage.getItem('taskViewPreference');
    if (savedView) {
        switchView(savedView);
    }
});
</script>
@endsection

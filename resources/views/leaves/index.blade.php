@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold">Employee Leave Requests</h1>
                <a href="{{ route('leaves.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">Request Leave</a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Employee</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Dates</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                                <td class="px-4 py-2 capitalize">{{ $leave->type }}</td>
                                <td class="px-4 py-2">{{ $leave->start_date }} to {{ $leave->end_date }}</td>
                                <td class="px-4 py-2 capitalize">{{ $leave->status }}</td>
                                <td>
    {{ $leave->status }}

    @if(!Auth::user()->roles->contains('id', 9))
        <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    @endif
</td>

                                <td class="px-4 py-2">{{ $leave->reason ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">No leave records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection

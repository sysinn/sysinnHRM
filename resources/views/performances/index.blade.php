@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Employee Performance</h1>
            <a href="{{ route('performances.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Review</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Employee</th>
                    <th class="px-4 py-2">Rating</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($performances as $performance)
                <tr class="border-t">
                    <td class="px-4 py-2">
    {{ $performance->employee->first_name }} {{ $performance->employee->last_name }}
</td>
                    <td class="px-4 py-2">{{ $performance->rating }}/5</td>
                    <td class="px-4 py-2">{{ $performance->status }}</td>
                    <td class="px-4 py-2">{{ $performance->review_date }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('performances.show',$performance) }}" class="text-green-600">View</a>
                        <a href="{{ route('performances.edit',$performance) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('performances.destroy',$performance) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Delete this review?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $performances->links() }}
        </div>
    </main>
</div>
@endsection

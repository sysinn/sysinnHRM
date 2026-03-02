@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <h1 class="text-2xl font-bold mb-6">Performance Review Details</h1>

        <div class="bg-gray-50 p-6 rounded shadow space-y-4">
            <p><strong>Employee:</strong> {{ $performance->employee->name }}</p>
            <p><strong>Rating:</strong> {{ $performance->rating }}/5</p>
            <p><strong>Status:</strong> {{ $performance->status }}</p>
            <p><strong>Review Date:</strong> {{ $performance->review_date }}</p>
            <p><strong>Reviewed By:</strong> {{ $performance->reviewed_by }}</p>
            <p><strong>Review:</strong> {{ $performance->review }}</p>
            <p><strong>Goals:</strong> {{ $performance->goals }}</p>
            <p><strong>Achievements:</strong> {{ $performance->achievements }}</p>
            <p><strong>Improvement Areas:</strong> {{ $performance->improvement_area }}</p>
            <p><strong>Training Recommended:</strong> {{ $performance->training_recommended }}</p>
            <p><strong>Remarks:</strong> {{ $performance->remarks }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('performances.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Back</a>
        </div>
    </main>
</div>
@endsection

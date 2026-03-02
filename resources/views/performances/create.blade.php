@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <h1 class="text-2xl font-bold mb-6">Add Performance Review</h1>

        <form action="{{ route('performances.store') }}" method="POST" class="space-y-4">
            @csrf

            @include('performances.partials.form', ['performance' => null])

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </main>
</div>
@endsection

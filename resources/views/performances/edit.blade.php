@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <h1 class="text-2xl font-bold mb-6">Edit Performance Review</h1>

        <form action="{{ route('performances.update',$performance) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            @include('performances.partials.form', ['performance' => $performance])

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </main>
</div>
@endsection

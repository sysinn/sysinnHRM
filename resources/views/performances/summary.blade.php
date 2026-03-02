@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-6xl mx-auto">

            <h1 class="text-2xl font-bold mb-6">📊 Performance Summary</h1>

            {{-- All Employees Summary --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Overall Performance</h2>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Employee</th>
                            <th class="border p-2">Average Rating</th>
                            <th class="border p-2">Total Reviews</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summary as $item)
                            <tr>
                                <td class="border p-2">{{ $item->employee?->first_name }} {{ $item->employee?->last_name }}</td>
                                <td class="border p-2">{{ number_format($item->avg_rating, 2) }}</td>
                                <td class="border p-2">{{ $item->reviews_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Top Performers --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-green-600">🏆 Top Performers</h2>
                <ul class="list-disc list-inside">
                    @foreach($topPerformers as $tp)
                        <li>
                            {{ $tp->employee?->first_name }} {{ $tp->employee?->last_name }}
                            — Avg: {{ number_format($tp->avg_rating, 2) }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Low Performers --}}
            <div>
                <h2 class="text-xl font-semibold mb-4 text-red-600">⚠️ Needs Improvement</h2>
                <ul class="list-disc list-inside">
                    @foreach($lowPerformers as $lp)
                        <li>
                            {{ $lp->employee?->first_name }} {{ $lp->employee?->last_name }}
                            — Avg: {{ number_format($lp->avg_rating, 2) }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </main>
</div>
@endsection

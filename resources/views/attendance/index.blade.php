@extends('layouts.app')

@section('content')
<style>
    button.bg-green-500 { background-color: blue !important; }
    button.bg-red-500 { background-color: red !important; }
    button.bg-yellow-500 { background-color: orange !important; }
</style>

<div class="flex min-h-screen px-5">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white py-5 px-5">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">
                    Attendance & Time Tracking
                </h1>

                <!-- Work Timer -->
                <div class="text-lg font-semibold text-blue-700 dark:text-blue-300">
                    Work Duration: <span id="work-timer">00:00:00</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2 mb-6">
                @if (!$isClockedIn)
                <!-- Clock In -->
                <form method="POST" action="{{ route('attendance.clock-in') }}" id="clockInForm">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded" id="clockInBtn">Clock In</button>
                </form>
                @endif

                @if ($isClockedIn && !$isClockedOut)
                <!-- Clock Out -->
                <form method="POST" action="{{ route('attendance.clock-out') }}" id="clockOutForm">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded" id="clockOutBtn">Clock Out</button>
                </form>

                <!-- Break -->
                @php $onBreak = session('onBreak') ?? false; @endphp
                <form method="POST" action="{{ route('attendance.break') }}" id="breakForm">
                    @csrf
                    <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded" id="breakButton">
                        {{ $onBreak ? 'Resume Work' : 'Take a Break' }}
                    </button>
                </form>
                @endif
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            @if ($clockInTime)
                <div class="mb-4 text-blue-700 dark:text-blue-300">
                    Clocked in at: <strong>{{ \Carbon\Carbon::parse($clockInTime)->format('h:i A') }}</strong>
                </div>
            @endif

            <!-- Attendance Table -->
            <div class="overflow-x-auto bg-white">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Date</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Clock In</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Clock Out</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Breaks</th>
                        </tr>
                    </thead>
                    <tbody class=",t-5">
                        @forelse ($attendances as $attendance)
                        <tr>
                            <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $attendance->date }}</td>
                            <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $attendance->clock_in }}</td>
                            <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $attendance->clock_out ?? '—' }}</td>
                            <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">
                                @forelse ($attendance->breaks as $break)
                                    <div class="mb-1">
                                        <strong>Start:</strong> {{ \Carbon\Carbon::parse($break->break_start)->format('h:i A') }}<br>
                                        <strong>End:</strong> {{ $break->break_end ? \Carbon\Carbon::parse($break->break_end)->format('h:i A') : 'In Progress' }}
                                    </div>
                                @empty
                                    <span class="text-gray-500">No breaks</span>
                                @endforelse
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No attendance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </main>
</div>

<!-- Work Timer Script -->
<script>
    const clockInTimestamp = {{ $clockInTime ? \Carbon\Carbon::parse($clockInTime)->timestamp : 'null' }};
    const onBreak = @json(session('onBreak'));
    let timerInterval = null;
    let elapsed = 0;

    function formatTime(seconds) {
        const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
        const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
        const secs = String(seconds % 60).padStart(2, '0');
        return `${hrs}:${mins}:${secs}`;
    }

    function startTimerFrom(secondsElapsed) {
        elapsed = secondsElapsed;
        document.getElementById('work-timer').textContent = formatTime(elapsed);
        if (timerInterval) clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            elapsed++;
            document.getElementById('work-timer').textContent = formatTime(elapsed);
        }, 1000);
    }

    function pauseTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (clockInTimestamp) {
            const now = Math.floor(Date.now() / 1000);
            const secondsElapsed = now - clockInTimestamp;

            if (!onBreak) {
                startTimerFrom(secondsElapsed);
            } else {
                document.getElementById('work-timer').textContent = formatTime(secondsElapsed);
                pauseTimer();
            }
        }
    });
</script>
@endsection

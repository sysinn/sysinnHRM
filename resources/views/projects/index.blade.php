@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Projects</h1>
                <a href="{{ route('projects.create') }}"
                   class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
                    <ion-icon name="add-circle-outline"></ion-icon>
                    <span class="text-[14px] font-[400] font-[DM-sans] text-white">Add New</span>
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white shadow-sm rounded">
              <table id="projectsTable" class="min-w-full">
                <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Client</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Priority</th>
                        <th class="px-4 py-2">Assigned To</th>
                    </tr>
                    <tr>
                        <th><input type="text" placeholder="Search Name" class="w-full px-2 py-1 text-sm border" /></th>
                        <th><input type="text" placeholder="Search Client" class="w-full px-2 py-1 text-sm border" /></th>
                        <th><input type="text" placeholder="Search Status" class="w-full px-2 py-1 text-sm border" /></th>
                        <th><input type="text" placeholder="Search Priority" class="w-full px-2 py-1 text-sm border" /></th>
                        <th><input type="text" placeholder="Search Employee" class="w-full px-2 py-1 text-sm border" /></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 hover:underline">
                                    {{ $project->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $project->client_name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($project->status) }}</td>
                            <td class="px-4 py-2">{{ ucfirst($project->priority) }}</td>
                            <td class="px-4 py-2">
                                {{ $project->assignedEmployee ? $project->assignedEmployee->first_name . ' ' . $project->assignedEmployee->last_name : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        let table = $('#projectsTable').DataTable({
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    $('input', column.header()).on('keyup change clear', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                });
            }
        });
    });
</script>
@endsection

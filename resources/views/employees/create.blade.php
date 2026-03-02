@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white xl:p-0 p-[1rem] ">
  @include('layouts.sidebar')

  <main class="flex-1">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-md py-4">
      <h2 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">Add New Employee</h2>

      <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

       <div class="flex space-x-4">
  <div class="w-1/2">
    <label for="first_name" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">First Name</label>
    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
           class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
    @error('first_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-1/2">
    <label for="last_name" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Last Name</label>
    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
           class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
    @error('last_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
</div>


        <div>
          <label for="email" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}"
                 class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="password" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Password</label>
          <input type="password" name="password" id="password"
                 class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="phone" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Phone</label>
          <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                 class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
        <label for="position_id" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Position</label>
        <select name="position_id" id="position_id"
                class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          <option value="">Select position</option>
          @foreach($positions as $pos)
            <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>
              {{ $pos->name }}
            </option>
          @endforeach
        </select>
        @error('position_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

        <div>
          <label for="department_id" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Department</label>
          <select name="department_id" id="department_id"
                  class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
            <option value="">Select department</option>
            @foreach($departments as $dept)
              <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
              </option>
            @endforeach
          </select>
          @error('department_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="salary" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Salary</label>
          <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary') }}"
                 class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          @error('salary') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="hired_at" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Hire Date</label>
          <input type="date" name="hired_at" id="hired_at" value="{{ old('hired_at') }}"
                 class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
          @error('hired_at') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>


        <div>
  <label class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Search Roles</label>
  
  <!-- Search Input -->
  <input type="text" id="roleSearch"
         placeholder="Type to search roles..."
         class="mt-1 block w-full px-4 py-2 mb-3 rounded-[2px] border border-[#B4B4B4]">

  <!-- Checkboxes List -->
  <div id="rolesList" class="space-y-2 max-h-48 overflow-y-auto border p-3 rounded-md">
    @foreach($roles as $role)
      <label class="flex items-center role-item">
        <input type="checkbox" name="role_id[]" class="form-checkbox rounded-[2px] border border-[#B4B4B4]" value="{{ $role->id }}"
               {{ is_array(old('role_id')) && in_array($role->id, old('role_id')) ? 'checked' : '' }}
               >
        <span class="ml-2 text-gray-700">{{ ucfirst($role->name) }}</span>
      </label>
    @endforeach
  </div>

  @error('role_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>


        <div>
          <label for="profile_picture" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Profile Picture</label>
          <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                 class="mt-1 block w-full text-gray-700">
          @error('profile_picture') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between pt-4">
          <button type="submit"
                  class="bg-[#0057D8] font-[DM-sans] text-[16px] font-[500] text-white font-semibold py-2 px-6 rounded-[6px]">
            Save Employee
          </button>
          <a href="{{ route('employees.index') }}"
             class="text-gray-600 hover:text-blue-600 font-medium hover:underline">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </main>
</div>
@endsection



<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('roleSearch');
    const roleItems = document.querySelectorAll('.role-item');

    searchInput.addEventListener('input', function () {
      const query = searchInput.value.toLowerCase();

      roleItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(query) ? '' : 'none';
      });
    });
  });
</script>

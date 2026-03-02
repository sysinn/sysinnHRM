<div>
    <label class="block mb-1">Employee</label>
<select name="employee_id" class="border rounded p-2 w-full">
    @foreach($employees as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</select>

</div>

<div>
    <label class="block mb-1">Rating (1-5)</label>
    <input type="number" name="rating" class="w-full border rounded p-2" min="1" max="5" 
           value="{{ old('rating', $performance->rating ?? '') }}">
</div>

<div>
    <label class="block mb-1">Status</label>
    <select name="status" class="w-full border rounded p-2">
        @foreach(['Excellent','Good','Average','Poor'] as $status)
            <option value="{{ $status }}" 
                {{ old('status', $performance->status ?? '') == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block mb-1">Review Date</label>
    <input type="date" name="review_date" class="w-full border rounded p-2" 
           value="{{ old('review_date', $performance->review_date ?? '') }}">
</div>

<div>
    <label class="block mb-1">Reviewed By</label>
    <input type="text" name="reviewed_by" class="w-full border rounded p-2" 
           value="{{ old('reviewed_by', $performance->reviewed_by ?? '') }}">
</div>

<div>
    <label class="block mb-1">Review</label>
    <textarea name="review" class="w-full border rounded p-2">{{ old('review', $performance->review ?? '') }}</textarea>
</div>

<div>
    <label class="block mb-1">Goals</label>
    <input type="text" name="goals" class="w-full border rounded p-2" 
           value="{{ old('goals', $performance->goals ?? '') }}">
</div>

<div>
    <label class="block mb-1">Achievements</label>
    <input type="text" name="achievements" class="w-full border rounded p-2" 
           value="{{ old('achievements', $performance->achievements ?? '') }}">
</div>

<div>
    <label class="block mb-1">Improvement Areas</label>
    <input type="text" name="improvement_area" class="w-full border rounded p-2" 
           value="{{ old('improvement_area', $performance->improvement_area ?? '') }}">
</div>

<div>
    <label class="block mb-1">Training Recommended</label>
    <input type="text" name="training_recommended" class="w-full border rounded p-2" 
           value="{{ old('training_recommended', $performance->training_recommended ?? '') }}">
</div>

<div>
    <label class="block mb-1">Remarks</label>
    <textarea name="remarks" class="w-full border rounded p-2">{{ old('remarks', $performance->remarks ?? '') }}</textarea>
</div>

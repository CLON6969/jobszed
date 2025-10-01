<div>
    <label class="block font-medium">Title</label>
    <input type="text" name="title" value="{{ old('title', $budget->title ?? '') }}" required class="input" />
    @error('title') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Amount</label>
    <input type="number" step="0.01" name="amount" value="{{ old('amount', $budget->amount ?? '') }}" required class="input" />
    @error('amount') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Category</label>
    <input type="text" name="category" value="{{ old('category', $budget->category ?? '') }}" class="input" />
</div>

<div>
    <label class="block font-medium">Start Date</label>
    <input type="date" name="start_date" value="{{ old('start_date', $budget->start_date ?? '') }}" required class="input" />
    @error('start_date') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">End Date</label>
    <input type="date" name="end_date" value="{{ old('end_date', $budget->end_date ?? '') }}" required class="input" />
    @error('end_date') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Assigned To</label>
    <select name="user_id" class="input">
        <option value="">None</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected(old('user_id', $budget->user_id ?? '') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block font-medium">Notes</label>
    <textarea name="notes" class="input">{{ old('notes', $budget->notes ?? '') }}</textarea>
</div>

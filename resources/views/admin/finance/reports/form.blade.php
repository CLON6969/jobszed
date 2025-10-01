<div>
    <label class="block font-medium">Invoice Number</label>
    <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number ?? '') }}" required class="input" />
    @error('invoice_number') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Client Name</label>
    <input type="text" name="client_name" value="{{ old('client_name', $invoice->client_name ?? '') }}" required class="input" />
    @error('client_name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Amount</label>
    <input type="number" step="0.01" name="amount" value="{{ old('amount', $invoice->amount ?? '') }}" required class="input" />
    @error('amount') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Due Date</label>
    <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date ?? '') }}" required class="input" />
    @error('due_date') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div>
    <label class="block font-medium">Status</label>
    <select name="status" class="input" required>
        <option value="unpaid" @selected(old('status', $invoice->status ?? '') === 'unpaid')>Unpaid</option>
        <option value="paid" @selected(old('status', $invoice->status ?? '') === 'paid')>Paid</option>
        <option value="overdue" @selected(old('status', $invoice->status ?? '') === 'overdue')>Overdue</option>
    </select>
</div>

<div>
    <label class="block font-medium">Notes</label>
    <textarea name="notes" class="input">{{ old('notes', $invoice->notes ?? '') }}</textarea>
</div>

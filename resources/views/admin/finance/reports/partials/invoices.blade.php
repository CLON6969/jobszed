<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-3">Invoices</h2>
    <table class="table-auto w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Invoice #</th>
                <th class="px-4 py-2 text-left">Client</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $invoice)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $invoice->invoice_number }}</td>
                    <td class="px-4 py-2">{{ $invoice->client_name }}</td>
                    <td class="px-4 py-2">${{ number_format($invoice->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ ucfirst($invoice->status) }}</td>
                    <td class="px-4 py-2">{{ $invoice->due_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

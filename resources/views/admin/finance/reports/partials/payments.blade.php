<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-3">Payments</h2>
    <table class="table-auto w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">User</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Method</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $payment)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $payment->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">${{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                    <td class="px-4 py-2">{{ ucfirst($payment->status) }}</td>
                    <td class="px-4 py-2">{{ $payment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

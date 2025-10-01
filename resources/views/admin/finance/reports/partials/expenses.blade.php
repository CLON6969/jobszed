<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-3">Expenses</h2>
    <table class="table-auto w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Category</th>
                <th class="px-4 py-2 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $expense)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $expense->title }}</td>
                    <td class="px-4 py-2">${{ number_format($expense->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $expense->category ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $expense->date}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

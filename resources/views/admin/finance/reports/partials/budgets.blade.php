<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-3">Budgets</h2>
    <table class="table-auto w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">User</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Period</th>
                <th class="px-4 py-2 text-left">Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $budget)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $budget->title }}</td>
                    <td class="px-4 py-2">{{ $budget->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">${{ number_format($budget->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $budget->start_date }} – {{ $budget->end_date }}</td>
                    <td class="px-4 py-2">{{ $budget->category ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

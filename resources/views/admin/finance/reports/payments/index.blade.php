@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Payments Report</h1>
  @include('admin.finance.reports.partials.filters', ['type' => 'payments'])

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border rounded">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Payment ID</th>
          <th class="px-4 py-2">Payer</th>
          <th class="px-4 py-2">Method</th>
          <th class="px-4 py-2">Amount</th>
          <th class="px-4 py-2">Currency</th>
          <th class="px-4 py-2">Transaction ID</th>
          <th class="px-4 py-2">Reference</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Paid Date</th>
          <th class="px-4 py-2">Subscription/Invoice</th>
          <th class="px-4 py-2">Gateway Response</th>
          <th class="px-4 py-2">Notes</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($payments as $payment)
        <tr>
          <td class="border px-4 py-2">{{ $payment->id }}</td>
          <td class="border px-4 py-2">{{ $payment->payer->name ?? 'N/A' }}</td>
          <td class="border px-4 py-2">{{ $payment->method }}</td>
          <td class="border px-4 py-2">{{ $payment->amount }}</td>
          <td class="border px-4 py-2">{{ $payment->currency }}</td>
          <td class="border px-4 py-2">{{ $payment->transaction_id }}</td>
          <td class="border px-4 py-2">{{ $payment->reference }}</td>
          <td class="border px-4 py-2">{{ ucfirst($payment->status) }}</td>
          <td class="border px-4 py-2">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '—' }}</td>
          <td class="border px-4 py-2">
            @if ($payment->subscription)
              Sub #{{ $payment->subscription->id }}
            @elseif ($payment->invoice)
              Inv #{{ $payment->invoice->invoice_number }}
            @else
              —
            @endif
          </td>
          <td class="border px-4 py-2 text-xs">{{ Str::limit($payment->gateway_response, 50) }}</td>
          <td class="border px-4 py-2 text-xs">{{ $payment->notes }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="12" class="text-center py-4">No payments found for the selected filters.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $payments->links() }}
  </div>

</div>
@endsection



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Payments Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Payer</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Txn ID</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Paid At</th>
                <th>Related</th>
                <th>Gateway Response</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ optional($payment->user)->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->currency }}</td>
                <td>{{ $payment->transaction_id }}</td>
                <td>{{ $payment->reference }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>{{ optional($payment->paid_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $payment->subscription_id ? 'Subscription #' . $payment->subscription_id : '—' }}</td>
                <td>{{ $payment->gateway_response }}</td>
                <td>{{ $payment->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

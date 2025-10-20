@extends('layouts.Seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Send Message to Customer</h2>

<form action="{{ route('Seller.messages.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label for="receiver_id" class="block font-medium">Select Customer</label>
        <select name="receiver_id" id="receiver_id" class="w-full border rounded-lg p-2" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="message" class="block font-medium">Message</label>
        <textarea name="message" id="message" rows="4" class="w-full border rounded-lg" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
@endsection

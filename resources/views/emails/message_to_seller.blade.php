<h2>New Product Inquiry</h2>

<p><strong>Product:</strong> {{ $product->name }}</p>

<p><strong>Message:</strong></p>
<p>{{ $messageContent }}</p>

@if($guest_name && $guest_email)
    <p><strong>From:</strong> {{ $guest_name }} ({{ $guest_email }})</p>
@else
    <p>From a registered user.</p>
@endif

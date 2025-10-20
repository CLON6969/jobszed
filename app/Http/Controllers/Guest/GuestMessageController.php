<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use App\Models\GuestSession;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class GuestMessageController extends Controller
{
    /**
     * Handle a guest inquiry via WhatsApp.
     */
    public function sendViaWhatsApp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'guest_name' => 'nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::with('seller')->findOrFail($request->product_id);

        // Build the WhatsApp message link
        $whatsappMessage = urlencode("Hello, I'm interested in your product: {$product->name}. \n\n{$request->message}");
        $whatsappUrl = "https://wa.me/{$product->seller->whatsapp_number}?text={$whatsappMessage}";

        // Log guest analytics event
        AnalyticsEvent::create([
            'seller_id'  => $product->seller->id,
            'product_id' => $product->id,
            'event_type' => 'guest_whatsapp_inquiry',
            'event_data' => [
                'guest_phone' => $request->guest_phone,
                'guest_name'  => $request->guest_name,
                'message'     => $request->message,
            ],
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);

        // Optionally record guest session
        $this->trackGuestSession($request, $product->id, 'whatsapp_inquiry');

        return response()->json([
            'message' => 'WhatsApp inquiry sent successfully!',
            'redirect_url' => $whatsappUrl,
        ]);
    }

    /**
     * Handle a guest inquiry via Email.
     */
    public function sendViaEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::with('seller')->findOrFail($request->product_id);

        // Store the message in DB (not tied to a user)
        $storedMessage = Message::create([
            'sender_id'   => null, // guest
            'receiver_id' => $product->seller->id,
            'product_id'  => $product->id,
            'content'     => "{$request->guest_name} ({$request->guest_email}): {$request->message}",
            'channel'     => 'email',
            'status'      => 'guest_sent',
        ]);

        // Optionally send real email (if configured)
        // Mail::to($product->seller->email)->send(new GuestInquiryMail($storedMessage));

        // Log analytics
        AnalyticsEvent::create([
            'seller_id'  => $product->seller->id,
            'product_id' => $product->id,
            'event_type' => 'guest_email_inquiry',
            'event_data' => [
                'guest_email' => $request->guest_email,
                'guest_name'  => $request->guest_name,
                'message'     => $request->message,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $this->trackGuestSession($request, $product->id, 'email_inquiry');

        return response()->json([
            'message' => 'Your inquiry has been sent to the seller successfully!',
        ]);
    }

    /**
     * Track guest interaction session (Hybrid Model).
     */
    protected function trackGuestSession(Request $request, $productId, $interactionType)
    {
        $sessionToken = $request->cookie('guest_session_token') ?? bin2hex(random_bytes(16));

        $session = GuestSession::firstOrCreate(
            ['session_token' => $sessionToken],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'interactions' => [],
                'expires_at' => now()->addDays(7),
            ]
        );

        $interactions = $session->interactions ?? [];
        $interactions[] = [
            'product_id' => $productId,
            'type' => $interactionType,
            'timestamp' => now()->toDateTimeString(),
        ];

        $session->update(['interactions' => $interactions]);

        cookie()->queue('guest_session_token', $sessionToken, 10080); // 7 days
    }
}

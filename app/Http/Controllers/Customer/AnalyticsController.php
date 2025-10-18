<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role_id !== 4) {
            abort(403, 'Unauthorized');
        }

        $analytics = AnalyticsEvent::where('user_id', $user->id)
            ->with('product', 'seller')
            ->latest()
            ->paginate(10);

        return view('user.Customer.analytics.index', compact('analytics'));
    }

    public function show(AnalyticsEvent $analyticsEvent)
    {
        $this->authorizeAccess($analyticsEvent);

        return view('user.Customer.analytics.show', compact('analyticsEvent'));
    }

    private function authorizeAccess(AnalyticsEvent $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    }
}

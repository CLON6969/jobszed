<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        return response()->json(AnalyticsEvent::latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'product_id' => 'nullable|exists:products,id',
            'event_type' => 'required|string',
            'event_data' => 'nullable|json',
            'ip_address' => 'nullable|string',
            'user_agent' => 'nullable|string',
        ]);

        $event = AnalyticsEvent::create($data);
        return response()->json($event, 201);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $events = AnalyticsEvent::with('user','product')->paginate(50);
        return view('admin.analytics.index', compact('events'));
    }

    public function filter(Request $request)
    {
        $query = AnalyticsEvent::query();
        if($request->user_id) $query->where('user_id',$request->user_id);
        if($request->product_id) $query->where('product_id',$request->product_id);
        if($request->event_type) $query->where('event_type',$request->event_type);

        $events = $query->paginate(50);
        return view('admin.analytics.index', compact('events'));
    }
}

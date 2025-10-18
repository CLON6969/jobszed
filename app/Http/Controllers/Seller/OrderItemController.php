<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::whereHas('order', fn($q)=>$q->where('seller_id', auth()->id()))->with('product','variation')->paginate(20);
        return view('seller.orderitems.index', compact('items'));
    }
}

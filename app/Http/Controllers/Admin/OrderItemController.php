<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::with('product','variation','order')->paginate(20);
        return view('admin.orderitems.index', compact('items'));
    }

    public function destroy(OrderItem $item)
    {
        $item->delete();
        return redirect()->route('admin.orderitem.index')->with('success','Order item deleted');
    }
}

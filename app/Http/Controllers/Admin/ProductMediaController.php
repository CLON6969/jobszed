<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductMedia;

class ProductMediaController extends Controller
{
    public function index()
    {
        $media = ProductMedia::with('product')->paginate(20);
        return view('admin.media.index', compact('media'));
    }

    public function destroy(ProductMedia $media)
    {
        $media->delete();
        return redirect()->route('admin.productmedia.index')->with('success','Media deleted');
    }
}

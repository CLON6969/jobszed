<?php

namespace App\Http\Controllers\User\Seller;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        return response()->json(Seller::with('user')->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'business_name' => 'required|string|max:255',
            'business_logo' => 'nullable|string',
            'verification_status' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'bio' => 'nullable|string',
            'website' => 'nullable|string',
        ]);

        $seller = Seller::create($data);
        return response()->json($seller, 201);
    }

    public function show(Seller $seller)
    {
        return response()->json($seller->load('products'));
    }

    public function update(Request $request, Seller $seller)
    {
        $seller->update($request->all());
        return response()->json($seller);
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return response()->json(['message' => 'Seller deleted']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // View all users (sellers, customers)
    public function index()
    {
        $users = User::with('role')->paginate(20);
        return response()->json($users);
    }

    // Approve or suspend user
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->account_status = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated']);
    }

    // Delete user account
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}

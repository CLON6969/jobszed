<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModerationController extends Controller
{
    public function flag(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|string',
            'record_id' => 'required|integer',
            'reason' => 'nullable|string'
        ]);

        DB::table('moderation_flags')->insert([
            'table_name' => $validated['table'],
            'record_id' => $validated['record_id'],
            'reason' => $validated['reason'],
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Record flagged for review']);
    }

    public function deleteRecord(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|string',
            'record_id' => 'required|integer'
        ]);

        DB::table($validated['table'])->where('id', $validated['record_id'])->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }
}

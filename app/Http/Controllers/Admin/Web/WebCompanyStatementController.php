<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyStatement;

class WebCompanyStatementController extends Controller
{
    public function index()
    {
        $statements = CompanyStatement::all();
        return view('admin.web.homepage.statements.index', compact('statements'));
    }

    public function create()
    {
        return view('admin.web.homepage.statements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title1' => 'required|string',
            'title1_main_content' => 'nullable|string',
            'title1_sub_content' => 'nullable|string',
            'background_picture' => 'nullable|image'
        ]);

        $statement = new CompanyStatement();
        $statement->title1 = $request->title1;
        $statement->title1_main_content = $request->title1_main_content;
        $statement->title1_sub_content = $request->title1_sub_content;

        if ($request->hasFile('background_picture')) {
            $filename = $request->file('background_picture')->store('uploads/pics', 'public');
            $statement->background_picture = basename($filename);
        }

        $statement->save();

        return redirect()->route('admin.web.homepage.statements.index')->with('success', 'Statement added.');
    }

    public function edit($id)
    {
        $statement = CompanyStatement::findOrFail($id);
        return view('admin.web.homepage.statements.edit', compact('statement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title1' => 'required|string',
            'title1_main_content' => 'nullable|string',
            'title1_sub_content' => 'nullable|string',
            'background_picture' => 'nullable|image'
        ]);

        $statement = CompanyStatement::findOrFail($id);
        $statement->title1 = $request->title1;
        $statement->title1_main_content = $request->title1_main_content;
        $statement->title1_sub_content = $request->title1_sub_content;

        if ($request->hasFile('background_picture')) {
            $filename = $request->file('background_picture')->store('uploads/pics', 'public');
            $statement->background_picture = basename($filename);
        }

        $statement->save();

        return redirect()->route('admin.web.homepage.statements.index')->with('success', 'Statement updated.');
    }

    public function destroy($id)
    {
        $statement = CompanyStatement::findOrFail($id);
        $statement->delete();

        return redirect()->route('admin.web.homepage.statements.index')->with('success', 'Statement deleted.');
    }
}

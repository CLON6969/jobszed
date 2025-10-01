<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home;
use Illuminate\Support\Facades\Storage;

class WebHomepageContentController extends Controller
{
    public function edit()
    {
        $content = Home::first();
        return view('admin.web.homepage.content.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title1' => 'required|string|max:255',
            'title1_content' => 'nullable|string',
            'title2' => 'required|string|max:255',
            'title2_content' => 'nullable|string',
            'background_picture' => 'nullable|image',
            'picture1' => 'nullable|image',
            'button1_name' => 'nullable|string|max:255',
            'button1_url' => 'nullable|url',
            'background_picture2' => 'nullable|image',
            'title3' => 'nullable|string|max:255',
            'title3_content' => 'nullable|string',
            'button2_name' => 'nullable|string|max:255',
            'button2_url' => 'nullable|url',
        ]);

        $content = Home::first();

        $content->title1 = $request->title1;
        $content->title1_content = $request->title1_content;
        $content->title2 = $request->title2;
        $content->title2_content = $request->title2_content;
        $content->button1_name = $request->button1_name;
        $content->button1_url = $request->button1_url;
        $content->title3 = $request->title3;
        $content->title3_content = $request->title3_content;
        $content->button2_name = $request->button2_name;
        $content->button2_url = $request->button2_url;

        if ($request->hasFile('background_picture')) {
            $filename = $request->file('background_picture')->store('uploads/pics', 'public');
            $content->background_picture = basename($filename);
        }

        if ($request->hasFile('picture1')) {
            $filename = $request->file('picture1')->store('uploads/pics', 'public');
            $content->picture1 = basename($filename);
        }

        if ($request->hasFile('background_picture2')) {
            $filename = $request->file('background_picture2')->store('uploads/pics', 'public');
            $content->background_picture2 = basename($filename);
        }

        $content->save();

        return redirect()->route('admin.web.homepage.content.edit')->with('success', 'Homepage content updated successfully.');
    }
}

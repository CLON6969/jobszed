<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;

class WebAboutController extends Controller
{
    /**
     * Show the edit form for the About section.
     */
    public function edit()
    {
        $about = About::first(); // Assumes only one about row exists
        return view('admin.web.about.edit', compact('about'));
    }

    /**
     * Handle the update of the About section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title1' => 'required|string|max:255',
            'title1_content' => 'nullable|string',
            'title2' => 'required|string|max:255',
            'title2_content' => 'nullable|string',
            'title3' => 'nullable|string|max:255',
            'title3_content' => 'nullable|string',
            'title4' => 'nullable|string|max:255',
            'title4_content' => 'nullable|string',
            'title5' => 'nullable|string|max:255',
            'title6' => 'nullable|string|max:255',
            'button1_name' => 'nullable|string|max:255',
            'button1_url' => 'nullable|url',
            'button2_name' => 'nullable|string|max:255',
            'button2_url' => 'nullable|url',
            'background_picture' => 'nullable|image',
            'background_picture2' => 'nullable|image',
        ]);

        $about = About::first() ?? new About();

        $about->fill($request->only([
            'title1',
            'title1_content',
            'title2',
            'title2_content',
            'title3',
            'title3_content',
            'title4',
            'title4_content',
            'title5',
            'title6',
            'button1_name',
            'button1_url',
            'button2_name',
            'button2_url',
        ]));

        if ($request->hasFile('background_picture')) {
            $file = $request->file('background_picture')->store('uploads/pics', 'public');
            $about->background_picture = basename($file);
        }

        if ($request->hasFile('background_picture2')) {
            $file2 = $request->file('background_picture2')->store('uploads/pics', 'public');
            $about->background_picture2 = basename($file2);
        }

        $about->save();

        return redirect()->route('admin.web.about.edit')->with('success', 'About content updated successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportSubmission;
use App\Mail\SupportFormSubmitted;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function show()
    {
        return view('/support');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'required',
            'job_title' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'nullable',
            'country' => 'required',
            'consent' => 'nullable',
        ]);

        $submission = SupportSubmission::create($validated);

        // Use the 'support' mailer
        Mail::mailer('support')
            ->to('technical@kumoyotech.com')
            ->send(new SupportFormSubmitted($submission));

        return redirect()->route('support.form')->with('success', 'Message sent successfully!');
    }
}

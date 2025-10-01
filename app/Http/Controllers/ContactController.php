<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('/contact');
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

        $submission = ContactSubmission::create($validated);

        // Use the 'sales' mailer
        Mail::mailer('sales')
            ->to('sales@kumoyotech.com')
            ->send(new ContactFormSubmitted($submission));

        return redirect()->route('contact.form')->with('success', 'Message sent successfully!');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\ShortlistedDetail;
use App\Models\RejectedDetail;
use App\Models\InterviewDetail;
use App\Models\AcceptedDetail;
use App\Models\EmailTemplate;

class ApplicationManagementController extends Controller
{
    /**
     * Show the application management dashboard
     */
    public function index()
    {
        $jobPosts = JobPost::with([
            'shortlistedDetail',
            'rejectedDetail',
            'interviewDetail',
            'acceptedDetail',
            'applications.user'
        ])->get();

        $emailTemplates = EmailTemplate::all();

        return view('admin.web.Email_application_management.index', compact('jobPosts', 'emailTemplates'));
    }

    /**
     * Store or update details (shortlisted, rejected, interview, accepted)
     */
    public function storeDetail(Request $request, $jobPostId, $type)
    {
        $model = $this->getModel($type);
        $rules = $this->getValidationRules($type);

        $request->validate($rules);

        $data = $request->all();
        $data['job_post_id'] = $jobPostId;

        $model::updateOrCreate(
            ['job_post_id' => $jobPostId],
            $data
        );

        return redirect()->back()->with('status', $type . '-saved');
    }

    /**
     * Delete a detail
     */
    public function deleteDetail($jobPostId, $type, $id)
    {
        $model = $this->getModel($type);
        $item = $model::where('job_post_id', $jobPostId)->findOrFail($id);
        $item->delete();

        return redirect()->back()->with('status', $type . '-deleted');
    }

    /**
     * Fetch an email template (used via AJAX)
     */
    public function fetchEmailTemplate($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $html = view('admin.web.Email_application_management.partials.email_template', compact('template'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Update an email template
     */
    public function updateEmailTemplate(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        $template->update($request->only('subject', 'body'));

        return redirect()->back()->with('status', 'email-template-updated');
    }

    /**
     * Get the model class for a given type
     */
    protected function getModel($type)
    {
        return match ($type) {
            'shortlisted' => ShortlistedDetail::class,
            'rejected' => RejectedDetail::class,
            'interview' => InterviewDetail::class,
            'accepted' => AcceptedDetail::class,
            default => abort(404, 'Invalid type'),
        };
    }

    /**
     * Get validation rules for a given type
     */
    protected function getValidationRules($type)
    {
        return match ($type) {
            'shortlisted' => [
                'notes' => 'nullable|string',
            ],
            'rejected' => [
                'reason' => 'required|string|max:255',
            ],
            'interview' => [
                'type' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required',
                'venue' => 'nullable|string|max:255',
                'requirements' => 'nullable|string',
            ],
            'accepted' => [
                'start_date' => 'required|date',
                'position' => 'required|string|max:255',
                'salary' => 'required|string|max:255',
                'other_terms' => 'nullable|string',
            ],
            default => abort(404, 'Invalid type'),
        };
    }
}

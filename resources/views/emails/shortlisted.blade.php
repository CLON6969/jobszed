@component('mail::message')
# Congratulations {{ $application->user->name }}! 🎉

{!! $emailContent !!}

**Shortlist Details:**  
- **Notes:** {{ $shortlistedDetail->notes ?? 'You have been shortlisted. Further instructions will follow.' }}

We will reach out to you soon with the next steps.

Thanks,  
{{ config('app.name') }}
@endcomponent

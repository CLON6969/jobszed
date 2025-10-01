@component('mail::message')
# Dear {{ $application->user->name }},

{!! $emailContent !!}

**Rejection Details:**  
- **Reason:** {{ $rejectedDetail->reason ?? 'Not specified' }}

We truly appreciate your interest in **{{ $application->jobPost->title }}**.  
Please don’t hesitate to apply for other opportunities with us.

Thanks,  
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Interview Invitation for {{ $application->jobPost->title }}

Dear {{ $application->user->name }},

{!! $emailContent !!}

**Interview Details:**  
- **Type:** {{ $interviewDetail->type ?? 'TBD' }}  
- **Date:** {{ $interviewDetail->date ?? 'TBD' }}  
- **Time:** {{ $interviewDetail->time ?? 'TBD' }}  
- **Venue / Link:** {{ $interviewDetail->venue ?? 'TBD' }}  
- **Requirements:** {{ $interviewDetail->requirements ?? 'TBD' }}

Thanks,  
{{ config('app.name') }}
@endcomponent

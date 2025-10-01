@component('mail::message')
# Congratulations {{ $application->user->name }}! 🎊

{!! $emailContent !!}

**Offer Details:**  
- **Position:** {{ $acceptedDetail->position ?? $application->jobPost->title }}  
- **Start Date:** {{ $acceptedDetail->start_date ?? 'TBD' }}  
- **Salary:** {{ $acceptedDetail->salary ?? 'Negotiable' }}  
- **Other Terms:** {{ $acceptedDetail->other_terms ?? 'Standard terms apply' }}

Please reply to confirm your acceptance of this offer.

Thanks,  
{{ config('app.name') }}
@endcomponent


@php
    // Get active partners ordered by sort_order
    $partners = App\Models\Partners::where('is_active', true)
                                  ->orderBy('sort_order')
                                  ->get();
@endphp

<div class="icons-container">

 

 
     <div class="partners-container">
        <div class="icons">
            @foreach ($partners as $partner)
            <div class="icons">
                <a href="{{ $partner->name_url }}" class="partner-link">
                    <i class="{{$partner->icon }}"></i> 
                    <span class="partner-name">{{ $partner->name }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    

 
 
     
 </div>
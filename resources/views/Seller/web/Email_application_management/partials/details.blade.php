@php 
    $sections = [
        'interviewDetail' => 'Interview', 
        'shortlistedDetail' => 'Shortlisted', 
        'rejectedDetail' => 'Rejected', 
        'acceptedDetail' => 'Accepted'
    ]; 
@endphp

<h5 class="fw-bold mb-3">{{ $job->title ?? 'Job' }}</h5>

@foreach($sections as $key => $label)
    @php $data = $job->$key; @endphp
    <div class="mb-4">
        <h6 class="fw-bold">{{ $label }} Details</h6>
        <form method="POST" action="{{ route('web.Email_application_management.storeDetail', [$job->id, strtolower(str_replace('Detail','',$key))]) }}">
            @csrf
            <div class="mb-2">
                @if($key === 'rejectedDetail')
                    <input type="text" name="reason" class="form-control" placeholder="Enter reason" value="{{ $data->reason ?? '' }}">
                @elseif($key === 'shortlistedDetail')
                    <textarea name="notes" class="form-control" placeholder="Enter notes">{{ $data->notes ?? '' }}</textarea>
                @elseif($key === 'interviewDetail')
                    <input type="text" name="type" class="form-control mb-1" placeholder="Type" value="{{ $data->type ?? '' }}">
                    <input type="date" name="date" class="form-control mb-1" value="{{ $data->date ?? '' }}">
                    <input type="time" name="time" class="form-control mb-1" value="{{ $data->time ?? '' }}">
                    <input type="text" name="venue" class="form-control mb-1" placeholder="Venue" value="{{ $data->venue ?? '' }}">
                    <textarea name="requirements" class="form-control" placeholder="Requirements">{{ $data->requirements ?? '' }}</textarea>
                @elseif($key === 'acceptedDetail')
                    <input type="date" name="start_date" class="form-control mb-1" value="{{ $data->start_date ?? '' }}">
                    <input type="text" name="position" class="form-control mb-1" placeholder="Position" value="{{ $data->position ?? '' }}">
                    <input type="text" name="salary" class="form-control mb-1" placeholder="Salary" value="{{ $data->salary ?? '' }}">
                    <input type="text" name="other_terms" class="form-control mb-1" placeholder="Other Terms" value="{{ $data->other_terms ?? '' }}">
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-sm">Save {{ $label }}</button>
        </form>
    </div>
@endforeach

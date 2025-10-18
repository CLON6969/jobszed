<div class="mt-4">
    <h5>Qualifications</h5>
    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addQualification()">Add Qualification</button>
    
    <div id="qualifications-container">
        @foreach($qualifications as $index => $qualification)
            @include('user.employer.web.job.partials.qualification-item', ['index' => $index, 'qualification' => $qualification])
        @endforeach
    </div>

    
</div>

<template id="qualification-template">
    @include('user.employer.web.job.partials.qualification-item', ['index' => '__INDEX__', 'qualification' => null])
</template>

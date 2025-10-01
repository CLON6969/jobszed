<div class="mt-4">
    <h5>Experiences</h5>
    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addExperience()">Add Experience</button>
    
    <div id="experiences-container">
        @foreach($experiences as $index => $experience)
            @include('admin.web.job.partials.experience-item', ['index' => $index, 'experience' => $experience])
        @endforeach
    </div>

    
</div>

<template id="experience-template">
    @include('admin.web.job.partials.experience-item', ['index' => '__INDEX__', 'experience' => null])
</template>

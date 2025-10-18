<div class="mt-4">
    <h5>Skills</h5>
     <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addSkill()">Add Skill</button>
    <div id="skills-container">
        @foreach($skills as $index => $skill)
            @include('user.employer.web.job.partials.skill-item', ['index' => $index, 'skill' => $skill])
        @endforeach
    </div>

   
</div>

<template id="skill-template">
    @include('user.employer.web.job.partials.skill-item', ['index' => '__INDEX__', 'skill' => null])
</template>

<div class="mt-4">
    <h5>Application Questions</h5>
        <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addQuestion()">Add Question</button>
    <div id="questions-container">
        @foreach($questions as $index => $question)
            @include('user.employer.web.job.partials.question-item', ['index' => $index, 'question' => $question])
        @endforeach
    </div>


</div>

<template id="question-template">
    @include('user.employer.web.job.partials.question-item', ['index' => '__INDEX__', 'question' => null])
</template>

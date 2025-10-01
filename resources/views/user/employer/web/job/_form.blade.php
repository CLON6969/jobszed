@php
    $isEdit = isset($job);

    // Employment Types (enum values => human labels)
    $employmentTypes = [
        'full_time'  => 'Full Time',
        'part_time'  => 'Part Time',
        'contract'   => 'Contract',
        'internship' => 'Internship',
    ];

    // Work Setup
    $workSetups = [
        'on_site' => 'On Site',
        'remote'  => 'Remote',
        'hybrid'  => 'Hybrid',
    ];

    // Status
    $statuses = [
        'open'   => 'Open',
        'closed' => 'Closed',
    ];

    // Departments
    $departments = [
        'Finance', 'HR', 'IT', 'Sales', 'Marketing',
        'Operations', 'Customer Service', 'Engineering',
        'Administration', 'Logistics', 'Legal', 'Production'
    ];

    // Levels
    $levels = [
        'Intern', 'Entry', 'Mid-Level', 'Senior',
        'Manager', 'Director', 'Executive'
    ];

    // countries
    $countries = [
    "Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia",
    "Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium",
    "Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria",
    "Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African Republic","Chad",
    "Chile","China","Colombia","Comoros","Congo, Democratic Republic of the","Congo, Republic of the",
    "Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica",
    "Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini",
    "Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada",
    "Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia",
    "Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati",
    "Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania",
    "Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania",
    "Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique",
    "Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","North Korea",
    "North Macedonia","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay",
    "Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis",
    "Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia",
    "Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia",
    "South Africa","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria",
    "Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey",
    "Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay",
    "Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
];

   
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- Job Title --}}
    <div>
        <label class="form-label">Job Title</label>
        <input type="text" name="title" class="form-control" 
            value="{{ old('title', $job->title ?? '') }}" required>
    </div>

    {{-- Slug --}}
    <div>
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" 
            value="{{ old('slug', $job->slug ?? '') }}" required>
    </div>

    {{-- Employment Type --}}
    <div>
        <label class="form-label">Employment Type</label>
        <select name="employment_type" class="form-control" required>
            @foreach($employmentTypes as $type)
                <option value="{{ $type }}" {{ old('employment_type', $job->employment_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    {{-- Work Setup --}}
    <div>
        <label class="form-label">Work Setup</label>
        <select name="work_setup" class="form-control" required>
            @foreach($workSetups as $setup)
                <option value="{{ $setup }}" {{ old('work_setup', $job->work_setup ?? '') == $setup ? 'selected' : '' }}>{{ $setup }}</option>
            @endforeach
        </select>
    </div>

    {{-- Location --}}
    <div>
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" 
            value="{{ old('location', $job->location ?? '') }}" required>
    </div>

    {{-- Country --}}
    <div>
        <label class="form-label">Country</label>
        <select name="country" class="form-control" required>
            @foreach($countries as $country)
                <option value="{{ $country }}" {{ old('country', $job->country ?? '') == $country ? 'selected' : '' }}>{{ $country }}</option>
            @endforeach
        </select>
    </div>

    {{-- Department --}}
    <div>
        <label class="form-label">Department</label>
        <select name="department" class="form-control" required>
            @foreach($departments as $dept)
                <option value="{{ $dept }}" {{ old('department', $job->department ?? '') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
            @endforeach
        </select>
    </div>

    {{-- Level --}}
    <div>
        <label class="form-label">Level</label>
        <select name="level" class="form-control">
            @foreach($levels as $level)
                <option value="{{ $level }}" {{ old('level', $job->level ?? '') == $level ? 'selected' : '' }}>{{ $level }}</option>
            @endforeach
        </select>
    </div>

    {{-- Salary Range --}}
    <div>
        <label class="form-label">Salary Range</label>
        <input type="text" name="salary_range" class="form-control" 
            value="{{ old('salary_range', $job->salary_range ?? '') }}">
    </div>

    {{-- Application Deadline --}}
    <div>
        <label class="form-label">Application Deadline</label>
        <input type="date" name="application_deadline" class="form-control" 
            value="{{ old('application_deadline', $isEdit && $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}" required>
    </div>

    {{-- Posted By --}}
    <div>
        <label class="form-label">Posted By (User ID)</label>
        <input type="number" name="posted_by" class="form-control cursor-not-allowed" 
            value="{{ old('posted_by', $job->posted_by ?? auth()->id()) }}" readonly>
    </div>

    {{-- Description --}}
    <div class="col-span-1 md:col-span-2">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control" required>{{ old('description', $job->description ?? '') }}</textarea>
    </div>

</div>







{{-- Dynamic collections sections --}}
@include('admin.web.job.partials.skills', ['skills' => old('skills', $isEdit ? $job->skills->toArray() : [])])
@include('admin.web.job.partials.experiences', ['experiences' => old('experiences', $isEdit ? $job->experiences->toArray() : [])])
@include('admin.web.job.partials.qualifications', ['qualifications' => old('qualifications', $isEdit ? $job->qualifications->toArray() : [])])
@include('admin.web.job.partials.questions', ['questions' => old('questions', $isEdit ? $job->questions->toArray() : [])])



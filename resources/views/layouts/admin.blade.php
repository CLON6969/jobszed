@php 
    $logo = App\Models\Logo::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step X</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* Global styles, buttons, table, form, etc. */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; color: #1f2937; margin:0; padding:0; }
        .container { max-width: 1024px; margin: 2rem auto; padding: 1.5rem; background:white; border-radius:0.75rem; box-shadow:0 5px 15px rgba(0,0,0,0.05);}
        h4 { font-size:1.5rem; font-weight:600; margin-bottom:1.25rem; color:#111827;}
        .btn { padding:0.5rem 1rem; font-size:0.875rem; border-radius:0.375rem; transition: background-color 0.3s; border:none; cursor:pointer; }
        .btn-primary{background:#3b82f6;color:white;} .btn-primary:hover{background:#2563eb;}
        .btn-success{background:#10b981;color:white;} .btn-success:hover{background:#059669;}
        .btn-info{background:#0ea5e9;color:white;} .btn-info:hover{background:#0284c7;}
        .btn-danger{background:#ef4444;color:white;} .btn-danger:hover{background:#dc2626;}
        .btn-secondary{background:#6b7280;color:white;} .btn-secondary:hover{background:#4b5563;}
        .btn-sm{font-size:0.75rem;padding:0.4rem 0.75rem;}
        label{font-weight:500;margin-bottom:0.5rem;display:block;color:#374151;}
        input, select, textarea { width:100%; padding:0.5rem; margin-top:0.25rem; border:1px solid #d1d5db; border-radius:0.5rem; background:#f9fafb; transition:border-color 0.2s;}
        input:focus, select:focus, textarea:focus { outline:none; border-color:#3b82f6; background:white;}
        .row { display:flex; flex-wrap:wrap; gap:1rem; }
        .col-md-4, .col-md-6 { flex:1; min-width:280px;}
        .mt-2,.mt-3,.mt-4{margin-top:0.5rem;} .mb-2{margin-bottom:0.5rem;}
        .input-group { display:flex; gap:0.75rem; margin-bottom:1rem; align-items:center;}
        .input-group .remove-btn { background:#ef4444;color:white;border:none;border-radius:0.375rem;cursor:pointer;padding:0.35rem 0.75rem; transition:0.2s; }
        .input-group .remove-btn:hover{background:#dc2626;}
        .action_buttons{display:flex;}
        .buttons{display:flex; justify-content:space-between;}
        #preloader {position:fixed; top:0; left:0;width:100%;height:100%;background:#0a1a3f; display:flex; align-items:center; justify-content:center; z-index:9999;}
        .preloader-logo {width:80px;height:80px;animation:blinkZoom 1s infinite alternate;}
        @keyframes blinkZoom {0%{opacity:0.3;transform:scale(0.8);}50%{opacity:1;transform:scale(1.2);}100%{opacity:0.3;transform:scale(0.8);}}
    </style>
</head>
<body>
    @yield('content')

    <script>
        // Dynamic Indexes
        let skillIndex = {{ count(old('skills', $job->skills ?? [])) }};
        let experienceIndex = {{ count(old('experiences', $job->experiences ?? [])) }};
        let qualificationIndex = {{ count(old('qualifications', $job->qualifications ?? [])) }};
        let questionIndex = {{ count(old('questions', $job->questions ?? [])) }};

        function addSkill() {
            const tpl = document.getElementById('skill-template').innerHTML.replace(/__INDEX__/g, skillIndex);
            document.getElementById('skills-container').insertAdjacentHTML('beforeend', tpl);
            skillIndex++;
        }
        function addExperience() {
            const tpl = document.getElementById('experience-template').innerHTML.replace(/__INDEX__/g, experienceIndex);
            document.getElementById('experiences-container').insertAdjacentHTML('beforeend', tpl);
            experienceIndex++;
        }
        function addQualification() {
            const tpl = document.getElementById('qualification-template').innerHTML.replace(/__INDEX__/g, qualificationIndex);
            document.getElementById('qualifications-container').insertAdjacentHTML('beforeend', tpl);
            qualificationIndex++;
        }
        function addQuestion() {
            const tpl = document.getElementById('question-template').innerHTML.replace(/__INDEX__/g, questionIndex);
            document.getElementById('questions-container').insertAdjacentHTML('beforeend', tpl);
            questionIndex++;
        }

        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-skill')) e.target.closest('.skill-item').remove();
            if(e.target.classList.contains('remove-experience')) e.target.closest('.experience-item').remove();
            if(e.target.classList.contains('remove-qualification')) e.target.closest('.qualification-item').remove();
            if(e.target.classList.contains('remove-question')) e.target.closest('.question-item').remove();
        });

        // Preloader
        window.addEventListener('load', function(){
            const preloader = document.getElementById('preloader');
            if(preloader) {
                setTimeout(()=>{ preloader.style.opacity='0'; setTimeout(()=>preloader.style.display='none',300); }, 2000);
            }
        });
    </script>
</body>
</html>

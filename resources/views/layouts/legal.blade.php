@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-white text-black">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <title>Mongutech | privacy</title>
       <!-- icon -->
   <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">

    <link href="/public/vendor/fontawesome/css/all.min.css" rel="stylesheet">
        <!-- fontawsome back up-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">


        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    
   
    <link href="{{ asset('/public/resources/css/partners.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/public/resources/css/legal.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Preloader full screen */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #0a1a3f; /* dark blue */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Logo animation */
.preloader-logo {
    width: 80px; /* Adjust size */
    height: 80px;
    animation: blinkZoom 1s infinite alternate;
}

/* Keyframes for blinking & zooming */
@keyframes blinkZoom {
    0% {
        opacity: 0.3;
        transform: scale(0.8);
    }
    50% {
        opacity: 1;
        transform: scale(1.2);
    }
    100% {
        opacity: 0.3;
        transform: scale(0.8);
    }
}

     </style>

</head>
<body class="min-h-screen flex flex-col">

    <!-- Nav1 Content -->
    <x-navbar />

    <div class="flex flex-1">
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>


    
<!-- footer Content -->
    <x-footer />
           <script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => preloader.style.display = 'none', 300);
        }
    });
</script>
</body>
</html>
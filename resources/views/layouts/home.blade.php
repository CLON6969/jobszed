@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800, // animation duration in ms
    once: true,    // animate only once
  });
</script>

 <!-- tailwindcss -->

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>

  <title> Mongutech | Products </title>
  
     <!-- icon -->
   <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">

        <!-- fontawsome back up-->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">


    
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

 
            @yield('content')


    
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
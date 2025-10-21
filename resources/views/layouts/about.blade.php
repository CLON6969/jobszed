

<!DOCTYPE html>
<html lang="en" class="bg-white text-black">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Mongutech | About Us</title>
  
     <!-- icon -->
   <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="/vendor/fontawesome/css/all.min.css" rel="stylesheet">
        <!-- fontawsome back up-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

       <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

        <!-- AOS Library for Scroll Animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="{{ asset('/public/css/app.css') }}" rel="stylesheet">





   
    
     <link href="{{ asset('/public/resources/css/about.css') }}" rel="stylesheet">

</head>
<body >
<!-- Nav1 Content -->
    <x-navbar />

 
            @yield('content')


    
<!-- footer Content -->
    <x-footer />
</body>
</html>
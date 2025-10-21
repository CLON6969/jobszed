@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
@endphp
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Dashboard'))</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    
   <!-- icon -->
   <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">


   <!-- fontawsome -->
   <link href="/fontawesome/css/all.min.css" rel="stylesheet">
    <!-- fontawsome back up-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

<script src="//unpkg.com/alpinejs" defer></script>



      <!-- Bootstrap CSS -->
       <link href="{{ asset('/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">



        <style>
        /* Reset and font */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9fafb;
    color: #1f2937;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1024px;
    margin: 2rem auto;
    padding: 1.5rem;
    background-color: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

/* Header section */
h4 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.25rem;
    color: #111827;
}

/* Buttons */
.btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-success {
    background-color: #10b981;
    color: white;
}

.btn-success:hover {
    background-color: #059669;
}

.btn-info {
    background-color: #0ea5e9;
    color: white;
}

.btn-info:hover {
    background-color: #0284c7;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.btn-sm {
    font-size: 0.75rem;
    padding: 0.4rem 0.75rem;
}

/* Form */
label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #374151;
}

input[type="text"],
input[type="date"],
input[type="number"],
select,
textarea {
    width: 100%;
    padding: 0.5rem;
    margin-top: 0.25rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background-color: #f9fafb;
    transition: border-color 0.2s;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #3b82f6;
    background-color: #ffffff;
}

/* Layout helpers */
.row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.col-md-4,
.col-md-6 {
    flex: 1;
    min-width: 280px;
}

/* Table */
table.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    background-color: #ffffff;
    border-radius: 0.5rem;
    overflow: hidden;
}

.table thead {
    background-color: #f3f4f6;
    font-weight: 600;
}

.table th,
.table td {
    padding: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}

.table td .btn {
    margin-right: 0.25rem;
}

.table td:last-child {
    white-space: nowrap;
}

/* Alerts */
.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 0.3rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 9999px;
    text-transform: capitalize;
}

.bg-success {
    background-color: #dcfce7;
    color: #166534;
}

.bg-secondary {
    background-color: #e5e7eb;
    color: #374151;
}

/* Repeatable input group */
.input-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.input-group input {
    flex: 1;
}

.input-group .remove-btn {
    padding: 0.4rem 0.75rem;
}

.mt-2, .mt-3, .mt-4 {
    margin-top: 0.5rem;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

/* Add to your existing CSS */

/* Container for action buttons inside table cells */
.table td .action-buttons {
    display: flex;
    gap: 0.5rem;      /* spacing between buttons */
    align-items: center;
    white-space: nowrap; /* prevent wrapping */
}

/* Ensure buttons inside table cells have consistent small size and spacing */
.table td .action-buttons .btn {
    margin: 0; /* override margin-right */
    padding: 0.35rem 0.75rem;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem; /* space between icon and text */
}

/* Optional: icon sizing inside buttons */
.table td .action-buttons .btn i {
    font-size: 1rem;
}

/* Hover effects are inherited from your existing .btn styles */

/* If you want the form group input and remove button spacing refined */
.input-group {
    gap: 0.75rem; /* slightly more spacing */
    margin-bottom: 1rem;
}
.input-group .remove-btn {
    background-color: #ef4444;
    color: white;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
    padding: 0.35rem 0.75rem;
}
.input-group .remove-btn:hover {
    background-color: #dc2626;
}
.action_buttons{
    display: flex;
}

.buttons{
    display: flex;
    justify-content: space-between;
}


.buttons h4{

   padding: 10px;
}

    </style>

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
<body>

    <div id="preloader">
    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture2) }}" alt="logo" class="preloader-logo">
</div>

    <main class="p-6">
        @yield('content')
    </main>

<script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            // Keep preloader visible for 5 seconds
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => preloader.style.display = 'none', 300); // fade out smoothly
            }, 2000); // 5000ms = 5 seconds
        }
    });
</script>

</body>
</html>

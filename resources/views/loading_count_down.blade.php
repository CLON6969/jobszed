@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Launch</title>
       <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

    
   <link href="{{ asset('/public/resources/css/loading.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .logo {
            width: 200px;
            animation: fadeInOut 2s infinite ease-in-out;
        }

        h1 {
            margin-top: 20px;
            font-size: 2rem;
            color: #00ffcc;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 1; }
        }

        .notify-btn {
            margin-top: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #00ffcc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .notify-btn:hover {
            background-color: #00cca8;
        }
    </style>
</head>
<body>
    
    
    <div class="container">
        <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture2) }}" alt="logo" class="logo">
        
        <h1>Page being worked on...</h1>
        <h1>Next Launch</h1>
        <button class="notify-btn" id="notify-btn">
           <a href="/"> HOME</a>
        </button>
    </div>

  <!--  <script>
        document.getElementById('notify-btn').addEventListener('click', () => {
            alert("You'll be notified when we launch!");
        });
    </script>
-->
</body>
</html>

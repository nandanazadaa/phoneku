<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PhoneKu - @yield('title', 'Marketplace Handphone & Aksesoris')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .slide-container {
            overflow: hidden;
            width: 100%;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .slides {
            position: relative;
            width: 100%;
        }
        
        .slide {
            display: none;
            width: 100%;
        }
        
        .slide.active {
            display: block;
            animation: slideIn 0.8s ease-in-out;
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0.7; 
                transform: translateX(30px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .slider-dot {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .slider-dot:hover {
            transform: scale(1.1);
        }
    </style>
    @yield('styles')
</head>
<body class="font-sans">
    <!-- Navbar Include - pastikan path ini benar -->
    @include('partials.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer Include - pastikan path ini benar -->
    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
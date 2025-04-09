<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - @yield('title', 'Marketplace Handphone & Aksesoris')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans">
    <div class="flex min-h-screen">
        <!-- Left Side with Logo and Image -->
        <div class="hidden md:flex md:w-1/2 bg-white flex-col p-8 relative overflow-hidden">
            <div class="mb-4">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo2.png') }}" alt="PhoneKu Logo" class="w-60">
                </a>
            </div>
            
            <div class="flex-1 flex items-center justify-center">
                <img src="{{ asset('img/model.png') }}" alt="Person with phone" 
                     class="w-full h-auto object-contain absolute inset-25 mx-auto my-8"
                     style="max-height: 90vh">
            </div>
        </div>

        <!-- Right Side with Login Form -->
        <div class="w-full md:w-[45%] ml-auto bg-gradient-to-b from-blue-500 to-cyan-400 flex items-center justify-center p-8">
            <div class="w-full max-w-md transform transition-all">
                <div class="text-center text-white mb-8">
                    <h2 class="text-3xl font-bold mb-2">Masuk</h2>
                    <p class="text-sm opacity-90">Silahkan masuk jika sudah memiliki akun!</p>
                </div>

                <!-- Tampilkan pesan error jika ada -->
                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="space-y-4" method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <!-- Tambahkan hidden field untuk redirect -->
                    @if(request()->has('redirect'))
                        <input type="hidden" name="redirect" value="{{ request()->redirect }}">
                    @endif
                    
                    <div>
                        <label for="email" class="block text-white mb-2 text-sm">Email</label>
                        <input type="email" id="email" name="email" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan email anda" value="{{ old('email') }}" required>
                    </div>

                    <div>
                        <label for="password" class="block text-white mb-2 text-sm">Password</label>
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan password anda" required>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600">
                            <label for="remember" class="ml-2 text-white text-sm">Ingat saya</label>
                        </div>
                        <div>
                            <a href="#" class="text-white hover:underline text-xs">Lupa Password?</a>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition-colors duration-300">
                        Masuk
                    </button>

                    <div class="border-t border-white/20 pt-4 mt-6">
                        <p class="text-center text-white text-sm">
                            Belum memiliki akun? 
                            <a href="{{ route('registrasi') }}" class="text-blue-200 hover:underline">Daftar sekarang!</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">
    <div class="flex min-h-screen">
        <!-- Left Side with Logo and Image -->
        <div class="hidden md:flex md:w-1/2 bg-white flex-col p-10 pt-6 pb-0 relative">
            <div class="mb-10">
                <div class="flex items-center">
                    <img src="img/logo.png" alt="PhoneKu Logo" class="w-100" />
                </div>
            </div>
            
            <div class="flex-1 flex items-end justify-center">
                <div class="w-full">
                    <img src="img/model.png" alt="Person with phone" class="w-full h-auto object-contain max-h-[90vh]" />
                </div>
            </div>
        </div>
        
        <!-- Right Side with Login Form -->
        <div class="w-full md:w-1/2 bg-gradient-to-b from-blue-500 to-cyan-400 p-8 flex items-center justify-center rounded-l-3xl">
            <div class="w-full max-w-md">
                <div class="text-center text-white mb-8">
                    <h2 class="text-4xl font-bold mb-2">Masuk</h2>
                    <p class="text-sm">Silahkan masuk jika sudah memiliki akun!</p>
                </div>
                
                <form>
                    <div class="mb-6">
                        <label for="email" class="block text-white mb-2">Email</label>
                        <input type="email" id="email" class="w-full px-4 py-3 rounded-lg" placeholder="Masukkan email anda">
                    </div>
                    
                    <div class="mb-2">
                        <label for="password" class="block text-white mb-2">Password</label>
                        <input type="password" id="password" class="w-full px-4 py-3 rounded-lg" placeholder="Masukkan password anda">
                    </div>
                    
                    <div class="text-right mb-8">
                        <a href="#" class="text-white hover:underline text-sm">Lupa Password?</a>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors duration-300">Masuk</button>
                    
                    <div class="border-t border-white/30 my-8 pt-4">
                        <div class="text-center text-white mb-6">
                            <p>Belum memiliki akun? <a href="{{ route('registrasi') }}" class="text-blue-200 hover:underline">Daftar sekarang!</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
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
        <div class="hidden md:flex md:w-1/2 bg-white flex-col p-8 relative overflow-hidden">
            <div class="mb-8">
                <img src="img/logo.png" alt="PhoneKu Logo" class="w-40">
            </div>
            
            <div class="flex-1 flex items-center justify-center">
                <img src="img/model.png" alt="Person with phone" 
                     class="w-full h-auto object-contain absolute inset-25 mx-auto my-8"
                     style="max-height: 80vh">
            </div>
        </div>

        <!-- Right Side with Login Form -->
        <div class="w-full md:w-[45%] ml-auto bg-gradient-to-b from-blue-500 to-cyan-400 flex items-center justify-center p-8">
            <div class="w-full max-w-md transform transition-all">
                <div class="text-center text-white mb-8">
                    <h2 class="text-3xl font-bold mb-2">Masuk</h2>
                    <p class="text-sm opacity-90">Silahkan masuk jika sudah memiliki akun!</p>
                </div>

                <form class="space-y-4">
                    <div>
                        <label for="email" class="block text-white mb-2 text-sm">Email</label>
                        <input type="email" id="email" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan email anda">
                    </div>

                    <div>
                        <label for="password" class="block text-white mb-2 text-sm">Password</label>
                        <input type="password" id="password" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan password anda">
                    </div>

                    <div class="text-right">
                        <a href="#" class="text-white hover:underline text-xs">Lupa Password?</a>
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneKu - Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">
    <div class="flex min-h-screen">
        <!-- Left Side with Logo and Image -->
        <div class="hidden md:flex md:w-1/2 bg-white flex-col p-8 relative overflow-hidden">
            <div class="mb-4">
                <img src="img/logo2.png" alt="PhoneKu Logo" class="w-60">
            </div>
            
            <div class="flex-1 flex items-center justify-center">
                <img src="img/model.png" alt="Person with phone" 
                     class="w-full h-auto object-contain absolute inset-25 mx-auto my-8"
                     style="max-height: 90vh">
            </div>
        </div>

        <!-- Right Side with Registration Form -->
        <div class="w-full md:w-[45%] ml-auto bg-gradient-to-b from-blue-500 to-cyan-400 flex items-center justify-center p-8">
            <div class="w-full max-w-md transform transition-all">
                <div class="text-center text-white mb-8">
                    <h2 class="text-3xl font-bold mb-2">Daftar</h2>
                    <p class="text-sm opacity-90">Silahkan daftar terlebih dahulu jika belum memiliki akun!</p>
                </div>

                <form class="space-y-5">
                    <div>
                        <label for="email" class="block text-white mb-2 text-sm">Email</label>
                        <div class="relative">
                            <input type="tel" id="email" 
                                   class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 pr-28"
                                   placeholder="Masukkan email anda">
                        </div>
                    </div>

                    <div>
                        <label for="password1" class="block text-white mb-2 text-sm">Password</label>
                        <input type="text" id="password1" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan password">
                    </div>
                    <div>
                        <label for="password2" class="block text-white mb-2 text-sm">Password</label>
                        <input type="text" id="password2" 
                               class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Masukkan ulang password">
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition-colors duration-300">
                        Daftar
                    </button>

                    <div class="border-t border-white/20 pt-4 mt-6">
                        <p class="text-center text-white text-sm">
                            Sudah memiliki akun? 
                            <a href="{{ route('login') }}" class="text-blue-200 hover:underline">Kembali login!</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
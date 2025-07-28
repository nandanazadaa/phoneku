<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/LogoIcon.png') }}" type="image/x-icon"/>
    <title>PhoneKu - Lupa Password</title>
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
                    <h2 class="text-3xl font-bold mb-2">Lupa Password</h2>
                    <p class="text-sm opacity-90">Silahkan masukkan terlebih dahulu email anda!</p>
                </div>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form Kirim OTP -->
                    <form method="POST" action="/send-otp" class="space-y-5">
                        @csrf
                        <div>
                            <label for="phone" class="block text-white mb-2 text-sm">Alamat Email</label>
                            <div class="relative">
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 pr-28"
                                    placeholder="Masukkan akun email">
                                <button type="submit"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600 text-sm bg-white px-3 py-1 rounded-md hover:bg-gray-100 transition-colors">
                                    Kirim kode
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Form Verifikasi OTP -->
                    <form method="POST" action="{{ route('verify.otp') }}" class="space-y-5 mb-6">
                        @csrf
                        <div>
                            <label for="otp" class="block text-white mb-2 text-sm">Kode OTP</label>
                            <input type="text" id="otp" name="otp"
                                class="w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                                placeholder="Masukkan kode OTP">
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition-colors duration-300">
                            Masuk
                        </button>

                        <div class="border-t border-white/20 pt-4 mt-6">
                            <p class="text-center text-white text-sm">
                                <a href="{{ route('login') }}" class="text-blue-200 hover:underline">Kembali login!</a>
                            </p>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</body>
</html>

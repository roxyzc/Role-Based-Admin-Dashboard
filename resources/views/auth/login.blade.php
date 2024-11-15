<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="h-screen flex">
    <!-- Left Side - Login Form -->
    <div class="w-1/2 flex flex-col justify-center items-center bg-[#E6F4FE] relative">
        <!-- Logoipsum di Pojok Kiri Atas -->
        <div class="absolute top-8 left-8 text-3xl font-bold text-blue-600">
            <i class="fas fa-circle text-blue-600"></i> Logoipsum
        </div>



        <!-- Login Form -->
        <div class="w-3/4 max-w-sm mt-16">
            <h2 class="text-3xl font-bold mb-6 text-center text-black">Login disini</h2>

            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4 flex flex-col items-center">
                @csrf
                <input type="text" name="email" placeholder="Email" required
                    class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="password" name="password" placeholder="Password" required
                    class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <div class="flex items-center justify-between w-full text-sm text-gray-600">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        Simpan Login Saya
                    </label>
                    <a href="#" class="text-blue-600 hover:underline">Lupa Password</a>
                </div>

                <button type="submit"
                    class="w-64 p-3 text-lg text-white bg-[#1098F7] rounded-lg hover:bg-blue-600">Login</button>
            </form>

            <!-- Garis Pemisah dengan Teks "Atau" -->
            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-gray-500">Atau</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Icon Media Sosial -->
            <div class="flex justify-center space-x-4">
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-facebook-f text-sm font-bold"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-google text-sm font-bold"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-linkedin text-sm"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Right Side - Register Info -->
    <div class="w-1/2 flex flex-col justify-center items-center p-16 text-white"
        style="background-image: url('{{ asset('images/login.png') }}'); background-size: cover; background-position: center;">
        <h2 class="text-5xl font-semibold text-center mt-8">
            <div class="mb-6">Login Untuk</div>
            <div>Melihat Kinerja</div>
        </h2>

        <p class="text-center mt-8">
            <div>Jika Anda belum memiliki akun, daftar sekarang dan mulai</div>
            <div>optimalkan performa tim Anda</div>
        </p>

        <!-- Tombol Register -->
        <a href="{{ route('register') }}"
            class="px-8 py-3 border-2 border-blue-600 text-white rounded-lg hover:bg-blue-600 hover:text-white font-semibold w-48 mt-4 text-center">
            Register
        </a>
    </div>
</body>

</html>
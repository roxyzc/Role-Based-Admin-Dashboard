<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="flex h-screen">
    <!-- Bagian Kiri - Background dengan gambar -->
    <div class="w-1/2 bg-cover bg-center flex flex-col justify-center items-center text-white" style="background-image: url('{{ asset('images/register.png') }}');">
        <h2 class="text-5xl font-semibold text-center mt-8">
            <div class="mb-6">Jadilah Bagian</div>
            <div>Dari Kami</div>
        </h2> 

        <p class="text-center mt-8">
            <div>Jika sudah memiliki akun, langsung masuk dan mulai </div>
            <div>pantau kinerja tim Anda</div>
        </p>     

        <!-- Tombol Login dengan transparansi dan border -->
        <a href="{{ route('login') }}" class="px-8 py-3 border-2 border-blue-600 text-white rounded-lg hover:bg-blue-600 hover:text-white font-semibold w-48 mt-4 text-center">Login</a>
    </div>

    <!-- Bagian Kanan - Register Form -->
    <div class="w-1/2 flex flex-col justify-center items-center bg-[#E6F4FE] relative">
        <!-- Logoipsum di pojok kiri atas bagian register -->
        <div class="absolute top-8 left-8 text-blue-600 text-3xl font-bold">
            <i class="fas fa-circle text-blue-600"></i> Logoipsum
        </div>

        <div class="w-3/4 max-w-sm mt-16">
            <h2 class="text-3xl font-bold mb-6 text-center text-black">Register disini</h2>
        
            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
             @endif 

            <form action="{{ route('register') }}" method="POST" class="space-y-4 flex flex-col items-center"> <!-- Menambahkan flex dan items-center -->
                @csrf
                <input type="text" name="username" placeholder="Username" class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="email" name="email" placeholder="Email" class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="password" name="password" placeholder="Password" class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full p-3 text-lg bg-gray-100 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                <button type="submit" class="w-64 p-3 text-lg text-white bg-[#1098F7] rounded-lg hover:bg-blue-600">Register</button>
            </form>
        </div>        

        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-4 text-gray-500">Atau</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>
        

            <!-- Social Media Icons -->
            <div class="flex justify-center space-x-4">
                <a href="#" class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-facebook-f text-sm font-bold"></i> <!-- Ikon dengan bulatan lebih kecil -->
                </a>
                <a href="#" class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-google text-sm font-bold"></i> <!-- Ikon dengan bulatan lebih kecil -->
                </a>
                <a href="#" class="w-10 h-10 flex items-center justify-center text-black bg-white rounded-full border-2 border-black hover:bg-gray-100">
                    <i class="fab fa-linkedin text-sm "></i> <!-- Ikon dengan bulatan lebih kecil -->
                </a>
            </div>
        </div>
    </div>
</body>
</html>
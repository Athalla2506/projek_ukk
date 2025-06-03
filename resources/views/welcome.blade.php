<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PKL SIJA</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-r from-violet-950 to-blue-700 text-white min-h-screen">
    <!-- Navbar -->
    <nav class="flex justify-between items-center p-5 fixed top-0 w-full z-10">
        <div class="text-2xl font-bold">PKL SIJA Stembayo</div>
        <div>
            <a href="{{ route('dashboard') }}" class="mr-4 hover:text-gray-200">Login</a>
            <a href="{{ route('register') }}" class="bg-white text-black px-4 py-2 rounded hover:bg-gray-100">Register</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-between px-20">
        <div class="w-1/2">
            <img src="{{asset('image/4siswa.png')}}" alt="Hero Image" class="w-full max-w-2xl">
        </div>
        <div class="w-1/2 text-center space-y-6">
            <h1 class="text-5xl font-bold leading-tight">Praktik Kerja Lapangan SIJA</h1>
            <p class="text-xl leading-relaxed max-w-xl mx-auto opacity-90">
                SMK Jurusan Sistem Informasi Jaringan Aplikasi dengan program 4 tahun, 
                PKL minimal 10 bulan atau 1.368 JP yang dapat dilakukan pada semester 7 atau 8
            </p>
            <div class="mt-8">
                <a href="{{ route('login') }}" class="bg-white text-blue-700 px-8 py-3 rounded-full font-semibold text-lg hover:bg-gray-100 transition duration-300">
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </section>
</body>
</html>
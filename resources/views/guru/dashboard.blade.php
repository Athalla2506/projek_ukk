{{-- resources/views/guru/dashboard.blade.php --}}
<x-layouts.app.sidebar title="Dashboard Guru">
    <div class="p-6 sm:p-8 lg:ml-64  min-h-screen">
        <div class="mb-8 bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="mt-2 text-gray-600 text-lg">Ini adalah halaman dashboard untuk <span class="font-semibold text-indigo-600">Guru</span>.</p>
        </div>
        
        <div class="space-y-8">
            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-indigo-500 hover:transform hover:scale-105 transition-all">
                    <h3 class="text-lg font-semibold text-gray-700">Total SIJA A</h3>
                    <p class="text-4xl font-bold text-indigo-600 mt-3">{{ $totalSijaA ?? 36 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Siswa Terdaftar</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-green-500 hover:transform hover:scale-105 transition-all">
                    <h3 class="text-lg font-semibold text-gray-700">Total SIJA B</h3>
                    <p class="text-4xl font-bold text-green-600 mt-3">{{ $totalSijaB ?? 36 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Siswa Terdaftar</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-blue-500 hover:transform hover:scale-105 transition-all">
                    <h3 class="text-lg font-semibold text-gray-700">Total Guru</h3>
                    <p class="text-4xl font-bold text-blue-600 mt-3">{{ $totalGuru ?? 6 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Pengajar Aktif</p>
                </div>
            </div>
            
            {{-- Daftar Siswa --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- SIJA A --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-indigo-600 p-4">
                        <h2 class="text-xl text-white font-semibold">Daftar Siswa SIJA A</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-500 scrollbar-track-gray-200">
                            @forelse($siswaA ?? [] as $siswa)
                                <div class="p-4 bg-gray-50 rounded-lg hover:bg-indigo-50 transition-all flex items-center">
                                    <span class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mr-3">
                                        {{ substr($siswa->nama, 0, 1) }}
                                    </span>
                                    <span class="text-gray-700">{{ $siswa->nama }}</span>
                                </div>
                            @empty
                                <div class="p-4 text-gray-500 text-center">
                                    Belum ada data siswa
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- SIJA B --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-blue-600 p-4">
                        <h2 class="text-xl text-white font-semibold">Daftar Siswa SIJA B</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-gray-200">
                            @forelse($siswaB ?? [] as $siswa)
                                <div class="p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition-all flex items-center">
                                    <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                                        {{ substr($siswa->nama, 0, 1) }}
                                    </span>
                                    <span class="text-gray-700">{{ $siswa->nama }}</span>
                                </div>
                            @empty
                                <div class="p-4 text-gray-500 text-center">
                                    Belum ada data siswa
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Guru --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-green-600 p-4">
                    <h2 class="text-xl text-white font-semibold">Daftar Guru</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($gurus ?? [] as $guru)
                            <div class="p-4 bg-gray-50 rounded-lg hover:bg-green-50 transition-all flex items-center">
                                <span class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-3">
                                    {{ substr($guru->nama, 0, 1) }}
                                </span>
                                <span class="text-gray-700">{{ $guru->nama }}</span>
                            </div>
                        @empty
                            <div class="col-span-2 p-4 text-gray-500 text-center">
                                Belum ada data guru
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>
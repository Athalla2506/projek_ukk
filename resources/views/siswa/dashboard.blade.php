{{-- resources/views/siswa/dashboard.blade.php --}}
<x-layouts.app.sidebar title="Dashboard Siswa">
    <div class="p-6 sm:p-8 lg:ml-64 min-h-screen">
        <!-- Welcome Section with Enhanced Gradient Background -->
        <div class="mb-8 p-8 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 rounded-3xl text-white shadow-xl">
            <h1 class="text-4xl font-bold tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="mt-3 text-lg opacity-90">Dashboard <strong>Siswa</strong></p>
        </div>
        
        <!-- Main Content with Enhanced Styling -->
        <div class="space-y-8">
            @if($pkl)
                <!-- PKL Info Card -->
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">Informasi PKL</h2>
                        <span class="px-5 py-2 rounded-full text-sm font-semibold {{ $pkl->status ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $pkl->status ? 'Diterima ✓' : 'Pending ⌛' }}
                        </span>
                    </div>
                    
                    @if($pkl)
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl border border-indigo-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-sm font-semibold text-indigo-600 mb-2">Tempat PKL</h3>
                                    <p class="text-xl font-bold text-gray-800">{{ $pkl->industri->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-2">{{ $pkl->industri->alamat }}</p>
                                </div>
                                
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl border border-indigo-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-sm font-semibold text-indigo-600 mb-2">Periode PKL</h3>
                                    <div class="flex items-center space-x-3 text-gray-800 text-lg">
                                        <span>{{ $pkl->tanggal_mulai->format('d F Y') }}</span>
                                        <span class="text-indigo-400">→</span>
                                        <span>{{ $pkl->tanggal_selesai->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl border border-indigo-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-sm font-semibold text-indigo-600 mb-2">Guru Pembimbing</h3>
                                    <p class="text-xl font-bold text-gray-800">{{ $pkl->guru->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-2">{{ $pkl->guru->email }}</p>
                                </div>
                                
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl border border-indigo-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-sm font-semibold text-indigo-600 mb-2">Kontak Industri</h3>
                                    <p class="text-xl font-bold text-gray-800">{{ $pkl->industri->kontak }}</p>
                                    <p class="text-sm text-gray-600 mt-2">{{ $pkl->industri->email }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl border-2 border-dashed border-indigo-200">
                            <svg class="w-16 h-16 mx-auto text-indigo-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-600 text-lg mb-6">Anda belum mendaftar PKL</p>
                            <a href="{{ route('siswa.pkl.daftar') }}" 
                                class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 transition-colors duration-300 shadow-lg hover:shadow-xl">
                                Daftar PKL Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-16 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl border-2 border-dashed border-indigo-200">
                    <svg class="w-16 h-16 mx-auto text-indigo-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-600 text-lg mb-6">Belum ada data PKL tersedia</p>
                    <a href="{{ route('siswa.pkl.daftar') }}" 
                       class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 transition-colors duration-300 shadow-lg hover:shadow-xl">
                        Daftar PKL Sekarang
                    </a>
                </div>
            @endif

            <!-- Enhanced Student List Card -->
            <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Daftar Siswa PKL</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-indigo-200">
                                <th class="px-8 py-4 text-left text-xs font-bold text-indigo-600 uppercase tracking-wider">Nama</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-indigo-600 uppercase tracking-wider">Tempat PKL</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-indigo-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($siswaList as $siswa)
                                <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                    <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-gray-800">
                                        {{ $siswa->nama }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-600">
                                        {{ $siswa->pkl->industri->nama }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="px-4 py-2 text-xs rounded-full font-medium {{ $siswa->pkl->status ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $siswa->pkl->status ? 'Diterima ✓' : 'Pending ⌛' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-16 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <p class="text-lg">Belum ada data siswa PKL</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>
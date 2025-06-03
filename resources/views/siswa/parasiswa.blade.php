<x-layouts.app.sidebar title="Daftar Siswa">
    <div class="p-6 sm:p-8 lg:ml-64">
        <!-- Header -->
        <div class="mb-8 p-6 bg-gradient-to-r from-indigo-500 to-indigo-700 rounded-2xl text-white">
            <h1 class="text-3xl font-bold">Daftar Siswa</h1>
            <p class="mt-2 opacity-90">Manajemen data siswa</p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="space-y-3 h-[500px] overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-500 scrollbar-track-gray-200">
                    @forelse($siswa as $s)
                        <div class="p-4 bg-gray-50 rounded-lg hover:bg-indigo-50 transition-all flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mr-3 text-lg font-medium">
                                    {{ substr($s->name, 0, 1) }}
                                </span>
                                <span class="text-gray-700 font-medium">{{ $s->name }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $s->email }}</span>
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
</x-layouts.app.sidebar>
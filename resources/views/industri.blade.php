<x-layouts.app.sidebar title="Daftar Industri">
    <div class="p-6 sm:p-8 lg:ml-64">
        <!-- Header -->
        <div class="mb-8 p-6 bg-gradient-to-r from-indigo-500 to-indigo-700 rounded-2xl text-white">
            <h1 class="text-3xl font-bold">Daftar Industri</h1>
            <p class="mt-2 opacity-90">Manajemen data industri PKL</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Data Industri</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                    <th class="px-6 py-4 text-left text-sm font-semibold">Nama Industri</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Alamat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Kontak</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($industri as $industri)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $industri->nama }}</div>
                        </td>
                        <td class="px-6 py-4">
                        <div class="text-gray-600">{{ $industri->alamat }}</div>
                        </td>
                        <td class="px-6 py-4">
                        <div class="text-gray-600">{{ $industri->kontak }}</div>
                        </td>
                        <td class="px-6 py-4">
                        <div class="text-indigo-600">{{ $industri->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                        <form action="{{ route('industri.destroy', ['id' => $industri->id]) }}" method="POST" 
                            onSubmit="return confirm('Apakah Anda yakin ingin menghapus industri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                            class="px-3 py-1 text-red-600 hover:text-red-800 font-medium rounded-lg hover:bg-red-50 transition duration-150">
                            Hapus
                            </button>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada data industri tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Tambah Industri Baru</h2>
                <div class="h-1 w-32 bg-indigo-600 rounded-full"></div>
            </div>
            <form action="{{ route('industri.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Industri</label>
                    <input type="text" name="nama" required
                        class="w-full text-gray-800 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat" required
                        class="w-full text-gray-800 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontak</label>
                    <input type="text" name="kontak"
                        class="w-full text-gray-800 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full text-gray-800 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                    </div>
                </div>
                </div>
                <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full text-gray-800 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150"></textarea>
                </div>
                <div class="mt-8">
                <button type="submit" 
                    class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                    Tambah Industri
                </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>
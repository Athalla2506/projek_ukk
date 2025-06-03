<x-layouts.app.sidebar title="Daftar PKL">
    <div class="p-6 sm:p-8 lg:ml-64">
        <!-- Header Section -->
        <div class="mb-8 p-8 bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-700 rounded-2xl text-white shadow-xl">
            <h1 class="text-3xl font-bold tracking-tight">Formulir Pendaftaran PKL</h1>
            <p class="mt-2 opacity-90 text-indigo-100">Silakan lengkapi data PKL Anda dengan teliti</p>
        </div>

        @if(!$pkl)
            <div class="mx-auto bg-white rounded-2xl shadow-xl p-8 border border-gray-200 hover:shadow-2xl transition duration-300">
                <form action="{{ route('siswa.pkl.simpan') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Pilih Tempat PKL -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200 hover:border-indigo-300 transition duration-300">
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Pilih Tempat PKL</label>
                        <select name="industri_id" class="w-full rounded-lg border-gray-300 bg-white text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 transition duration-200">
                            <option value="" class="text-gray-500">-- Pilih Perusahaan --</option>
                            @foreach($industris as $industri)
                                <option value="{{ $industri->id }}" class="text-gray-700">{{ $industri->nama }}</option>
                            @endforeach
                        </select>
                        @error('industri_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal PKL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200 hover:border-indigo-300 transition duration-300">
                            <label class="block text-lg font-semibold text-gray-800 mb-3">Tanggal Mulai PKL</label>
                            <input type="date" name="tanggal_mulai" class="w-full rounded-lg border-gray-300 bg-white text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 transition duration-200">
                            @error('tanggal_mulai')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200 hover:border-indigo-300 transition duration-300">
                            <label class="block text-lg font-semibold text-gray-800 mb-3">Tanggal Selesai PKL</label>
                            <input type="date" name="tanggal_selesai" class="w-full rounded-lg border-gray-300 bg-white text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 transition duration-200">
                            @error('tanggal_selesai')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transform hover:-translate-y-1 transition duration-300 font-semibold shadow-lg hover:shadow-xl">
                            Daftar PKL
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="max-w-3xl mx-auto bg-indigo-50 p-8 rounded-xl border-2 border-indigo-200 shadow-lg">
                <p class="text-indigo-800 text-center text-lg font-medium">Anda sudah mendaftar PKL. Silakan cek status di dashboard.</p>
            </div>
        @endif
    </div>
</x-layouts.app.sidebar>
<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaPklController;
use App\Http\Controllers\ParaSiswaController;
use App\Http\Controllers\IndustriController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔁 Redirect pengguna ke dashboard berdasarkan role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('super_admin')) {
        return redirect('/admin'); // Filament admin
    } elseif ($user->hasRole('guru')) {
        return redirect()->route('guru');
    } elseif ($user->hasRole('siswa')) {
        return redirect()->route('siswa');
    } else {
        abort(403, 'Role tidak dikenali.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// 🧑‍🏫 Dashboard Guru
Route::middleware(['auth', RoleMiddleware::class . ':guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru');
});

// 🎓 Dashboard Siswa 
Route::middleware(['auth', RoleMiddleware::class . ':siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'index'])->name('siswa');

    // PKL Routes
    Route::get('/siswa/pkl/daftar', [SiswaPklController::class, 'daftar'])->name('siswa.pkl.daftar');
    Route::post('/siswa/pkl/simpan', [SiswaPklController::class, 'simpan'])->name('siswa.pkl.simpan');
    // Route::get('/siswa/parasiswa', [SiswaPklController::class, 'parasiswa'])->name('siswa.parasiswa');


});

// ⚙️ Pengaturan Volt
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// 🏭 Industri Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/industri', [IndustriController::class, 'index'])->name('industri.index');
    Route::post('/industri', [IndustriController::class, 'store'])->name('industri.store');
    Route::delete('/industri/{id}', [IndustriController::class, 'destroy'])->name('industri.destroy');
});

require __DIR__.'/auth.php';

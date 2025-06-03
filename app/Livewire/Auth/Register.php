<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Check email dan assign role
        $guru = \App\Models\Guru::where('email', $validated['email'])->first();
        if ($guru) {
            $user->assignRole('Guru');
            $redirectTo = '/guru/dashboard';
        }

        $siswa = \App\Models\Siswa::where('email', $validated['email'])->first();
        if ($siswa) {
            $user->assignRole('Siswa');
            $redirectTo = '/siswa/dashboard';
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect berdasarkan role
        if (isset($redirectTo)) {
            $this->redirect($redirectTo, navigate: true);
        } else {
            // Jika tidak memiliki role yang valid
            Auth::logout();
            session()->flash('error', 'Email tidak terdaftar sebagai Guru atau Siswa.');
            return;
        }
    }
}
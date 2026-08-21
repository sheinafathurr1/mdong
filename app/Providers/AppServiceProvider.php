<?php

namespace App\Providers;

use App\Models\Dosen;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sisipkan role ke URL reset password supaya form reset tahu broker
        // (mahasiswa/dosen) mana yang harus dipakai saat token diproses.
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            $role = $notifiable instanceof Dosen ? 'dosen' : 'mahasiswa';

            return url(route('password.reset', [
                'role' => $role,
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });
    }
}

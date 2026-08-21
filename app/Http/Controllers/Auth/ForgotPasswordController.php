<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Menampilkan form "Lupa Password"
    public function showLinkRequestForm(Request $request)
    {
        $role = $request->query('role') === 'dosen' ? 'dosen' : 'mahasiswa';

        return view('auth.forgot-password', ['role' => $role]);
    }

    // Mengirim link reset ke email mahasiswa/dosen
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:mahasiswa,dosen',
        ]);

        $status = Password::broker($request->role)->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password (link dari email)
    public function showResetForm(Request $request, string $role, string $token)
    {
        if (! in_array($role, ['mahasiswa', 'dosen'])) {
            abort(404);
        }

        return view('auth.reset-password', [
            'role' => $role,
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    // Memproses password baru
    public function reset(Request $request)
    {
        $request->validate([
            'role' => 'required|in:mahasiswa,dosen',
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker($request->role)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = $password; // dihash otomatis lewat mutator model
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan masuk kembali.')
            : back()->withErrors(['email' => __($status)]);
    }
}

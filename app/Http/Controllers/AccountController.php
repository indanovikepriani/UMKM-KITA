<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Tampilkan halaman akun user (profil + ringkasan pesanan).
     */
    public function index()
    {
        $user = Auth::user();

        // Ringkasan pesanan untuk ditampilkan di halaman akun
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $orderStats = [
            'total_orders'     => $user->orders()->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'pending_orders'   => $user->orders()->whereIn('status', ['pending', 'processing'])->count(),
        ];

        return view('account.index', compact('user', 'recentOrders', 'orderStats'));
    }

    /**
     * Update data profil (nama, email, telepon, alamat).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'   => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
        ]);

        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update foto profil (avatar).
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->avatar && file_exists(public_path($user->avatar))) {
            @unlink(public_path($user->avatar));
        }

        $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images/avatars'), $avatarName);

        $user->update(['avatar' => 'images/avatars/' . $avatarName]);

        return redirect()->route('account.index')->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Update password akun.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'          => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('account.index')->with('success', 'Password berhasil diperbarui!');
    }
}

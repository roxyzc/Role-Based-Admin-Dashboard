<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;

class SettingsController extends Controller
{
    public function index()
    {
        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('settings.index', ['user' => Auth::user(),  'unreadNotificationsCount' => $unreadNotificationsCount,]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:15|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:15|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'first_name.string' => 'Nama depan harus berupa teks.',
            'first_name.max' => 'Nama depan maksimal :max karakter.',
            'first_name.regex' => 'Nama depan hanya boleh mengandung huruf dan spasi.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'last_name.string' => 'Nama belakang harus berupa teks.',
            'last_name.max' => 'Nama belakang maksimal :max karakter.',
            'last_name.regex' => 'Nama belakang boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus memiliki format yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'profile_picture.image' => 'Foto profil harus berupa gambar.',
            'profile_picture.mimes' => 'Foto profil harus berformat jpeg, png, atau jpg.',
            'profile_picture.max' => 'Ukuran foto profil maksimal 2MB.',
        ]);

        $user = Auth::user();
        $user->first_name = preg_replace('/\s+/', ' ', trim(strtolower($request->first_name)));
        $user->last_name = preg_replace('/\s+/', ' ', trim(strtolower($request->last_name)));
        $user->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('public/profile_pictures');
        }

        $user->save();

        return redirect()->route('settings.index')->with('success', 'Profile berhasil diubah');
    }

    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::user();
        if ($user->profile_picture) {
            Storage::delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
            return redirect()->route('settings.index')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('settings.index')->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|max:26|confirmed|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.regex' => 'Password minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password salah']);
        }

        $user->password = $request->new_password;
        $user->save();

        return redirect()->route('settings.index')->with('success', 'Password berhasil diubah');
    }
}

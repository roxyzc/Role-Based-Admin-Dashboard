<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog; // Pastikan ini diimport
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:26'
        ], [
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib di isi',
            'password.min' => 'Password minimal :min',
            'password.max' => 'Password maksimal :max',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['login_error' => 'Email dan password salah'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Password salah'])
                ->withInput();
        }
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'Login',
            'description' => 'User logged in',
        ]);

        return redirect()->intended('/');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:6|max:18|regex:/^[A-Za-z0-9\s]+$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:26|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/',
            'confirm_password' => 'required|same:password',
        ], [
            'username.unique' => 'Username sudah ada',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal :min',
            'username.max' => 'Username maksimal :max',
            'username.regex' => 'Username hanya boleh terdiri dari huruf, angka, dan spasi',
            'email.required' => 'Email wajib di isi',
            'email.unique' => 'Email sudah ada',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib di isi',
            'password.min' => 'Password minimal :min',
            'password.max' => 'Password maksimal :max',
            'password.regex' => 'Password minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol',
            'confirm_password.required' => 'Confirm password wajib disi',
            'confirm_password.same' => 'Confirm password harus sama dengan password'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::where('role_name', '!=', 'admin')
            ->whereDoesntHave('permissions', function ($query) {
                $query->where('name', 'package_leader');
            })->first();

        User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role_id' => $role->id
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'Logout',
            'description' => 'User logged out',
        ]);

        Auth::logout();

        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $expiry = now()->addMinutes(5)->timestamp;
        $tokenData = (object)[
            'email' => $request->email,
            'expiry' => $expiry
        ];

        $tokenDataJson = json_encode($tokenData);

        $secretKey = env('APP_KEY');

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

        $token = openssl_encrypt($tokenDataJson, 'AES-256-CBC', $secretKey, 0, $iv);

        $encryptedData = base64_encode($iv . $token);
        $safeToken = rtrim(strtr($encryptedData, '+/', '-_'), '=');

        $resetLink = route('show.reset.password', ['token' => $safeToken]);

        Mail::send('emails.password_reset', ['resetLink' => $resetLink], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password');
        });

        return redirect()->back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6|max:26|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/',
            'confirm_password' => 'required|same:password'
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'password.max' => 'Password maksimal :max karakter.',
            'password.regex' => 'Password minimal harus mengandung 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $token = $request->token;

        $base64Token = strtr($token, '-_', '+/');
        $base64Token = $base64Token . str_repeat('=', (4 - strlen($base64Token) % 4) % 4);
        $secretKey = env('APP_KEY');

        $encryptedData = base64_decode($base64Token);

        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($encryptedData, 0, $ivLength);
        $token = substr($encryptedData, $ivLength);

        $decryptedData = openssl_decrypt($token, 'AES-256-CBC', $secretKey, 0, $iv);
        $data = json_decode($decryptedData);

        if (!isset($data->expiry) || !isset($data->email)) {
            return redirect()->back()
                ->withErrors(['error' => 'Token tidak valid']);
        }

        if ($data->expiry && $data->expiry < now()->timestamp) {
            return redirect()->back()
                ->withErrors(['error' => 'Token sudah kadaluarsa']);
        }

        $user = User::where('email', $data->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['error' => 'Email tidak ditemukan.']);
        }

        $user = User::where('email', $data->email)->first();

        $user->password = $request->password;
        $user->save();

        return redirect()->route('login')->with('success', 'Password Anda telah berhasil direset. Silakan login dengan password baru Anda.');
    }
}

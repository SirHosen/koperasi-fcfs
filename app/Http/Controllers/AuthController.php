<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/member/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:members',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:L,P',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'role' => 'member',
            ]);

            $memberNumber = 'KOP' . date('Y') . str_pad(Member::count() + 1, 3, '0', STR_PAD_LEFT);

            Member::create([
                'user_id' => $user->id,
                'member_number' => $memberNumber,
                'nik' => $validated['nik'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'occupation' => $validated['occupation'],
                'monthly_income' => $validated['monthly_income'],
                'join_date' => now(),
                'status' => 'active',
            ]);

            DB::commit();

            Auth::login($user);
            return redirect('/member/dashboard');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mendaftar.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

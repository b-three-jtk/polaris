<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Submitter;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        // Daftar domain umum yang tidak diizinkan
        $blockedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) use ($blockedDomains) {
                    // Ambil domain dari email
                    $emailDomain = substr(strrchr($value, "@"), 1);
    
                    // Cek apakah domain ada di daftar domain yang diblokir
                    if (in_array($emailDomain, $blockedDomains)) {
                        $fail('Email tidak valid. Gunakan email corporate yang sesuai.');
                    }
                },
            ],
            'position' => 'required|string|max:255',
            'organization_name' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Validasi data gagal. Periksa input Anda.')->withInput();
        }
    
        DB::beginTransaction();
    
        try {
            $organization_code = strtoupper(substr($request->organization_name, 0, 3) . rand(100, 999));
    
            $organization = Organization::firstOrCreate(
                ['organization_name' => $request->organization_name],
                ['organization_code' => $organization_code]
            );
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            Submitter::create([
                'user_id' => $user->user_id,
                'position_in_organization' => $request->position,
                'organization_code' => $organization->organization_code,
            ]);
    
            DB::commit();
    
            auth()->login($user);
    
            event(new Registered($user));
    
            return redirect()->route('verification.notice');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
    
            \Log::error('Error saat registrasi: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Terjadi kesalahan saat proses registrasi. Silakan coba lagi.')->withInput();
        }
    }    

    //Verify Email Notice Handler
    public function verifyNotice () {
        return view('auth.verify-email');
    }

    // Email Veryfication Handler
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home');
    }

    //Resending the Verification Email route
    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    }

    public function showLoginForm()
    {
        return view('auth.signin'); 
    }

    public function submitlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $user = Auth::user();

            // Cek jika email pengguna sudah terverifikasi
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();  // Log out jika email belum terverifikasi
                return back()->onlyInput('email')->with('error', 'Email Anda belum terverifikasi!');
            }

            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

}
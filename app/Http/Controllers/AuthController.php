<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\OtpMail;
class AuthController extends Controller

{
    // Display the registration form
    public function register()
    {
        try {
            return view('auth.register');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to load registration page. Please try again.']);
        }
    }

    // Handle registration form submission
    public function registerSave(Request $request)
    {
        try {
            // Validasi data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'address' => 'required|string|max:255',
                'role' => 'pengaju',
                'level' => 'required|in:Pelajar/Mahasiswa,Event Organizer',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
            ], [
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Menyimpan data pengguna
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'role' => 'pengaju',  // Set role ke pengaju
                'level' => $request->level,  // Level sesuai dengan input (student atau event_organizer)
                'password' => Hash::make($request->password),
            ]);

            // Assign role 'pengaju' pada user
            $user->assignRole('pengaju');
            Mail::to($user->email)->send(new WelcomeMail($user));
            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'There was an issue with your registration. Please try again later.']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    // Display the login form
    public function login()
    {
        try {
            Session::forget('email');
            return view('auth.login');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'There was an issue loading the login page.']);
        }
    }

    // Handle login form submission
    public function loginAction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ], [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Cek kredensial pengguna
            if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                // Simpan pesan error ke session dengan nama 'gagal'
                return back()->with('gagal', '*Email atau kata sandi salah.');
            }

            // Regenerasi session
            $request->session()->regenerate();

            // Redirect sesuai dengan role pengguna
            $user = Auth::user(); // Ambil user yang sedang login
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboardAdmin.show');
                case 'pr':
                    return redirect()->route('dashboardPR.index');
                case 'pengaju':
                    return redirect()->route('ajuan.index');
                default:
                    // Default redirect jika role tidak dikenali
                    return redirect()->route('landing');
            }
        } catch (ValidationException $e) {
            // Tangani exception validasi jika ada masalah dengan input form
            return back()->withErrors(['error' => 'Invalid email or password. Please check your credentials.']);
        } catch (Exception $e) {
            // Tangani exception lainnya
            return back()->withErrors(['error' => 'An unexpected error occurred during login. Please try again later.']);
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();  // Logout pengguna

            $request->session()->invalidate();  // Hapus session
            $request->session()->regenerateToken();  // Regenerasi CSRF token

            return redirect('/')->with('success', 'Successfully logged out.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while logging out.']);
        }
    }

     // Show forgot password form
    public function showForgotPasswordForm()
    {
        try {
            return view('auth.forgot-password');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to load the forgot password page.']);
        }
    }

    // Send OTP email
    public function sendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email|max:255'
            ], [
                'email.exists' => 'The provided email is not registered.'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $otp = random_int(100000, 999999);
            $otpHash = hash('sha256', $otp);
            
            session([
                'email' => $request->email,
                'otp_hash' => $otpHash,
                'otp_sent' => true,
                'otp_expires_at' => now()->addMinutes(10),
                'otp_attempts' => 0
            ]);

            // Send OTP to the provided email using the OtpMail mailable
            Mail::to($request->email)->send(new OtpMail($otp));
            return back()->with('success', 'OTP code has been sent to your email.');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Database error while sending OTP.']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while sending OTP.']);
        }
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6'
            ]);

            if ($validator->fails()) {
                return back()->withErrors(['otp' => 'Invalid OTP format.'])->withInput();
            }

            $otpAttempts = session('otp_attempts', 0);
            if ($otpAttempts >= 3) {
                session()->forget(['otp_hash', 'otp_expires_at']);
                return back()->withErrors(['otp' => 'Too many failed attempts. Please request a new OTP.']);
            }

            if (hash('sha256', $request->otp) === session('otp_hash')) {
                if (now()->gt(session('otp_expires_at'))) {
                    return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
                }
                session(['otp_verified' => true]);
                return back()->with('success', 'OTP successfully verified.');
            }

            session(['otp_attempts' => $otpAttempts + 1]);
            return back()->withErrors(['otp' => 'Invalid OTP. Attempts remaining: ' . (3 - $otpAttempts)]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error occurred during OTP verification.']);
        }
    }

    public function resendOtp(Request $request)
    {
        // Retrieve email from the request
        $email = $request->email;

        // Generate a new OTP and send it via email
        $otp = rand(100000, 999999);  // Example, generate a 6-digit OTP

        // Save OTP to session or database, depending on your logic
        session(['otp' => $otp, 'email' => $email]);

        // Send OTP via email (this assumes you have a Mail setup for sending OTP)
        Mail::to($email)->send(new OtpMail($otp));  // You need to create the OtpMail class

        return back()->with('message', 'OTP has been resent to your email.');
    }

    // Save new password
    public function savePassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            session()->forget(['email', 'otp', 'otp_sent', 'otp_verified']);

            return redirect()->route('login')->with('success', 'Your password has been successfully updated.');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Database error while updating password.']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while saving new password.']);
        }
    }
}

<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Order; // TAMBAHKAN INI
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config; // Tambahkan baris ini
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use Exception;

class ProfileController extends Controller
{
    public function index()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.tentang_saya', compact('user'));
    }

    public function riwayat()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('orderItems.product')->get();

        return view('profile.riwayat_pembelian', compact('orders', 'user'));
    }

    public function privasiKeamanan()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.keamanan_privasi', compact('user'));
    }

    public function logOut()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.logout', compact('user'));
    }

    public function ubahEmail()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.ubah_email', compact('user'));
    }

    public function ubahEmailOTP()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.ubah_email_otp', compact('user'));
    }

    public function tambahNoTelepon()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.ubah_no_tlp', compact('user'));
    }

    public function tambahNoTeleponOTP()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.ubah_no_tlp_otp', compact('user'));
    }

    public function kirimOtpEmailLama(Request $request)
    {
        $request->validate([
            'email_baru' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        if ($request->email_baru == $user->email) {
            return back()->with('validation_error', 'Silakan masukkan email yang berbeda dari email saat ini.');
        }

        // Generate kode OTP
        $otp = random_int(100000, 999999);

        // Simpan data OTP dan email baru di session
        Session::put('otp_email', $otp);
        Session::put('email_baru', $request->email_baru);

        // ini buat ngecek email benar2 email bukan (dummy) tapi keknya juga butuh pihak ke tiga juga
        // try {
        //     Mail::raw("Kode OTP untuk mengubah email Anda: $otp", function ($message) use ($request) {
        //         $message->to($request->email_baru)
        //                 ->subject('Kode OTP Ubah Email');
        //     });
        // } catch (Exception $e) {
        //     Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
        //     return back()->with('error', 'Gagal mengirim OTP ke email Anda. Pastikan email aktif dan bisa menerima pesan.');
        // }

        // Kirim OTP ke email lama (email saat ini)
        Mail::raw("Kode OTP untuk mengubah email Anda: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode OTP Ubah Email');
        });

        return redirect()->route('ubah_email_otp')->with('success', 'Kode OTP telah dikirim ke email ' . $user->email . '.');
    }

    public function verifikasiOtpUbahEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        $otpSession = Session::get('otp_email');
        $emailBaru = Session::get('email_baru');

        if ($request->otp != $otpSession) {
            return back()->with('error', 'Kode OTP salah.');
        }

        // Ubah email user
        $user->email = $emailBaru;
        $user->save();

        // Hapus session
        Session::forget('otp_email');
        Session::forget('email_baru');

        return redirect()->route('profile')->with('success', 'Email berhasil diubah.');
    }

    public function kirimOtpAturNotlp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits_between:10,15',
        ], [
            'phone.digits_between' => 'Nomor telepon harus terdiri dari 10 hingga 15 digit.',
        ]);
    
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        if ($request->phone == $user->profile->phone) {
            return back()->with('validation_error', 'Nomor telepon tidak boleh sama dengan nomor yang sudah terdaftar.');
        }
    
        // Generate OTP
        $otp = rand(100000, 999999); // 6 digit OTP
        
        // Store OTP in session
        Session::put('otp_tlp', $otp);
        Session::put('phone', $request->phone);
    
        // Send OTP as raw text to email
        Mail::raw("Kode OTP untuk mengubah nomor telepon Anda: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode OTP Ubah Nomor Telepon');
        });

        // Redirect to OTP input page
        return redirect()->route('ubah_no_tlp_otp')->with('success', 'Kode OTP telah dikirim ke email ' . $user->email . '.');
    }

    public function verifikasiOtpAturNoTlp(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        // Validate OTP
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == Session::get('otp_tlp')) {
            if ($user->profile) {
                $user->profile->phone = Session::get('phone');
                $user->profile->save();
            }

            Session::forget('otp');
            Session::forget('phone');

            return redirect()->route('profile')->with('success', 'Nomer telepon berhasil diubah.');
        } 
        return back()->with('error', 'Kode OTP salah.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        $debugData = [
            'request_all' => $request->all(),
            'profile_exists' => $user->profile ? 'yes' : 'no'
        ];

        // Validasi semua field yang ada di form
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'birth_day' => 'nullable|integer|min:1|max:31',
            'birth_month' => 'nullable|integer|min:1|max:12',
            'birth_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update nama user jika berubah
        if ($user->name !== $request->name) {
            $user->name = $request->name;
            $user->save();
        }

        // Handle upload foto profil
        $profilePicturePath = $user->profile->profile_picture ?? null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $profilePicturePath = $file->store('profile_pictures', 'public');
        }

        // Data profile yang akan disimpan
        $profileData = [
            'username' => $request->username,
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
            'profile_picture' => $profilePicturePath,
        ];

        $user->profile()->updateOrCreate([], $profileData);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        // logika hapus akun
        $user = $request->user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }

}
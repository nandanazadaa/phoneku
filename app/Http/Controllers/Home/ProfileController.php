<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profile;

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
    public function profileKeamanan()
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        
        // Pass the user to the view
        return view('profile.keamanan_privasi', compact('user'));
    }

    public function update(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        // Get user's profile
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        $profileId = $profile ? $profile->profile_id : null;

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:profiles,username,' . $profileId . ',profile_id',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_day' => 'nullable|integer|min:1|max:31',
            'birth_month' => 'nullable|integer|min:1|max:12',
            'birth_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'profile_picture' => 'nullable|image|mimes:png,jpg,jpeg|max:1024', // Max 1MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update user data directly in the database
        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->name
        ]);

        // Prepare profile data
        $profileData = [
            'username' => $request->username,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($profile && isset($profile->profile_picture)) {
                Storage::delete('public/' . $profile->profile_picture);
            }
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profileData['profile_picture'] = $path;
        }

        // Update or create profile using DB
        if ($profile) {
            DB::table('profiles')->where('profile_id', $profile->profile_id)->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            DB::table('profiles')->insert($profileData);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
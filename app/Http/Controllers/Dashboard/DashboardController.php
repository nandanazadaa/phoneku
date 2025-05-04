<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Check if the user is an admin
     * 
     * @return bool
     */
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }
    
    /**
     * Redirect if user is not an admin
     * 
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function redirectIfNotAdmin()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'You must be logged in as an admin to access this page']);
        }
        
        return null;
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }
        
        return view('admin.dashboard');
    }
    
    /**
     * Show the products page
     */
    public function productsIndex()
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }
        
        return view('admin.card_product');
    }

    /**
     * Show the users page
     */
    public function usersIndex()
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }
        
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a new user
     */
    public function store(Request $request)
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:customer,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.index')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User added successfully.');
    }

    /**
     * Update an existing user
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:customer,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        if ($redirect = $this->redirectIfNotAdmin()) {
            return $redirect;
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
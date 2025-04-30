<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
}
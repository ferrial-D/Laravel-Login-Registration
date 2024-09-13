<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthManager extends Controller
{
    // Show login page
    public function login_page() {
        if (Auth::check()){
            return redirect(route('home'));
        }
        return view('login_page');
    }

    // Show registration page
    public function registration() {
        if (Auth::check()){
            return redirect(route('home'));
        }
        return view('registration');
    }

    // Handle login form submission
    public function loginPost(Request $request) {
        // Validate form input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Get user credentials from form input
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }

        // Redirect back to login page if login fails
        return redirect(route('login_page'))->with("error", "Login details are not valid");
    }

    // Handle registration form submission
    public function registrationPost(Request $request) {
        // Validate form input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // Prepare user data
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);  // Hash password before saving

        // Create new user
        $user = User::create($data);

        // Check if user creation was successful
        if (!$user) {
            return redirect(route('registration'))->with("error", "Registration failed");
        }

        return redirect(route('login_page'))->with("success", "Registration successful");
    }

    // Handle user logout
    public function logout() {
        // Clear session and log out user
        Session::flush();
        Auth::logout();

        // Redirect to login page
        return redirect(route('login_page'));
    }
}

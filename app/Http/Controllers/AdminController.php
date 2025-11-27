<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;

class AdminController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function landing()
    {
        $articles = \App\Models\Article::where('is_published', true)
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)
                                     ->get();
        return view('landing', compact('articles'));
    }

    public function formLogin()
    {
        return view('login');
    }

    public function prosesLogin(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if ($result['success']) {
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }
        
        return back()->with('error', $result['message']);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('landing')->with('success', 'Logout berhasil!');
    }

    public function formRegister()
    {
        return view('register');
    }

    public function prosesRegister(RegisterRequest $request)
    {
        try {
            $this->authService->register($request->validated());
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}

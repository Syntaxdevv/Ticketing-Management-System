<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Kunin ang role ng user na kakalog-in lang
        $role = strtolower(Auth::user()->role);

        // 2. Redirect logic base sa role
        // Kung admin, itapon sa manage tickets page
        if ($role === 'admin') {
            return redirect()->intended(route('admin.tickets.index'));
        }

        // Kung agent, itapon sa agent dashboard
        if ($role === 'agent') {
            return redirect()->intended(route('agent.dashboard'));
        }

        // 3. Default redirect para sa normal users/customers
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
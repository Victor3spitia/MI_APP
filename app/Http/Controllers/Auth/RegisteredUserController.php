<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
            $request->validate([
        'avatar' => 'required|image|max:2048', // Máx 2MB
    ]);

    $user = Auth::user();

    // Elimina el avatar anterior si existe
    if ($user->avatar) {
        Storage::disk('public')->delete('avatars/' . $user->avatar);
    }

    // Guarda el nuevo
    $file = $request->file('avatar');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('public/avatars', $filename);

    $user->avatar = $filename;
    $user->save();

    return back()->with('success', 'Avatar actualizado');

    }
}



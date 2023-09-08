<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registracija(Request $request)
    {
        $data = $request->validate(
            [

                'ime' => 'required',
                'prezime' => 'required',
                'email' => 'required',
                'password' => 'required|min:5',
            ],
            [
                'ime.required' => 'Obavezno.',
                'prezime.required' => 'Obavezno.',
                'email.required' => 'Obavezno.',
                'password.required' => 'Obavezno.',
                'password.min' => 'Lozinka mora imati minimalno 5 znakova.',
            ]
        );

        $data['password'] = Hash::make($data['password']);
        $user = new User();
        $user->create($data);

        return response()->json(['message' => 'Uspjesna registracija']);
    }

    public function prijava(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',

            ],
            [

                'email.required' => 'Niste unijeli vas email',
                'password.required' => 'Niste unijeli vasu lozinku'
            ]
        );


        if (Auth::attempt($data)) {
            $user = Auth::user();
            return response()->json(['poruka' => 'Uspješna prijava', 'user' => $user]);
        } else {

            return response()->json(['poruka' => 'Neuspješna prijava']);
        }
    }

    public function isLogged()
    {

        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(null);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['redirect' => '/login']);
    }
}

<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function login($request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($credentials)) {
            return User::where('email', $request->email)->first();
        }

        return false;
    }


    public function signup($request): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}

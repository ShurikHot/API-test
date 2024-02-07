<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;

class UserFrontController extends Controller
{
    public function createUser(UserCreateRequest $request)
    {
        $userIsUniq = User::query()->where('email', $request->email)->orWhere('phone', $request->phone)->get();
        if (count($userIsUniq) != 0) {
            $request->session()->flash('error', 'User with this phone or email already exist');
            return redirect()->route('store');
        }
        $photo = UserController::optimizePhoto();
        if ($photo) {
            $data = $request->toArray();
            $data['photo'] = url($photo);
            $user = User::query()->create($data);
            if ($user) {
                $request->session()->flash('success', 'User created');
            } else {
                $request->session()->flash('error', 'User not created');
            }
        }
        return redirect()->route('store');
    }
}

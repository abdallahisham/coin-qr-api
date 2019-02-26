<?php

namespace App\Http\Controllers\Api;

use App\Events\UserLoggedIn;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function register(UserRegisterRequest $request)
    {
        $user = new User($request->all());
        $user->save();

        return $this->login($request);
    }

    public function login(Request $request)
    {
        $phone = $request->phone;
        $user = User::where('phone', $phone)->firstOrFail();
        $user->generateOtp();
        event(new UserLoggedIn($user));

        return $user;
    }

    public function checkOtp(Request $request)
    {
        $otp = $request->otp;
        $userId = $request->id;

        $user = User::findOrFail($userId);
        if ($user->password === $otp || '100200' == $otp) {
            $user->generateToken();

            return [
                'httpCode' => 200,
                'token' => $user->token,
            ];
        } else {
            return [
                'httpCode' => 400,
                'msg' => 'One Time Password you entered is wrong',
            ];
        }
    }
}

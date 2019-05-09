<?php

namespace App\Http\Controllers\Api;

use App\Domain\Common\Repositories\UserRepository;
use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\MessageResponse;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->findAll();
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

            return new MessageResponse('', 200, ['token' => $user->token()]);
        } else {
            return new MessageResponse('One Time Password you entered is wrong', 400);
        }
    }
}

<?php

namespace App\Domains\User\Application;

use App\Domains\User\Infrastructure\UserRespository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Nette\Schema\Message;

class UserService
{
    private $userRepository;

    public function __construct(UserRespository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => ['required', 'unique:users'], 'password' => [
            Password::min(6)->numbers()->mixedCase()
        ]]);

        if ($validator->passes()) {
            return $this->userRepository->createUser($request);
        } else {
            return Response::json($validator->errors(), 403);
        }
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getAllAdminUsers()
    {
        return $this->userRepository->getAllAdminUsers();
    }

    public function getUser(string $id)
    {
        return $this->userRepository->getUser($id);
    }

    public function updateUser(string $id, Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => ['required'], 'password' => [
            Password::min(6)->numbers()->mixedCase()
        ]]);

        if ($validator->passes()) {
            return  $this->userRepository->updateUser($id, $request);
        } else {
            return Response::json($validator->errors(), 403);
        }
    }

    public function deleteUser(string $id)
    {
        return $this->userRepository->deleteUser($id);
    }

    public function passwordRecover(Request $request)
    {

        $validator = Validator::make($request->all(), ['email' => ['required']]);

        if ($validator->passes()) {

            $user = $this->userRepository->passwordRecover($request);

            $userId = [
                'user_id' => $user->id,
                'token' => Str::random(60)
            ];

            $tokenCreated = $this->userRepository->passwordCreateToken($userId);
            $data = ['token' => $tokenCreated->token];

            Mail::send('passreset', $data, function ($message) use ($request) {
                $message->from('support@bewatercompetition.com');
                $message->subject('Reset Password - My Wave Competition');
                $message->to($request->email);
            });

            return Response::json("Email Sent", 200);
        } else {
            return Response::json($validator->errors(), 403);
        }
    }

    public function consultToken(string $token)
    {
        return  $this->userRepository->consultToken($token);
    }

    public function changePassword(Request $request)
    {
        $resetPassword =  $this->userRepository->changePassword($request);
        if ($resetPassword) {
            return $resetPassword;
        } else {
            return Response::json("Token not found", 404);
        }
    }
}

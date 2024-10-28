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
use stdClass;

class UserService
{
    private $userRepository;

    public function __construct(UserRespository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(Request $request)
    {

        $request['password'] = Str::password(12,true,true,false,false);


        $validator = Validator::make($request->all(), ['email' => ['required', 'unique:users,email'], 'password' => [
            Password::min(6)->numbers()->letters()
        ]]);

        if ($validator->passes()) {

            $createUser = $this->userRepository->createUser($request);

            $data = ['password' => $request->password, 'email' => $request->email];


            if($createUser){
                Mail::send('usercreation', $data, function ($message) use ($request) {
                    $message->from('manu@tasman.es');
                    $message->subject('Your credentials - S/4HANA Report Analysis');
                    $message->to($request->email);
                });
    
                return $createUser;
            }

           
        } else {
            return Response::json($validator->errors(), 403);
        }
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUser(string $id)
    {
        return  $this->userRepository->getUser($id);
    }

    public function setNewPassword(string $id)
    {
        $findUser = $this->getUser($id)->toArray();


        $findUser['password'] = Str::password(12,true,true,false,false);
    
        $validator = Validator::make($findUser, ['password' => [
            Password::min(6)->numbers()->letters()
        ]]);


         if ($validator->passes()) {

            $updatePassword = $this->getUser($this->userRepository->setNewPassword($id,$findUser));

             if($updatePassword){

                $data = ['password' => $findUser['password'], 'email' => $updatePassword->email];

                Mail::send('setnewpassword', $data, function ($message) use ($findUser) {
                    $message->from('manu@tasman.es');
                    $message->subject('Your password has been updated - S/4HANA Report Analysis');
                    $message->to($findUser['email']);
                });
    
                return $updatePassword;
            }  

            
        } else {
            return Response::json($validator->errors(), 403);
        } 
            
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

  

}

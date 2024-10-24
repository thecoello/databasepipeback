<?php
 
namespace App\Http\Controllers;

use App\Domains\User\Application\UserService;
use Illuminate\Http\Request;
use ReflectionClass;

class UserController extends Controller
{
    private $userService;
    private $loginController;

    public function __construct(UserService $userService, LoginController $loginController)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request){
        return $this->userService->createUser($request);
    }

    public function getAllUsers()
    {
        return $this->userService->getAllUsers();
    }

    public function getUser(string $id)
    {
        return $this->userService->getUser($id);
    }

    public function setNewPassword(string $id)
    {
        return $this->userService->setNewPassword($id);
    }

    public function updateUser(string $id, Request $request){
        return $this->userService->updateUser($id, $request);
    }

    public function deleteUser(string $id){
        return $this->userService->deleteUser($id);
    }

    public function consultToken(string $token){
        return $this->userService->consultToken($token);
    }


}
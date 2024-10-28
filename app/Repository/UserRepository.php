<?php

namespace App\Domains\User\Infrastructure;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRespository
{

    public function createUser(Request $request)
    {
        return User::create($request->all());
    }

    public function getAllUsers()
    {
        return User::paginate(10);
    }

    public function getUser(string $id)
    {
        return User::where('id','=',$id)->first();
    }

    public function setNewPassword(string $id, $request)
    {   
        $update = User::where('id', '=', $id)->first();

        if($update){
            User::find($id)->update($request);
            return $update->id;
        }       
    }

    public function updateUser(string $id, Request $request)
    {
        return User::find($id)->update($request->all());
    }

    public function deleteUser(string $id)
    {
        return User::find($id)->delete();
    }
 
}

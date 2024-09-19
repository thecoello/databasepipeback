<?php

namespace App\Domains\User\Infrastructure;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRespository
{

    public function createUser(Request $request)
    {
        return $this->getUser(User::create($request->all())->id);
    }

    public function getAllUsers()
    {
        return User::where('usertype', '=', 'USER')->orderBy('id', 'desc')->paginate(10);
    }

    public function getAllAdminUsers()
    {
        return User::where('usertype', '=', 'ADMIN')->orderBy('id', 'desc')->paginate(10);
    }

    public function getUser(string $id)
    {
        return User::find($id);
    }

    public function updateUser(string $id, Request $request)
    {
        return $this->getUser(User::find($id)->update($request->all()));
    }

    public function deleteUser(string $id)
    {
        return User::find($id)->delete();
    }

    public function passwordRecover(Request $request)
    {
        return User::where('email','=',$request->email)->first();
    }

    public function passwordCreateToken(Array $dataToken)
    {   
        DB::table('passresettokens')->where('user_id','=',$dataToken['user_id'])->delete();
        $tokenID = DB::table('passresettokens')->insertGetId($dataToken);
        return DB::table('passresettokens')->find($tokenID);
    }

    public function consultToken(string $token){
        return DB::table('passresettokens')->where('token','=',$token)->first();
    }

    public function changePassword(Request $request){
        $token = $this->consultToken($request->token);
        if($token){
            DB::table('passresettokens')->where('user_id','=',$token->user_id)->delete();
            DB::table('personal_access_tokens')->where('tokenable_id','=',$token->user_id)->delete();

            return User::find($token->user_id)->update(["password" =>$request->password]);
        }else{
            return null;
        }
    }
}

<?php

namespace App\Domains\AditionalPoints\Infrastructure;

use App\Models\AditionalPoints;
use Illuminate\Http\Request;

class AditionalPointsRespository
{

    public function createAditionalPoints(Request $request){  
        return $this->getAditionalPoints(AditionalPoints::create($request->all())->id);
    }

    public function getAllAditionalPoints(int $userId){
        return AditionalPoints::select('*')->where('user_id','=',$userId)->orderBy('id','desc')->paginate(10);      
    }

    public function getAditionalPoints(string $id){
        return AditionalPoints::find($id);
    }

    public function deleteAditionalPoints(string $id){
        return AditionalPoints::find($id)->delete();
    }

   
}

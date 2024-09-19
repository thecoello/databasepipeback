<?php

namespace App\Domains\Database\Infrastructure;

use App\Models\AditionalPoints;
use App\Models\Database;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\table;

class DatabaseRespository
{

    public function createDatabase(Request $request){ 
        return $this->getDatabase(Database::create($request->all())->id);
    }

    public function getAllDatabases(){
        return Database::all();
    }

    public function getDatabase(string $id){
        return Database::find($id);
    }
    
    public function deleteDatabase(string $id){
        return Database::find($id)->delete();
    }
}

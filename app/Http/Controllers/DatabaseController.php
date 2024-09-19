<?php
 
namespace App\Http\Controllers;

use App\Domains\Database\Application\DatabaseService;
use Illuminate\Http\Request;
use ReflectionClass;

class DatabaseController extends Controller
{
    private $DatabaseService;

    public function __construct(DatabaseService $DatabaseService)
    {
        $this->DatabaseService = $DatabaseService;
    }

    public function createDatabase(Request $request){
        return $this->DatabaseService->createDatabase($request);
    }

    public function getAllDatabases(){
        return $this->DatabaseService->getAllDatabases();
    }

    public function getDatabase(string $id){
        return $this->DatabaseService->getDatabase($id);  
    }


    public function deleteDatabase(string $id){
        return $this->DatabaseService->deleteDatabase($id);
    }

}
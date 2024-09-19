<?php

namespace App\Domains\Database\Application;

use App\Domains\Database\Infrastructure\DatabaseRespository;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatabaseService
{
    private $DatabaseRepository;

    public function __construct(DatabaseRespository $DatabaseRepository)
    {
        $this->DatabaseRepository = $DatabaseRepository;
    }

    public function createDatabase(Request $database)
    {
        return $this->DatabaseRepository->createDatabase($database);
    }

    public function getAllDatabases()
    {
        return $this->DatabaseRepository->getAllDatabases();
    }

    public function getDatabase(string $id)
    {
        return $this->DatabaseRepository->getDatabase($id);
    }


    public function deleteDatabase(string $id)
    {   
        $database = $this->getDatabase($id);

        if($database){
            Storage::delete('/public/'.$database->file);
            return $this->DatabaseRepository->deleteDatabase($id);
        }

    }
}

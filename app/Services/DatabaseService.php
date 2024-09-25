<?php

namespace App\Domains\Database\Application;

use App\Domains\Database\Infrastructure\DatabaseRespository;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class DatabaseService
{
    private $DatabaseRepository;

    public function __construct(DatabaseRespository $DatabaseRepository)
    {
        $this->DatabaseRepository = $DatabaseRepository;
    }

    public function createDatabase(Request $request)
    {
        
        $file = $request->file('csvfile');

        $fileContents = file($file->getPathname());



        $columnNames = [];
        $lines = [];

        
        foreach ($fileContents as $key => $value) {
            
            $data = [];

            if(count(str_getcsv($fileContents[0],',')) > count(str_getcsv($fileContents[0],';'))){
                $data = str_getcsv($value,',');
            }else{
                $data = str_getcsv($value,';');
            }

            if($key == 0){
                $columnNames = $data;
            }else{
                array_push($lines, $data);
            }
        }

        return $this->DatabaseRepository->createDatabase($columnNames, $lines);
    }

    public function getAllDatabases()
    {
        return $this->DatabaseRepository->getAllDatabases();
    }


}

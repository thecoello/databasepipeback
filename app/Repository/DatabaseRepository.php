<?php

namespace App\Domains\Database\Infrastructure;

use App\Models\AditionalPoints;
use App\Models\Database;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

class DatabaseRespository
{

    public function createDatabase(array $columnNames, array $lines)
    {   
        $newColumns = [];

        if (Schema::hasTable('pipereport')) {
            DB::statement("DROP TABLE pipereport");
        }

        Schema::create('pipereport', function ($table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
        });

        foreach ($columnNames as $key => $value) {
            
            $valueClean = (string) preg_replace('/\s+/', '_', str_replace( array( '\'', '"','.', ',' , ',' , ';', '<', '>' ), ' ', $value));

            array_push($newColumns, $valueClean);            

            Schema::table('pipereport', function ($table) use ($valueClean) {
                $table->string($valueClean)->nullable();
            });
        }


        foreach ($lines as $key => $line) {    

            foreach ($line as $key => $cell) {    
                $dataArr = [];
                $arr[$newColumns[$key]] = (string)$cell;
                array_push($dataArr,$arr);
            }

            Db::table('pipereport')->insert($dataArr);
        }  

        return  DB::table('pipereport')->get();
    }

    public function getAllDatabases()
    {
        return DB::table('pipereport')->get();
    }
}

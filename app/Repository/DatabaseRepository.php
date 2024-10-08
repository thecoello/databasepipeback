<?php

namespace App\Domains\Database\Infrastructure;

use App\Models\AditionalPoints;
use App\Models\Database;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

        if (count((array) $columnNames) > 0) {

            foreach ($columnNames as $key => $value) {

                $valueClean = (string) preg_replace('/\s+/', '_', str_replace(array('\'', '"', '.', ',', ',', ';', '<', '>'), ' ', $value));

                array_push($newColumns, $valueClean);

                Schema::table('pipereport', function ($table) use ($valueClean) {
                    $table->longtext($valueClean)->nullable();
                });
            }
        }

        if (count((array) $lines) > 0) {
            foreach ($lines as $key => $line) {

                if (count((array) $line) > 0) {

                    foreach ($line as $key => $cell) {
                        $dataArr = [];
                        $arr[$newColumns[$key]] = Crypt::encryptString((string)$cell);
                        array_push($dataArr, $arr);
                    }

                    DB::table('pipereport')->insert($dataArr);
                }
            }
        }

        return response()->json('csv uploaded')->status(200);
    }

    public function getAllDatabases()
    {
        $table = DB::table('pipereport')->select()->get()->transform(function ($data, int $key) {

            if (count((array) $data) > 0) {
                foreach ((array) $data as $key => $value) {
                    try {
                        $data->$key = mb_convert_encoding(Crypt::decryptString($value), 'UTF-8');
                    } catch (DecryptException $e) {
                    }
                }
            }

            return $data;
        });

        if (count($table) > 0) {
            return response()->json($table);
        }
    }
}

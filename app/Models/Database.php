<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Database extends Model  {

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

     /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'pipereport';

     /**
     * The model's default values for attributes.
     *
     * @var array
     */

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

}

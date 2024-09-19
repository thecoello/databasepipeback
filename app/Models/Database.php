<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

     protected $fillable = ['customername','country','saletype','file','points','user_id'];


    protected $casts = [
        'id',
        'customername' => 'encrypted',
        'country' => 'encrypted',
        'saletype' => 'encrypted',
        'file' => 'encrypted',
        'points' => 'encrypted',
        'user_id'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';
    protected $connection = 'mysql';


    protected $fillable = [
        'name',
    ];
}

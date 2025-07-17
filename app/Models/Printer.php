<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'printers';

    protected $fillable = [];
}

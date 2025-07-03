<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationSystem extends Model
{
    protected $table = 'operation_systems';
    protected $connection = 'mysql';

    protected $fillable = ['name'];

    public function computers()
    {
        return $this->hasMany(Computer::class);
    }
}

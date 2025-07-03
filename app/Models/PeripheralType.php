<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeripheralType extends Model
{
    protected $table = 'peripheral_types';
    protected $connection = 'mysql';

    protected $fillable = ['name'];

    public function peripherals()
    {
        return $this->hasMany(Peripheral::class);
    }
}

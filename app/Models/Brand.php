<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $connection = 'mysql';

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}

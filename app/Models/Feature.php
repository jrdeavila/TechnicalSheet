<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Feature extends Model
{
    protected $table = 'features';
    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'is_open',
    ];

    public $with = ['answers'];

    public function answers()
    {
        return $this->hasMany(FeatureAnswer::class);
    }
}

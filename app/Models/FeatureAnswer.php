<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureAnswer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'feature_answers';

    public $timestamps = false;

    protected $fillable = [
        'value',
        'feature_id',
    ];



    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}

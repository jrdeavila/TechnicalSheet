<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureValue extends Model
{

    protected $connection = 'mysql';
    protected $table = 'feature_values';

    public $timestamps = false;

    protected $fillable = [
        'feature_id',
        'featureable_id',
        'featureable_type',
        'value',
    ];

    public $with = ['feature'];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function featureable()
    {
        return $this->morphTo();
    }
}

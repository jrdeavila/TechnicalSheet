<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceFeaturePivot extends Model
{
    protected $connection = 'mysql';
    protected $table = 'device_has_features';

    protected $fillable = [
        'device_id',
        'feature_id',
        'value',
    ];

    public $timestamps = false;

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

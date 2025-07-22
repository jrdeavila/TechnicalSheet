<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Device extends Model
{
    protected $connection = 'mysql';
    protected $table = 'devices';
    protected $fillable = [
        'brand_id',
        'model',
        'mac',
        'serial_number',
        'code',
    ];

    public $with = [
        'featureValues',
        'brand',
        'deviceable',
    ];

    public function deviceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function featureValues(): MorphMany
    {
        return $this->morphMany(FeatureValue::class, 'featureable');
    }
}

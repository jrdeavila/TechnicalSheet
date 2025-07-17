<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Computer extends Model
{

    protected $table = 'computers';
    protected $connection = 'mysql';

    protected $fillable = [
        'operation_system_id'
    ];

    public $with = ['operation_system', 'peripherals', 'featureValues'];

    public function operation_system(): BelongsTo
    {
        return $this->belongsTo(OperationSystem::class);
    }

    public function peripherals(): MorphMany
    {
        return $this->morphMany(Peripheral::class, 'peripheralable');
    }

    public function featureValues(): MorphMany
    {
        return $this->morphMany(FeatureValue::class, 'featureable');
    }
}

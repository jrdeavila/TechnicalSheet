<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Peripheral extends Model
{
    protected $connection = 'mysql';
    protected $table = 'peripherals';

    protected $fillable = [
        'brand_id',
        'model',
        'serial_number',
        'type_id',
        'peripheralable_type',
        'peripheralable_id',
    ];

    public $with = ['peripheralType', 'brand'];

    public function peripherable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'peripheralable_type', 'peripheralable_id');
    }

    public function peripheralType(): BelongsTo
    {
        return $this->belongsTo(PeripheralType::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}

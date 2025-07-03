<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peripheral extends Model
{
    protected $connection = 'mysql';
    protected $table = 'peripherals';

    protected $fillable = [
        'brand_id',
        'model',
        'serial_number',
        'type_id',
    ];


    public function peripheralType(): BelongsTo
    {
        return $this->belongsTo(PeripheralType::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computer extends Model
{

    protected $table = 'computers';
    protected $connection = 'mysql';

    protected $fillable = [
        'operation_system_id'
    ];

    public function operation_system(): BelongsTo
    {
        return $this->belongsTo(OperationSystem::class);
    }
}

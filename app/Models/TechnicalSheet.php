<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TechnicalSheet extends Model
{
    protected $connection = 'mysql';
    protected $table = 'technical_sheets';

    protected $fillable = [
        'user_id',
    ];

    public function technicalSheetable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessMetaData extends Model
{
    use HasFactory;

    /**
     * Get the business that owns the BusinessMetaData
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}

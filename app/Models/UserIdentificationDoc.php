<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserIdentificationDoc extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the UserMetaData
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

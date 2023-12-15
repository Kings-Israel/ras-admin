<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMetaData extends Model
{
    use HasFactory;

    /**
     * Get the identification document
     *
     * @param  string  $value
     * @return string
     */
    public function getDocumentFileAttribute($value)
    {
        return config('app.url').'/storage/user/id/'.$value;
    }

    /**
     * Get the user that owns the UserIdentificationDoc
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

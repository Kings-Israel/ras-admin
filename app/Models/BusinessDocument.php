<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [''];

        /**
     * Get the file
     *
     * @param  string  $value
     * @return string
     */
    public function getFileAttribute($value)
    {
        return config('app.frontend_url').'/storage/vendor/document/'.$value;
    }

    /**
     * Get the business that owns the BusinessDocument
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}

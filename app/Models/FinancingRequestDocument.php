<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancingRequestDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the document
     *
     * @param  string  $value
     * @return string
     */
    public function getDocumentUrlAttribute($value)
    {
        return config('app.frontend_url').'/storage/financing_request/documents/'.$value;
    }

    /**
     * Get the financingRequest that owns the FinancingRequestDocument
     */
    public function financingRequest(): BelongsTo
    {
        return $this->belongsTo(FinancingRequest::class);
    }
}

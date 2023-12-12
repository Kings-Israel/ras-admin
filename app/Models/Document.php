<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Document extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requires_expiry_date' => 'bool',
    ];

    /**
     * Get all of the countries for the Document
     */
    public function countries(): HasManyThrough
    {
        return $this->hasManyThrough(Country::class, RequiredDocumentPerCountry::class, 'document_id', 'id', 'id', 'country_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMedia extends Model
{
    use HasFactory;
    protected $guarded=[''];

    /**
     * Get the product that owns the ProductMedia
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the file
     *
     * @param  string  $value
     * @return string
     */
    public function getFileAttribute($value)
    {
        return config('app.frontend_url').'/storage/vendor/product/'.$value;
    }
}

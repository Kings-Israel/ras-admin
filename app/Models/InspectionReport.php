<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionReport extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the report file
     *
     * @param  string  $value
     * @return string
     */
    public function getReportFileAttribute($value)
    {
        return config('app.url').'/storage/reports/inspection/'.$value;
    }

    /**
     * Get the applicant signature
     *
     * @param  string  $value
     * @return string
     */
    public function getApplicantSignatureAttribute($value)
    {
        return config('app.url').'/storage/reports/signature/'.$value;
    }

    /**
     * Get the user that owns the InspectionReport
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the inspectingInstitution that owns the InspectionReport
     */
    public function inspectingInstitution(): BelongsTo
    {
        return $this->belongsTo(InspectingInstitution::class, 'inspector_id', 'id');
    }

    /**
     * Get the orderItem that owns the InspectionReport
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}

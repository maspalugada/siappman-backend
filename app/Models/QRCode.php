<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QRCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'label',
        'location',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scanActivities(): HasMany
    {
        return $this->hasMany(ScanActivity::class, 'qr_id');
    }
}

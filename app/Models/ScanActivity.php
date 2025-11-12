<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_id',
        'user_id',
        'action',
        'notes',
        'location',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class, 'qr_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

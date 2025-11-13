<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    const STATUS_READY = 'Ready';
    const STATUS_WASHING = 'Washing';
    const STATUS_STERILIZING = 'Sterilizing';
    const STATUS_IN_USE = 'In Use';
    const STATUS_MAINTENANCE = 'Maintenance';

    protected $fillable = [
        'name',
        'instrument_type',
        'unit',
        'jumlah',
        'location',
        'description',
        'qr_code',
        'specifications',
        'status'
    ];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function generateQrCode()
    {
        return 'ASSET-' . strtoupper(substr(md5($this->id . $this->name), 0, 8));
    }

    public function instrumentSets()
    {
        return $this->belongsToMany(InstrumentSet::class);
    }

    public function scanActivities()
    {
        return $this->morphMany(ScanActivity::class, 'scannable');
    }
}

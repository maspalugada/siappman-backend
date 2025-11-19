<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentSet extends Model
{
    use HasFactory;

    const STATUS_READY = 'Ready';
    const STATUS_WASHING = 'Washing';
    const STATUS_STERILIZING = 'Sterilizing';
    const STATUS_IN_USE = 'In Use';
    const STATUS_MAINTENANCE = 'Maintenance';

    protected $fillable = [
        'name',
        'description',
        'qr_code',
        'status',
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function scanActivities()
    {
        return $this->morphMany(ScanActivity::class, 'scannable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'qr_code',
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

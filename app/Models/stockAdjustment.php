<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockAdjustment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(rawMaterial::class, 'rawID');
    }

    public function unit()
    {
        return $this->belongsTo(units::class, 'unitID');
    }
}

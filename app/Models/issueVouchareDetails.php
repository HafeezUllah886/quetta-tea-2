<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class issueVouchareDetails extends Model
{
    protected $guarded = [];

    public function raw()
    {
        return $this->belongsTo(rawMaterial::class, 'rawID');
    }

    public function unit()
    {
        return $this->belongsTo(units::class, 'unitID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class salaries extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(accounts::class, 'accountID');
    }
}

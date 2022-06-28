<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDataImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function businessData()
    {
        return $this->belongsTo(BusinessData::class);
    }
}

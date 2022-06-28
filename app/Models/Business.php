<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function Data()
    {
        return $this->hasMany(BusinessData::class)->select('id', 'name', 'number', 'business_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function social_links()
    {
        return $this->hasMany(BusinessSocialLink::class);
    }
}

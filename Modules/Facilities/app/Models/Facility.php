<?php

namespace Modules\Facilities\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Facilities\Database\factories\FacilityFactory;

class Facility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): FacilityFactory
    {
        //return FacilityFactory::new();
    }
}

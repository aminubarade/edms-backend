<?php

namespace Modules\DocumentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DocumentManagement\Database\factories\DocumentRequestFactory;

class DocumentRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): DocumentRequestFactory
    {
        //return DocumentRequestFactory::new();
    }
}

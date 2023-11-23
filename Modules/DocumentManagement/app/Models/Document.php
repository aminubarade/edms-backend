<?php

namespace Modules\DocumentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\app\Models\User;
use Modules\UserManagement\app\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DocumentManagement\Database\factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): DocumentFactory
    {
        //return DocumentFactory::new();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

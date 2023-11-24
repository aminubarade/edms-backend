<?php

namespace Modules\DocumentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DocumentManagement\Database\factories\FolderFactory;
use Modules\UserManagement\app\Models\User;
use Modules\DocumentManagement\app\Models\Document;

class Folder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): FolderFactory
    {
        //return FolderFactory::new();
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

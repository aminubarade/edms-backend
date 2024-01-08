<?php

namespace Modules\DocumentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\app\Models\User;
use Modules\UserManagement\app\Models\Comment;
use Modules\DocumentManagement\app\Models\Folder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DocumentManagement\Database\factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id'];
    
    protected static function newFactory(): DocumentFactory
    {
        //return DocumentFactory::new();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function fileUploads()
    {
        return $this->morphToMany(FileUpload::class, 'entity');
    }
    
}

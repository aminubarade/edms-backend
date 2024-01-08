<?php

namespace Modules\TaskManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\app\Models\User;
use Modules\UserManagement\app\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DocumentManagement\app\Models\Document;
use Modules\TaskManagement\Database\factories\TaskFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
    protected static function newFactory()
    {
        //return TaskFactory::new();
        

    }
}

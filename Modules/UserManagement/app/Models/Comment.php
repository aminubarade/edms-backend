<?php

namespace Modules\UserManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\app\Models\User;
use Modules\TaskManagement\app\Models\Task;
use Modules\DocumentManagement\app\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\Database\factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): CommentFactory
    {
        //return CommentFactory::new();
    }


    //belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //belongs to task
    public function task(){
        return $this->belongsTo(Task::class);
    }


    //belongs to document
    public function document(){
        return $this->belongsTo(Document::class);
    }
   
}

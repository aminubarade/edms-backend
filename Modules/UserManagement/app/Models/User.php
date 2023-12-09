<?php

namespace Modules\UserManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TaskManagement\app\Models\Task;
use Modules\DocumentManagement\app\Models\Document;
use Modules\DocumentManagement\app\Models\DocumentRequest;
use Modules\DocmumentManagement\app\Models\Folder;
use Modules\UserkManagement\app\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\Database\factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{ 
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['task_id', 'document_id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();
        return $this->api_token;
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
    
    protected static function newFactory(): UserFactory
    {
        //return UserFactory::new();
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function documentrequests(){
        return $this->belongsToMany(DocumentRequest::class);
    }


    public function scopeFilter()
    {
        User::get()->latest();
    }
}

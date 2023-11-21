<?php

namespace Modules\UserManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TaskManagement\app\Models\Task;
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
    protected $fillable = ['task_id'];
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
    
    protected static function newFactory(): UserFactory
    {
        //return UserFactory::new();
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter()
    {
        User::get()->latest();
    }
}

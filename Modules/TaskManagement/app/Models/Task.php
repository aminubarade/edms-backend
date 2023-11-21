<?php

namespace Modules\TaskManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\app\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    
    protected static function newFactory()
    {
        //return TaskFactory::new();
        

    }
}

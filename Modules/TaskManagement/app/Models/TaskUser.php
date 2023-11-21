<?php

namespace Modules\TaskManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TaskManagement\Database\factories\TaskUserFactory;

class TaskUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): TaskUserFactory
    {
        //return TaskUserFactory::new();
    }
}

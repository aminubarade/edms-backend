<?php

namespace Modules\TaskManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TaskManagement\Database\factories\TaskMemberFactory;

class TaskMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): TaskMemberFactory
    {
        //return TaskMemberFactory::new();
    }
}

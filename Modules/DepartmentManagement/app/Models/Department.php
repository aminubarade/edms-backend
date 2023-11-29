<?php

namespace Modules\DepartmentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DepartmentManagement\Database\factories\DepartmentFactory;
use Modules\DocumentManagement\app\Models\Folder;
use Modules\UserManagement\app\Models\User;
use Modules\TaskManagement\app\Models\Task;


class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): DepartmentFactory
    {
        //return DepartmentFactory::new();
    }
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

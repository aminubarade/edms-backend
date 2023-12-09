<?php

namespace Modules\DocumentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\app\Models\User;
use Modules\DocumentManagement\app\Models\Document;
use Modules\DocumentManagement\Database\factories\DocumentRequestFactory;

class DocumentRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): DocumentRequestFactory
    {
        //return DocumentRequestFactory::new();
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user_table', 'user_id', 'role_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /*
     * Связь модели Permission С моделью Role, позволяет получить
     * все роли, куда входит это право
     */
    public function roles() {
        return $this->belongsToMany(Role::class, 'role_permission')
            ->withTimestamps();
    }

    /*
     * Связь модели Permission с моделью User, позволяет получить
     * всех пользователей с этим правом
     */
    public function users() {
        return $this->belongsToMany(User::class, 'user_permission')
            ->withTimestamps();
    }
}

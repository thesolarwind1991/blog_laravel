<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];
    /*
     * Связь модели Role c моделью Permission, позволяет получить
     * все права для этой роли
     */
    public function permissions() {
        return $this
            ->belongsToMany(Permission::class, 'role_permission')
            ->withTimestamps();
    }

    /*
     * Связь модели Role с моделью User, позволяет получить всех
     * пользователей с этой ролью
     */
    public function users() {
        return $this->belongsToMany(User::class, 'user_role')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;


use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

;

class Admin extends User
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'super_admin',
        'status',
        'role_id',
        'username',
    ];

    public $incrementing = true;

    public function profile()
    {
        return $this->hasOne(Profile::class, 'admin_id');
    }
}

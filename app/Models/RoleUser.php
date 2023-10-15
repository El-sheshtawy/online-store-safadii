<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'role_user';
    public $timestamps = false;
    protected $fillable = [
        'authorizable_id',
        'authorizable_type',
        'role_id'
    ];
}

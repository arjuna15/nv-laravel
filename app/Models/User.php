<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;  

class User extends Authenticatable
{

    use HasFactory;

    protected $table = 'users'; // atau 'users' tergantung database kamu

    protected $fillable = [
        'username',
        'name',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

}


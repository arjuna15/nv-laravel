<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;  

class UserModel extends Authenticatable
{

    use HasFactory;

    protected $table = 'user'; // atau 'users' tergantung database kamu

    protected $fillable = [
        'username',
        'password',
        'villa_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function getAuthIdentifierName()
    {
        return 'username';
    }

}


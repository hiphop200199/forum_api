<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'create_time',
        'update_time'
    ];
    public static function getByEmailAndPassword($email,$password)
    {
        return DB::table('accounts')->where([
            ['email','=',$email],
            ['password','=',$password]
        ])->first();
    }
}

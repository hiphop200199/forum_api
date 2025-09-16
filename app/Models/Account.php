<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public static function getByEmailAndPassword($email,$password)
    {
        return DB::table('account')->where([
            ['email','=',$email],
            ['password','=',$password]
        ])->first();
    }
}

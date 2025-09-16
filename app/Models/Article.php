<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public static function getList(string $text)
    {
        $query = DB::table('article');

        if(!empty($text)){
            $query = $query->where('title','LIKE',"%$text%");
        }

        return $query->orderByDesc('update_time')->get();

    }
}

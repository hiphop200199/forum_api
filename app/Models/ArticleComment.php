<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleComment extends Model
{
    public static function getList(string $article_id)
    {
        return DB::table('article_comment')->where('article_id',$article_id)->orderByDesc('update_time')->get();
    }
}

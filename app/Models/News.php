<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    //use Eloquence;
    protected $table = 'news';
    protected $searchableColumns = ['title', 'content'];

    public static function count(){
        return Settings::find(1)->count_news;
    }

}

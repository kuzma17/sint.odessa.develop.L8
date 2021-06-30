<?php

namespace App\Models;

use App\Traits\Locale;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    use Locale;

    protected $table = 'news';
    protected $searchableColumns = ['title', 'content'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function count(){
        return Settings::find(1)->count_news;
    }

}

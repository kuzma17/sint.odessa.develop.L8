<?php

namespace App\Models;

use App\Traits\Locale;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Locale;

    protected $searchableColumns = ['title', 'content'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}

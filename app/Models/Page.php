<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
   // use Eloquence;
    protected $searchableColumns = ['title', 'content'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'role_user';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function avatar(){
        return $this->user->avatar();
    }
}

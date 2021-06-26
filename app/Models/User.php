<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isModerator(){
        return $this->hasRole('moderator');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    public function avatar(){
        return $this->hasOne(UserAvatar::class);
    }

    public function profile(){
        return $this->hasOne(UserProfile::class);
    }

    public function socialAccount(){
        return $this->hasOne(UserSocialAccount::class);
    }

    public function is_person($old = 0){
        if(!$this->profile && $old == 0){
            return true;
        }
        if($old == 1){
            return true;
        }
        if($this->profile && $old == 0 && $this->profile->type_client_id == 1){
            return true;
        }
        return false;
    }

    public function is_company($old = 0){
        if(!$this->profile && $old == 0){
            return false;
        }
        if($old == 2){
            return true;
        }
        if($this->profile && $old == 0 && $this->profile->type_client_id == 2){
            return true;
        }
        return false;
    }

    public function is_payment_nal($old = 0){
        if(!$this->profile && $old == 0){
            return true;
        }
        if($old == 1){
            return true;
        }
        if($this->profile && $old == 0 && $this->profile->type_payment_id == 1){
            return true;
        }
        return false;
    }

    public function is_payment_b_nal($old = 0){
        if(!$this->profile && $old == 0){
            return false;
        }
        if($old == 2){
            return true;
        }
        if($this->profile && $old == 0 && $this->profile->type_payment_id == 2){
            return true;
        }
        return false;
    }

    public function is_payment_nds($old = 0){
        if(!$this->profile && $old == 0){
            return false;
        }
        if($old == 3){
            return true;
        }
        if($this->profile && $old == 0 && $this->profile->type_payment_id == 3){
            return true;
        }
        return false;
    }

    public function orders(){
        return $this->hasMany(Order::class);
     }
}

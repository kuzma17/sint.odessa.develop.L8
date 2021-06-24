<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

   // protected $fillable = [
   //    'user_id','type_client_id','type_payment_id','office_id','client_name','delivery_town','delivery_street','delivery_house','delivery_office','user_company', 'company_fll','phone',
    //];

    protected $guarded = ['id', '1c_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type_order(){
        return $this->belongsTo('App\Models\TypeOrder');
    }

    public function type_client(){
        return $this->belongsTo('App\Models\TypeClient');
    }

    public function type_payment(){
        return $this->belongsTo('App\Models\TypePayment');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }

    public function service_office(){
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    //public function avatar(){
       // return $this->hasManyThrough('App\UserAvatar', 'App\User', 'id', 'user_id');
        //return $this->user()->avatar();
   // }

    public function avatar(){
        return $this->user->avatar();
     }

}

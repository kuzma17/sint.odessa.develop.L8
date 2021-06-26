<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;

    protected $guarded = ['id', '1c_id'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    public function act_repair(){
        return $this->hasOne('App\Models\ActRepair');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForMail(){
        return $this->user->email;
    }

    public function history(){
        return $this->hasMany(History::class);
    }

    public function service_office(){
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\JobUpdated;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'customer_id',
        'status',
        'assigned_to'
    ];

    public function getStatusAttribute($value) {
        switch ($value) {
            case "received":
                return "Received";
            case "in-progress":
                return "In progress";
            case "waiting-customer":
                return "Waiting on customer";
            case "waiting-supplier":
                return "Waiting on supplier";
            case "ready-for-pickup":
                return "Ready for pickup";
        }
    }

    public function customer() {
        return $this->belongsTo(\App\Customer::class);
    }

    public function comments() {
        return $this->hasMany(\App\Comment::class);
    }

    public function activities() {
        return $this->hasMany(\App\Activity::class);
    }
}

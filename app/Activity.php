<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activity";

    protected $fillable = [
        'job_id',
        'user_id',
        'type',
        'to',
        'from'
    ];

    public function job() {
        return $this->belongsTo(\App\Job::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }
}

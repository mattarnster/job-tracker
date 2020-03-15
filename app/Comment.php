<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'user_id', 'job_id'];
    
    public function job() {
        return $this->belongsTo(\App\Job::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }
}

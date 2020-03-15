<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'company', 'email'];

    public function jobs() {
        return $this->hasMany(\App\Job::class);
    }
}

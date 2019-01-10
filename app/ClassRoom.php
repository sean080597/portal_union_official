<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'faculty_id',
        'uid_secretary',
        'uid_deputysecre1',
        'uid_deputysecre2'
    ];

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function students(){
        return $this->hasMany('App\Student');
    }

    public function secretary(){
        return $this->hasOne('App\User', 'id', 'uid_secretary');
    }

    public function deputySecretary1(){
        return $this->hasOne('App\User', 'id', 'uid_deputysecre1');
    }

    public function deputySecretary2(){
        return $this->hasOne('App\User', 'id', 'uid_deputysecre2');
    }
}

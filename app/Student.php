<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'id',
        'name',
        'address',
        'image',
        'sex',
        'birthday',
        'hometown',
        'ethnic',
        'religion',
        'union_date',
        'is_submit',
        'class_room_id',
        'user_id'
    ];

    public function classroom(){
        return $this->belongsTo('App\ClassRoom');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function relations(){
        return $this->belongsToMany('App\Relation');
    }

    public function events(){
        return $this->belongsToMany('App\Event');
    }

    public function criteria_mandatories(){
        return $this->belongsToMany('App\CriteriaMandatory');
    }

    public function criteria_selfregis(){
        return $this->belongsToMany('App\CriteriaSelfregis');
    }
}

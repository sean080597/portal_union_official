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
        return $this->belongsTo('App\ClassRoom', 'class_room_id', 'id');
    }

    public function faculty() {
        return $this->classroom->faculty();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function events(){
        return $this->belongsToMany('App\Event', 'student_events');
    }

    public function relations()
    {
        return $this->belongsToMany('App\Relation', 'student_relations');
    }

    public function criteria_mandatories(){
        return $this->belongsToMany('App\CriteriaMandatory', 'student_criteria_mandatories');
    }

    public function criteria_selfregis(){
        return $this->belongsToMany('App\CriteriaSelfregis', 'student_criteria_selregis');
    }
}

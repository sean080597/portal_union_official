<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'note',
        'uid_secretary',
        'uid_deputysecre1',
        'uid_deputysecre2'
    ];
    public function classrooms(){
        return $this->hasMany('App\ClassRoom');
    }

	public function students()
    {
        return $this->hasManyThrough(
            'App\Student',
            'App\ClassRoom',
            'faculty_id', // Foreign key on classrooms table...
            'class_room_id', // Foreign key on students table...
            'id', // Local key on faculties table...
            'id' // Local key on classrooms table...
        );
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

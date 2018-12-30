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
        return User::with('student')->where('id', $this->uid_secretary)->first();
    }

    public function deputy_secretary_1(){
        return User::where('id', $this->uid_deputysecre1)->first();
    }

    public function deputy_secretary_2(){
        return User::where('id', $this->uid_deputysecre2)->first();
    }
}

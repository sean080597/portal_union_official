<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentOfUser extends Model
{
    protected $fillable = [
        'name',
        'birthday',
        'phone',
        'job',
        'sex',
        'student_id'
    ];

    protected $hidden = [
        'student_id'
    ];

    public function user(){
        return $this->belongsTo(
            'App\User',
            'user_id'
        );
    }
}

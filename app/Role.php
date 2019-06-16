<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id','name'
    ];
    // protected $hidden = ['id'];
    public function users(){
        return $this->hasMany('App\User');
    }
    public function competences(){
        return $this->belongsToMany(
            'App\Competence',
            'competence_role',
            'role_id',
            'competence_id'
        );
    }
}

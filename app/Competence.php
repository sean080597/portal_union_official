<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public function roles(){
        return $this->belongsToMany(
            'App\Role',
            'competence_role',
            'competence_id',
            'role_id'
        );
    }
}

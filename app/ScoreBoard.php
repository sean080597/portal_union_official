<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreBoard extends Model
{
    protected $fillable = [
        'year',
        'completion',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function schoolsActivities(){
        return $this->belongsToMany(
            'App\SchoolsActivity',
            'scoreboard_schoolsactivity',
            'score_board_id',
            'schools_activity_id'
        );
    }

    public function selfActivities(){
        return $this->belongsToMany(
            'App\SelfActivity',
            'scoreboard_selfactivity',
            'score_board_id',
            'self_activity_id'
        );
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolsActivity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'total_score'
    ];

    public function scoreBoards(){
        return $this->belongsToMany(
            'App\ScoreBoard',
            'scoreboard_schoolsactivity',
            'schools_activity_id',
            'score_board_id'
        );
    }
}

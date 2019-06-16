<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfActivity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'total_score',
        'activity_content'
    ];

    public function scoreBoards(){
        return $this->belongsToMany(
            'App\ScoreBoard',
            'scoreboard_selfactivity',
            'self_activity_id',
            'score_board_id'
        );
    }

    public function images(){
        return $this->morphMany(
            'App\Image',
            'imageable'
        );
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreboardSelfactivity extends Model
{
    public $table = "scoreboard_selfactivity";
    protected $fillable=[
        'activity_content',
        'average_score',
        'confirmingStudent',
        'confirmingClass',
        'confirmingFaculty',
        'confirmingSchool',
        'score_board_id',
        'self_activity_id'
    ];
    public function images(){
        return $this->morphMany(
            'App\Image',
            'imageable'
        );
    }
}

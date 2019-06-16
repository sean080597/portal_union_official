<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreboardSchoolsactivity extends Model
{
    public $table = "scoreboard_schoolsactivity";
    protected $fillable=[
        'average_score',
        'confirmingStudent',
        'confirmingClass',
        'confirmingFaculty',
        'confirmingSchool',
        'score_board_id',
        'schools_activity_id'
    ];
    public function images(){
        return $this->morphMany(
            'App\Image',
            'imageable'
        );
    }
}

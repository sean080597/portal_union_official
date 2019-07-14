<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreBoard extends Model
{
    protected $fillable = [
        'year',
        'averageScore',
        'confirmingStudent',
        'confirmingClass',
        'confirmingFaculty',
        'confirmingSchool',
        'student_id'
    ];

    protected $hidden = [
        'student_id'
    ];

    public function schoolsActivities(){
        return $this->belongsToMany(
            'App\SchoolsActivity',
            'scoreboard_schoolsactivity',
            'score_board_id',
            'schools_activity_id'
        )->withPivot(
            'id',
            'average_score',
            'confirmingStudent',
            'confirmingClass',
            'confirmingFaculty',
            'confirmingSchool'
        );
    }

    public function selfActivities(){
        return $this->belongsToMany(
            'App\SelfActivity',
            'scoreboard_selfactivity',
            'score_board_id',
            'self_activity_id'
        )->withPivot(
            'id',
            'activity_content',
            'average_score',
            'confirmingStudent',
            'confirmingClass',
            'confirmingFaculty',
            'confirmingSchool'
        );
    }

    public function student(){
        return $this->belongsTo(
            'App\Student',
            'student_id'
        );
    }
}

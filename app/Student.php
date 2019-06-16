<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'address',
        'image',
        'sex',
        'birthday',
        'hometown',
        'ethnic',
        'religion',
        'union_date',
        'is_submit',
        'class_room_id',
        'user_id'
    ];

    public function classroom(){
        return $this->belongsTo('App\ClassRoom', 'class_room_id', 'id');
    }

    public function faculty() {
        return $this->classroom->faculty();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function events(){
        return $this->belongsToMany('App\Event', 'student_events');
    }

    public function relations()
    {
        return $this->belongsToMany('App\Relation', 'student_relations');
    }

    public function criteria_mandatories(){
        return $this->belongsToMany('App\CriteriaMandatory', 'student_criteria_mandatories',
        'student_id', 'criteria_id');
    }

    public function criteria_selfregis(){
        return $this->belongsToMany('App\CriteriaSelfregis', 'student_criteria_selregis',
        'student_id', 'criteria_id');
    }

    public function getMarksCriMan()
    {
        return $this->belongsToMany('App\CriteriaMandatory', 'student_criteria_mandatories',
        'student_id', 'criteria_id')->withPivot('self_assessment', 'mark_student', 'mark_classroom', 'mark_faculty', 'mark_school');
    }

    public function getMarksCriSel()
    {
        return $this->belongsToMany('App\CriteriaSelregis', 'student_criteria_selregis',
        'student_id', 'criteria_id')->withPivot('content_regis', 'self_assessment', 'mark_student', 'mark_classroom', 'mark_faculty', 'mark_school');
    }

    //--------------------- cam --------------------------
    public function parents(){
        return $this->hasMany(
            'App\ParentOfUser',
            'student_id'
        );
    }

    public function scoreBoards(){
        return $this->hasMany(
            'App\ScoreBoard',
            'student_id'
        );
    }
    //----------------------end cam ----------------------

}

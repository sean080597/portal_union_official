<?php

namespace App\Http\Controllers\API;

use App\ScoreBoard;
use App\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScoreBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scores = ScoreBoard::findOrFail($id)->schoolsActivities()->get();
        return $scores;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(ScoreBoard $scoreBoard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $scoreBoard = ScoreBoard::findOrFail($id);
        $scoreBoard->update($request->all());
        return response(['result' => 'Cập nhật thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScoreBoard $scoreBoard)
    {
        //
    }

    public function showScore($student_id, $currentYear){
        $student = Student::findOrFail($student_id);
        $scoreBoards = $student->scoreBoards()->where('year',$currentYear)->first();
        $schoolScores = $scoreBoards->schoolsActivities()->get();
        $selfScores = $scoreBoards->selfActivities()->get();
        return ['school' => $schoolScores, 'self' => $selfScores];
    }

    public function storeSchoolsActivityScore($scoreBoard_id, $schoolsActivity_id, Request $request){
        $scoreBoard = ScoreBoard::findOrFail($scoreBoard_id);
        $scoreBoard->schoolsActivities()->attach($schoolsActivity_id,[
            'average_score' => 0,
            'confirmingStudent' => 0,
            'confirmingClass' => 0,
            'confirmingFaculty' => 0,
            'confirmingSchool' => 0,
        ]);
        return response([
            'result' => 'Tạo thành công.'
        ],200);
    }

    public function updateSchoolsActivityScore($scoreBoard_id, $schoolsActivity_id, Request $request){
        $scoreBoard = ScoreBoard::findOrFail($scoreBoard_id);
        $scoreBoard->schoolsActivities()->updateExistingPivot($schoolsActivity_id,[
            $request->field => $request->value,
            'average_score' => $request->average_score
        ]);
        return response([
            'result' => 'Update thành công.'
        ],200);
    }
    public function storeSelfActivityScore($scoreBoard_id, $selfActivity_id, Request $request){
        $scoreBoard = ScoreBoard::findOrFail($scoreBoard_id);
        $scoreBoard->selfActivities()->attach($selfActivity_id,[
            'activity_content' => '',
            'average_score' => 0,
            'confirmingStudent' => 0,
            'confirmingClass' => 0,
            'confirmingFaculty' => 0,
            'confirmingSchool' => 0,
        ]);
        return response([
            'result' => 'Tạo thành công.'
        ],200);
    }

    public function updateSelfActivityScore($scoreBoard_id, $selfActivity_id, Request $request){
        $scoreBoard = ScoreBoard::findOrFail($scoreBoard_id);
        $scoreBoard->selfActivities()->updateExistingPivot($selfActivity_id,[
            'activity_content' => $request->content,
            'average_score' => $request->average_score,
            $request->field => $request->value
        ]);
        return response([
            'result' => 'Update thành công.'
        ],200);
    }
}

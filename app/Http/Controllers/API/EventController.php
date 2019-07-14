<?php

namespace App\Http\Controllers\API;
use App\Student;
use App\ScoreBoard;
use App\ScoreboardSchoolsactivity;
use App\ScoreboardSelfactivity;
use App\SchoolsActivity;
use App\SelfActivity;
use DB;
use App\Http\Controllers\API\ScoreBoardController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //----------------------------- score board --------------------------------
    public function getTotalStudent(){
        $total = Student::count();
        return response([
            'result' => $total
        ],200);
    }
    public function getCurrentScoreboard($year){
        $result = DB::select(
            DB::raw(
                "SELECT COUNT(id) as 'result' FROM `score_boards` WHERE year = '$year'"
            )
        );
        return $result;
    }
    public function getMissCurrentScoreboard($year){
        $result = DB::select(
            DB::raw(
                "SELECT id FROM `students` WHERE id NOT IN (SELECT DISTINCT students.id FROM score_boards LEFT JOIN students ON students.id = score_boards.student_id WHERE year = '$year')"
            )
        );
        return $result;
    }
    public function createEvaluationEvent($id,$year){
        $scoreBoardController = new ScoreBoardController();
        $scoreboard = ScoreBoard::create([
            'student_id' => $id,
            'year' => $year
        ]);
        $schoolsActivities = SchoolsActivity::oldest('created_at')->get(['id']);
        $selfActivities = SelfActivity::oldest('created_at')->get(['id']);
        foreach ($schoolsActivities as $key => $value) {
            $school = $scoreBoardController->storeSchoolsActivityScore($scoreboard->id,$value->id);
        }
        foreach ($selfActivities as $key => $value) {
            $self = $scoreBoardController->storeSelfActivityScore($scoreboard->id,$value->id);
        }
        return response([
            'result' => 'create successful',
            'state' => '200'
        ],200);
    }
}

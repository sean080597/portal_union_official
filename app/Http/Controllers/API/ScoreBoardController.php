<?php

namespace App\Http\Controllers\API;

use App\ScoreBoard;
use App\Student;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $scoreBoard = ScoreBoard::create(['student_id' => $request->student_id, 'year' => $request->year]);
        return $scoreBoard->id;
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

    public function storeSchoolsActivityScore($scoreBoard_id, $schoolsActivity_id){
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
    public function storeSelfActivityScore($scoreBoard_id, $selfActivity_id){
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

    public function getTotalCurrentScoreBoard(){

    }

    //========================== Report ========================================
    public function getReportByClassID($class_id){
        $result = DB::table('students as s')
            ->join('score_boards as sb', 's.id', '=', 'sb.student_id')
            ->select('s.id', 's.name', 's.birthday', 'sb.averageScore', 'sb.confirmingStudent')
            ->where('s.class_room_id', $class_id)
            ->where('sb.year', Carbon::today()->format ('Y'))
            ->paginate(25);
        return $result;
    }

    public function getReportByFaculty($fac_id){
        $result = DB::table(DB::raw('(SELECT COUNT(*) total, class_room_id FROM students WHERE class_room_id LIKE "%'.$fac_id.'%" GROUP BY class_room_id) total_stu'))
                ->select(DB::raw('tb_evaluated.*, total_stu.total'))
                ->join(DB::raw('(SELECT s.class_room_id, COUNT(IF(sb.confirmingStudent=1,1, NULL)) evaluated, YEAR(sb.updated_at) updated_at
                    FROM students s
                    INNER JOIN score_boards sb ON s.id = sb.student_id
                    WHERE s.class_room_id LIKE "%'.$fac_id.'%" AND YEAR(sb.updated_at) = '.Carbon::today()->format ('Y').'
                    GROUP BY s.class_room_id, sb.updated_at) tb_evaluated'), function($join){
                        $join->on('tb_evaluated.class_room_id', '=', 'total_stu.class_room_id');
                    })
                ->paginate(25);
        return $result;
    }

    public function getReportBySchool(){
        $result = DB::select(DB::raw('SELECT tb_count_classes.*, tb_evaluated_classes.evaluated
                    FROM
                        (SELECT faculties.id, faculties.name, faculties.note, COUNT(class_rooms.id) class_qtt
                        FROM faculties, class_rooms
                        WHERE faculties.id = class_rooms.faculty_id
                        GROUP BY faculties.id, faculties.name, faculties.note) tb_count_classes
                    LEFT JOIN
                        (SELECT faculty_id, COUNT(IF(tb_evaluated.evaluated = total_stu.total, 1, NULL)) evaluated
                        FROM
                        (SELECT s.class_room_id, COUNT(IF(sb.confirmingStudent=1,1, NULL)) evaluated, sb.updated_at
                            FROM students s
                            INNER JOIN score_boards sb ON s.id = sb.student_id
                            WHERE YEAR(sb.updated_at) = "'.Carbon::today()->format ('Y').'"
                            GROUP BY s.class_room_id, sb.updated_at) tb_evaluated
                        INNER JOIN (SELECT COUNT(*) total, class_room_id FROM students GROUP BY class_room_id) total_stu
                        ON tb_evaluated.class_room_id = total_stu.class_room_id
                        INNER JOIN class_rooms
                        ON class_rooms.id = total_stu.class_room_id
                        GROUP BY faculty_id) tb_evaluated_classes
                    ON tb_count_classes.id = tb_evaluated_classes.faculty_id'));
        return $result;
    }

    //========================== MyTask ========================================
    public function getMyTaskByClassID($class_id){
        $result = DB::table('students as s')
            ->join('score_boards as sb', 's.id', '=', 'sb.student_id')
            ->select('s.id', 's.name', 's.birthday', 'sb.averageScore', 'sb.confirmingClass')
            ->where('s.class_room_id', $class_id)
            ->where('sb.year', Carbon::today()->format ('Y'))
            ->paginate(25);
        return $result;
    }

    public function getMyTaskByFaculty($fac_id){
        $result = DB::table(DB::raw('(SELECT COUNT(*) total, class_room_id FROM students WHERE class_room_id LIKE "%'.$fac_id.'%" GROUP BY class_room_id) total_stu'))
                ->select(DB::raw('tb_evaluated.*, total_stu.total'))
                ->join(DB::raw('(SELECT s.class_room_id, COUNT(IF(sb.confirmingFaculty=1,1, NULL)) evaluated, YEAR(sb.updated_at) updated_at
                    FROM students s
                    INNER JOIN score_boards sb ON s.id = sb.student_id
                    WHERE s.class_room_id LIKE "%'.$fac_id.'%" AND YEAR(sb.updated_at) = '.Carbon::today()->format ('Y').'
                    GROUP BY s.class_room_id, sb.updated_at) tb_evaluated'), function($join){
                        $join->on('tb_evaluated.class_room_id', '=', 'total_stu.class_room_id');
                    })
                ->paginate(25);
        return $result;
    }

    public function getMyTaskBySchool(){
        $result = DB::select(DB::raw('SELECT tb_count_classes.*, tb_evaluated_classes.evaluated
                    FROM
                        (SELECT faculties.id, faculties.name, faculties.note, COUNT(class_rooms.id) class_qtt
                        FROM faculties, class_rooms
                        WHERE faculties.id = class_rooms.faculty_id
                        GROUP BY faculties.id, faculties.name, faculties.note) tb_count_classes
                    LEFT JOIN
                        (SELECT faculty_id, COUNT(IF(tb_evaluated.evaluated = total_stu.total, 1, NULL)) evaluated
                        FROM
                        (SELECT s.class_room_id, COUNT(IF(sb.confirmingSchool=1,1, NULL)) evaluated, sb.updated_at
                            FROM students s
                            INNER JOIN score_boards sb ON s.id = sb.student_id
                            WHERE YEAR(sb.updated_at) = "'.Carbon::today()->format ('Y').'"
                            GROUP BY s.class_room_id, sb.updated_at) tb_evaluated
                        INNER JOIN (SELECT COUNT(*) total, class_room_id FROM students GROUP BY class_room_id) total_stu
                        ON tb_evaluated.class_room_id = total_stu.class_room_id
                        INNER JOIN class_rooms
                        ON class_rooms.id = total_stu.class_room_id
                        GROUP BY faculty_id) tb_evaluated_classes
                    ON tb_count_classes.id = tb_evaluated_classes.faculty_id'));
        return $result;
    }

    //========================== Statistic by Average Score ========================================
    public function getStatisticScoreBoard($year){
        $query = DB::table('score_boards')
                ->select(DB::raw('averageScore, COUNT(*) count, year'))
                ->groupBy(DB::raw('averageScore, year'))
                ->orderBy('averageScore')
                ->where('year', $year)
                ->get();
        $result['averageScore'] = $query->pluck('averageScore');
        $result['statistic'] = array('name' => ''.$query[0]->year, 'data' => $query->pluck('count'));
        return response()->json($result, 200);
    }

    public function getAllAvgScoreYear(){
        return DB::table('score_boards')->select('year')->distinct()->get();
    }
}

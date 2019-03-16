<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\ClassRoom;
use App\Student;

class ClassRoomController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClassRoom::with('faculty')->orderBy('id', 'ASC')->paginate(20);
    }

    public function index_client($faculty_id)
    {
        return ClassRoom::with('secretary')->where('faculty_id', $faculty_id)->orderBy('id', 'ASC')->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string|max:10|unique:class_rooms',
            'faculty_id' => 'required|string|max:50',
        ]);

        return ClassRoom::create([
            'id' => strtoupper($request['id']),
            'faculty_id' => $request['faculty_id'],
        ]);
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
    public function update(Request $request, $idToUpdate)
    {
        $cla = ClassRoom::findOrfail($idToUpdate);
        //unique faculty_id --> no space
        $this->validate($request, [
            'id' => 'required|string|max:10|unique:class_rooms,id,'.$cla->id,
            'faculty_id' => 'required|string|max:4',
        ]);
        $cla->update($request->all());
        return ['message' => 'Updated ClassRoom'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($classroom_id)
    {
        ClassRoom::findOrfail($classroom_id)->delete();
        return ['message' => 'Deleted ClassRoom'];
    }

    //get classroom leader accounts
    public function getClassroomAccs($classroom_id){
        return ClassRoom::with(['secretary', 'deputySecretary1', 'deputySecretary2'])->findOrFail($classroom_id);
    }

    //get all classrooms
    public function getAllClassrooms(){
        return ClassRoom::orderBy('id', 'ASC')->get()->chunk(50)->collapse();
    }

    //search classrooms
    public function search(){
        $faculty_id = \Request::get('fac_id');
        if ($search = \Request::get('q')) {
            return ClassRoom::with('secretary')->where('faculty_id', $faculty_id)->where('id', 'LIKE', "%$search%")
                    ->orderBy('id', 'ASC')->paginate(20);
        }else{
            return ClassRoom::with('secretary')->where('faculty_id', $faculty_id)->orderBy('id', 'ASC')->paginate(20);
        }
    }

    public function searchByAdmin(){
        if ($search = \Request::get('q')) {
            return ClassRoom::with('faculty')->where('id', 'LIKE', "%$search%")
                        ->orWhere('faculty_id', 'LIKE', "%$search%")
                        ->orderBy('id', 'ASC')->paginate(20);
        }else{
            return ClassRoom::with('faculty')->orderBy('id', 'ASC')->paginate(20);
        }
    }

    //get evaluation of a faculty by
    public function getStatisticFacultyDashboard($faculty_id){
        $result['data'] = DB::select(DB::raw('SELECT COUNT(isDone) count_done, updated_at
            FROM (SELECT tb_eval_all_faculties.*, total_stu.total, IF(tb_eval_all_faculties.evaluated = total_stu.total, "Hoàn thành", "Chưa xong") isDone
                FROM tb_eval_all_faculties
                INNER JOIN (SELECT COUNT(*) total, class_room_id FROM students  GROUP BY class_room_id) total_stu
                ON tb_eval_all_faculties.class_room_id = total_stu.class_room_id
            WHERE total_stu.class_room_id LIKE "%'.$faculty_id.'%") tb_eval_result_by_facid
            GROUP BY updated_at'));
        $result['total_classrooms'] = DB::table('class_rooms')->where('faculty_id', $faculty_id)->count();
        return $result;
    }

    public function getStatisticFacultyDetail($faculty_id){
        $year = \Request::get('y');
        $result['data'] = DB::select(DB::raw('SELECT * FROM tb_eval_all_faculties WHERE updated_at = "'.$year.'"'));
        $result['total_classrooms'] = DB::table('class_rooms')->where('faculty_id', $faculty_id)->count();
        return $result;
    }
}

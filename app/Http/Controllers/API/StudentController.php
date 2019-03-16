<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\User;
use App\Role;
use DB;
use App\Relation;
use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
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
        // return Student::with('classroom')->latest()->paginate(30);
        return DB::table('students AS s')->select('s.*', 's.id as mssv', 'f.id as faculty_id', 'f.name as faculty_name', 'u.*')
        ->join('users AS u', 'u.id', '=', 's.user_id')
        ->join('class_rooms AS c', 'c.id', '=', 's.class_room_id')
        ->join('faculties AS f', 'f.id', '=', 'c.faculty_id')
        ->orderBy('s.created_at', 'DESC')->paginate(30);
    }

    public function index_client($classroom_id)
    {
        // return Student::with('user')->where('class_room_id', $classroom_id)->paginate(30);
        return DB::table('students AS s')->select('s.id as mssv', 's.name', 's.birthday', 'u.email', 'u.phone', 's.class_room_id')
            ->join('users AS u', 'u.id', '=', 's.user_id')
            ->where('s.class_room_id', $classroom_id)->paginate(30);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check was student?
        $std = Student::find($request->id);
        if(isset($std)){
            return response(['error'=>'Đoàn viên đã tồn tại']);
        }else{
            $role = Role::find('stu');
            $newUser = $role->users()->create($request->all());
            $student = $newUser->student()->create($request->all());
            if($student ==='undefined'){
                $newUser->delete();
                return response(['error'=>'Không thể tạo đoàn viên']);
            }
            else{
                if($request->father_name !== null){
                    $father = Relation::create([
                        'name' => $request->father_name,
                        'birthday' => $request->father_birthday,
                        'phone' => $request->father_phone,
                        'job' => $request->father_job,
                        'role' => 1
                    ]);
                    $father->students()->attach($student);
                }
                if($request->mother_name !== null){
                    $mother = Relation::create([
                        'name' => $request->mother_name,
                        'birthday' => $request->mother_birthday,
                        'phone' => $request->mother_phone,
                        'job' => $request->mother_job,
                        'role' => 0
                    ]);
                    $mother->students()->attach($student);
                }
            }
        }
        return response(['success','result'=> $newUser]);
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
    public function getRelationsByStuId($student_id)
    {
        return Student::findOrfail($student_id)->relations;
    }

    public function updateProfile(Request $request){
        $student = Student::findOrfail($request->id);
        $this->validate($request, [
            'email' => 'max:191|unique:users,email,'.$student->user->email.',email',
        ]);

        $current_image = $student->image;
        if($request->image != $current_image){
            //get extension of base64 string
            $regex = '/^[^\/]+\/([\w]+)/';
            preg_match($regex, $request->image, $extension);
            //generate new name
            $name = time() . mt_rand(1000, 99999) . '.' . $extension[1];
            Image::make($request->image)->save(public_path('theme/images_profile/').$name);
            //assign image name
            $request->merge(['image' => $name]);
            //delete old image
            $pathOldImage = public_path('theme/images_profile/').$current_image;
            if(file_exists($pathOldImage)){
                @unlink($pathOldImage);
            }
        }
        //update student
        $student->update($request->all());
        $student->user->update($request->all());
        foreach ($student->relations as $key => $value) {
            if($value->role == 1){
                $value->update([
                    'name' => $request->father_name,
                    'birthday' => $request->father_birthday,
                    'phone' => $request->father_phone,
                    'job' => $request->father_job,
                ]);
            }else{
                $value->update([
                    'name' => $request->mother_name,
                    'birthday' => $request->mother_birthday,
                    'phone' => $request->mother_phone,
                    'job' => $request->mother_job,
                ]);
            }
        }
        return response()->json(['message' => 'Success']);
    }

    //search students in student managerment
    public function search(){
        $classroom_id = \Request::get('cla_id');
        if ($search = \Request::get('q')) {
            return DB::table('students AS s')->select('s.id as mssv', 's.name', 's.birthday', 'u.email', 'u.phone', 's.class_room_id')
            ->join('users AS u', 'u.id', '=', 's.user_id')
            ->where('s.class_room_id', $classroom_id)
            ->where(function($query) use ($search){
                $query->where('s.id', 'LIKE', "%$search%")
                ->orWhere('s.name', 'LIKE', "%$search%")
                ->orWhere('u.phone', 'LIKE', "%$search%")
                ->orWhere('u.email', 'LIKE', "%$search%");
            })->paginate(30);
        }else{
            return DB::table('students AS s')->select('s.id as mssv', 's.name', 's.birthday', 'u.email', 'u.phone', 's.class_room_id')
            ->join('users AS u', 'u.id', '=', 's.user_id')
            ->where('s.class_room_id', $classroom_id)->paginate(30);
        }
    }

    public function searchByAdmin(){
        if ($search = \Request::get('q')) {
            return DB::table('students AS s')->select('s.*', 's.id as mssv', 'f.id as faculty_id', 'f.name as faculty_name', 'u.*')
            ->join('users AS u', 'u.id', '=', 's.user_id')
            ->join('class_rooms AS c', 'c.id', '=', 's.class_room_id')
            ->join('faculties AS f', 'f.id', '=', 'c.faculty_id')
            ->where('s.id', 'LIKE', "%$search%")
            ->orWhere('s.name', 'LIKE', "%$search%")
            ->orWhere('u.phone', 'LIKE', "%$search%")
            ->orWhere('u.email', 'LIKE', "%$search%")
            ->orWhere('c.id', 'LIKE', "%$search%")
            ->orderBy('c.id', 'ASC')->paginate(30);
        }else{
            return DB::table('students AS s')->select('s.*', 's.id as mssv', 'f.id as faculty_id', 'f.name as faculty_name', 'u.*')
            ->join('users AS u', 'u.id', '=', 's.user_id')
            ->join('class_rooms AS c', 'c.id', '=', 's.class_room_id')
            ->join('faculties AS f', 'f.id', '=', 'c.faculty_id')
            ->orderBy('c.id', 'ASC')->paginate(30);
        }
    }

    //Evaluation Info
    public function getStatisticClassroomDetail($classroom_id){
        $year = \Request::get('y');

        $arr_condition = ['Xuất sắc', 'Khá', 'Trung bình', 'Yếu'];
        $sql_condition = 'CASE WHEN SUM(mark_school)>84 THEN "'.$arr_condition[0]
        .'" WHEN SUM(mark_school)>69 THEN "'.$arr_condition[1]
        .'" WHEN SUM(mark_school)>49 THEN "'.$arr_condition[2]
        .'" ELSE "'.$arr_condition[3].'" END rank, ';

        return DB::table('students as s')
            ->select('s.id', 's.name', 's.birthday', 'tb_mark.*')
            ->leftJoin(DB::raw('(SELECT student_id, SUM(mark_student) mark_student, SUM(mark_classroom) mark_classroom, SUM(mark_faculty) mark_faculty, SUM(mark_school) mark_school,'
            .$sql_condition.'YEAR(updated_at) updated_at '
            .'FROM (SELECT scm.student_id, scm.mark_student, scm.mark_classroom, scm.mark_faculty, scm.mark_school, scm.updated_at FROM student_criteria_mandatories scm UNION ALL
            SELECT scs.student_id, scs.mark_student, scs.mark_classroom, scs.mark_faculty, scs.mark_school, scs.updated_at FROM student_criteria_selregis scs) alias
            WHERE YEAR(updated_at) = '.$year.'
            GROUP BY student_id, updated_at) tb_mark'), function($join){
                $join->on('s.id', '=', 'tb_mark.student_id');
            })
            ->where('s.class_room_id', $classroom_id)
            ->paginate(25);
    }

    public function getStatisticClassroomDashboard($classroom_id){
        $result['data'] = DB::table('students as s')
            ->select(DB::raw('COUNT(mark_student) evaluated, tb_mark.updated_at'))
            ->join(DB::raw('(SELECT student_id, SUM(mark_student) mark_student, YEAR(updated_at) updated_at
            FROM (SELECT scm.student_id, scm.mark_student, scm.updated_at FROM student_criteria_mandatories scm UNION ALL
                SELECT scs.student_id, scs.mark_student, scs.updated_at FROM student_criteria_selregis scs) alias
            GROUP BY student_id, updated_at) tb_mark'), function($join){
                $join->on('s.id', '=', 'tb_mark.student_id');
            })
            ->where('s.class_room_id', $classroom_id)
            ->groupBy('updated_at')
            ->get();

        $result['total_quantity'] = DB::table('students as s')->where('class_room_id', $classroom_id)->count();
        return $result;
    }

    //search student evaluation
    public function findEvaluateClassroomStatistic(){
        $classroom_id = \Request::get('cla_id');
        $year = \Request::get('y');

        $arr_condition = ['Xuất sắc', 'Khá', 'Trung bình', 'Yếu'];
        $sql_condition = 'CASE WHEN SUM(mark_school)>84 THEN "'.$arr_condition[0]
        .'" WHEN SUM(mark_school)>69 THEN "'.$arr_condition[1]
        .'" WHEN SUM(mark_school)>49 THEN "'.$arr_condition[2]
        .'" ELSE "'.$arr_condition[3].'" END rank, ';

        if ($search = \Request::get('q')) {
            return DB::table('students as s')
                ->select('s.id', 's.name', 's.birthday', 'tb_mark.*')
                ->leftJoin(DB::raw('(SELECT student_id, SUM(mark_student) mark_student, SUM(mark_classroom) mark_classroom, SUM(mark_faculty) mark_faculty, SUM(mark_school) mark_school,'
                .$sql_condition.'YEAR(updated_at) updated_at '
                .'FROM (SELECT scm.student_id, scm.mark_student, scm.mark_classroom, scm.mark_faculty, scm.mark_school, scm.updated_at FROM student_criteria_mandatories scm UNION ALL
                SELECT scs.student_id, scs.mark_student, scs.mark_classroom, scs.mark_faculty, scs.mark_school, scs.updated_at FROM student_criteria_selregis scs) alias
                WHERE YEAR(updated_at) = '.$year.'
                GROUP BY student_id, updated_at) tb_mark'), function($join){
                    $join->on('s.id', '=', 'tb_mark.student_id');
                })
                ->where('s.class_room_id', $classroom_id)
                ->where(function($query) use ($search){
                    $query->where('s.id', 'LIKE', "%$search%")
                    ->orWhere('s.name', 'LIKE', "%$search%")
                    ->orWhere('tb_mark.rank', 'LIKE', "%$search%");
                })
                ->paginate(25);
        }else{
            return DB::table('students as s')
                ->select('s.id', 's.name', 's.birthday', 'tb_mark.*')
                ->leftJoin(DB::raw('(SELECT student_id, SUM(mark_student) mark_student, SUM(mark_classroom) mark_classroom, SUM(mark_faculty) mark_faculty, SUM(mark_school) mark_school,'
                .$sql_condition.'YEAR(updated_at) updated_at '
                .'FROM (SELECT scm.student_id, scm.mark_student, scm.mark_classroom, scm.mark_faculty, scm.mark_school, scm.updated_at FROM student_criteria_mandatories scm UNION ALL
                SELECT scs.student_id, scs.mark_student, scs.mark_classroom, scs.mark_faculty, scs.mark_school, scs.updated_at FROM student_criteria_selregis scs) alias
                WHERE YEAR(updated_at) = '.$year.'
                GROUP BY student_id, updated_at) tb_mark'), function($join){
                    $join->on('s.id', '=', 'tb_mark.student_id');
                })
                ->where('s.class_room_id', $classroom_id)
                ->paginate(25);
        }
    }
}

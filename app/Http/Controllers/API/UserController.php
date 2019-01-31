<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Student;
use App\ClassRoom;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('role')->latest()->paginate(30);
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
            'email' => 'max:191|email|unique:users',
            'student_id' => 'unique:students,id'
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $request['role_id'],
        ]);

        if(!empty($request['student_id'])){
            Student::create([
                'id' => $request['student_id'],
                'name' => $request['name']
            ]);
        }
        return response()->json(['isSuccess' => true]);
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
        $user = User::findOrfail($id);
        //unique faculty_id --> no space
        $this->validate($request, [
            'email' => 'max:191|email|unique:users,email,'.$user->email.',email',
            'name' => 'max:50',
            'password' => 'sometimes'
        ]);
        if(!empty($request->password)){
            $request->merge(['password' => bcrypt($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => 'Updated Faculty'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $u = User::findOrfail($user_id);
        if(!empty($u->student)){
            $re = $u->student->relations;
            if($re->count() > 0){
                $re->detach();
            }
        }
        $u->delete();
        return ['message' => 'Deleted successfully'];
    }

    //get user with student info by user_id
    public function getUserStudentInfoByUserId($user_id){
        return User::with('student')->findOrfail($user_id);
    }

    //get user with student info by student_id
    public function getUserStudentInfoByStuId($student_id){
        return DB::table('students AS s')->select('s.*', 's.id as mssv', 'f.id as faculty_id', 'f.name as faculty_name', 'u.*')
        ->join('users AS u', 'u.id', '=', 's.user_id')
        ->join('class_rooms AS c', 'c.id', '=', 's.class_room_id')
        ->join('faculties AS f', 'f.id', '=', 'c.faculty_id')
        ->where('s.id', $student_id)->get();
    }
}

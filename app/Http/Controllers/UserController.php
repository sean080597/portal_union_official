<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use Illuminate\Http\Request;
use App\ClassRoom;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('role')->latest()->paginate(40);
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
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:191|email|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|string|max:50'
        ]);

        // User::create([
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'password' => bcrypt($request['password']),
        //     'role_id' => $request['role_id'],
        // ]);

        // return Student::create([
        //     'name' => 'Flight 10'
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    //get user with student info by user_id
    public function getUserStudentInfoByUserId($user_id){
        return User::with('student')->findOrfail($user_id);
    }

    //get user with student info by student_id
    public function getUserStudentInfoByStuId($student_id){
        return DB::table('students AS s')->select('s.*', 's.id as mssv', 'f.name as faculty_name', 'u.*')
        ->join('users AS u', 'u.id', '=', 's.user_id')
        ->join('class_rooms AS c', 'c.id', '=', 's.class_room_id')
        ->join('faculties AS f', 'f.id', '=', 'c.faculty_id')
        ->where('s.id', $student_id)->get();
    }
}

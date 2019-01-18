<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use DB;
use Image;

class StudentController extends Controller
{
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
        return Student::with('user')->where('class_room_id', $classroom_id)->paginate(30);
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
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function getRelationsByStuId($student_id)
    {
        return Student::findOrfail($student_id)->relations;
    }

    public function updateProfile(Request $request){
        // return $request->image;
        if($request->image){
            //get extension of base64 string
            $regex = '/^[^\/]+\/([\w]+)/';
            preg_match($regex, $request->image, $extension);
            //generate new name
            $name = time() . '.' . $extension[1];
            Image::make($request->image)->save(public_path('img/').$name);
        }
        return response()->json(['message' => 'Success']);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Student;
use DB;
use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
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
}

<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Student;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
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
        return ClassRoom::with('faculty')->orderBy('id', 'ASC')->paginate(30);
    }

    public function index_client($faculty_id)
    {
        return ClassRoom::with('secretary')->where('faculty_id', $faculty_id)->orderBy('id', 'ASC')->paginate(30);
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
     * @param  \App\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassRoom  $classRoom
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
     * @param  \App\ClassRoom  $classRoom
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
        return ClassRoom::orderBy('id', 'ASC')->get()->chunk(50);
    }

    //get all classrooms by student_id
    public function getAllClassroomsByFacultyID($faculty_id){
        $classrooms = ClassRoom::where('faculty_id', $faculty_id)->orderBy('id', 'ASC')->get()->chunk(50);
        return $classrooms->collapse();
    }
}

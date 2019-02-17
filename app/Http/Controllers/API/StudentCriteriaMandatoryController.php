<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\CriteriaMandatory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentCriteriaMandatoryController extends Controller
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
    public function show($student_id)
    {
        $data = array();
        if (Student::findOrfail($student_id)->getMarksCriMan->count() > 0){
            // return Student::findOrfail($student_id)->getMarksCriMan;
            $ls_marks = Student::findOrfail($student_id)->getMarksCriMan;
            foreach ($ls_marks as $key => $value) {
                $data[] = $value->pivot;
            }
            return response()->json($data);
        }else{
            $ls_marks = CriteriaMandatory::all();
            foreach ($ls_marks as $key => $value) {
                $data[] = [
                    'student_id' => $student_id,
                    'criteria_id' => $value->id,
                    'self_assessment' => '',
                    'mark_student' => 0,
                    'mark_classroom' => 0,
                    'mark_faculty' => 0,
                    'mark_school' => 0,
                ];
            }
            return response()->json($data);
        }
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

    public function submitEvaluation(Request $request)
    {
        return $request->all();
    }
}

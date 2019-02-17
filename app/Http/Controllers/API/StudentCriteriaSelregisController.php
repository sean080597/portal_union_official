<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\CriteriaSelregis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentCriteriaSelregisController extends Controller
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
        if (Student::findOrfail($student_id)->getMarksCriSel->count() > 0){
            $data = array();
            $ls_marks = Student::findOrfail($student_id)->getMarksCriSel;
            foreach ($ls_marks as $key => $value) {
                $data[] = $value->pivot;
            }
            return response()->json($data);
        }else{
            // return CriteriaSelregis::all()->map(function ($value, $key) {
            //     $value['pivot'] = ['content_regis' => ''];
            //     return $value;
            // });
            $ls_marks = CriteriaSelregis::all();
            foreach ($ls_marks as $key => $value) {
                $data[] = [
                    'student_id' => $student_id,
                    'criteria_id' => $value->id,
                    'content_regis' => '',
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
}

<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\StudentCriteriaMandatory;
use App\StudentCriteriaSelregis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmitEvaluationInfoController extends Controller
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
    public function destroy($id)
    {
        //
    }

    public function submitEvaluation(Request $request)
    {
        // return StudentCriteriaMandatory::where('student_id', $request->student_id)->get();
        // return $request->cri_man;
        $data = array();
        $count = collect($request->cri_man['mark_classroom'])->count();
        for ($i=0; $i < $count; $i++) {
            $data[] = [
                'criteria_id' => $request->cri_man['mark_student'][$i],
                'mark_student' => $request->cri_man['mark_student'][$i],
                'mark_classroom' => $request->cri_man['mark_classroom'][$i],
                'mark_faculty' => $request->cri_man['mark_faculty'][$i],
                'mark_school' => $request->cri_man['mark_school'][$i],
                'self_assessment' => $request->cri_man['self_assessment'][$i]
            ];
        }
        return $data;
    }
}

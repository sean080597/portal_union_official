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
            return Student::findOrfail($student_id)->getMarksCriSel;
        }else{
            return CriteriaSelregis::all()->map(function ($value, $key) {
                $value['pivot'] = ['content_regis' => ''];
                return $value;
            });
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

<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\StudentCriteriaMandatory;
use App\StudentCriteriaSelregis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
        $student = StudentCriteriaSelregis::where('student_id', $request->student_id)->get();
        if($student->isEmpty()){
            //init table name
            $table = '`student_criteria_mandatories`';
            $sql_cri_man = self::generateInsertCmd($request, $request->cri_man, $table, 0);
            $table = '`student_criteria_selregis`';
            $sql_cri_self = self::generateInsertCmd($request, $request->cri_self, $table, 1);

            DB::insert($sql_cri_man);
            DB::insert($sql_cri_self);
            return response()->json(['success' => true]);
        }else{
            //get condition to generate what to update
            $check = $request->checkArray;
            //init table name
            $table = '`student_criteria_mandatories`';
            $sql_cri_man = self::generateUpdateCmd($request, $request->cri_man, $table, $check, 0);
            $table = '`student_criteria_selregis`';
            $sql_cri_self = self::generateUpdateCmd($request, $request->cri_self, $table, $check, 1);

            DB::update($sql_cri_man);
            DB::update($sql_cri_self);
            return response()->json(['success' => true]);
        }
    }

    //private function to generate updating cmd
    private function generateUpdateCmd(Request $request, $dataCriteria, $tableName, $checkCondition, $isCriSelf){
        $data = array();
        $count = collect($dataCriteria['mark_classroom'])->count();
        for ($i=0; $i < $count; $i++) {
            $data[$i] = [
                'criteria_id' => $dataCriteria['criteria_id'][$i],
                'mark_student' => $dataCriteria['mark_student'][$i],
                'mark_classroom' => $dataCriteria['mark_classroom'][$i],
                'mark_faculty' => $dataCriteria['mark_faculty'][$i],
                'mark_school' => $dataCriteria['mark_school'][$i],
                'self_assessment' => $dataCriteria['self_assessment'][$i]
            ];

            if($isCriSelf) $data[$i]['content_regis'] = $dataCriteria['content_regis'][$i];
        }

        //init cmd to update marks
        $sql_markstu = $sql_markcla = $sql_markfac = $sql_marksch = $sql_selfassess = $sql_content = '';
        for ($i=0; $i < $count; $i++) {
            $sql_markstu .= ' when criteria_id = '.$data[$i]['criteria_id'].' then '.$data[$i]['mark_student'];
            $sql_markcla .= ' when criteria_id = '.$data[$i]['criteria_id'].' then '.$data[$i]['mark_classroom'];
            $sql_markfac .= ' when criteria_id = '.$data[$i]['criteria_id'].' then '.$data[$i]['mark_faculty'];
            $sql_marksch .= ' when criteria_id = '.$data[$i]['criteria_id'].' then '.$data[$i]['mark_school'];
            $sql_selfassess .= ' when criteria_id = '.$data[$i]['criteria_id'].' then \''.$data[$i]['self_assessment'].'\'';
            if($isCriSelf) $sql_content .= ' when criteria_id = '.$data[$i]['criteria_id'].' then \''.$data[$i]['content_regis'].'\'';
        }

        // generate cmd to update student_cri
        // $sql = 'UPDATE '.$tableName.' SET `created_at` = current_date(), `updated_at` = current_date(),';
        $sql = 'UPDATE '.$tableName.' SET `updated_at` = current_date(),';

        if($isCriSelf && !$checkCondition[0]) $sql .= '`content_regis` = (case '.$sql_content.' end),';

        if(!$checkCondition[0]) $sql .= '`self_assessment` = (case '.$sql_selfassess.' end),'
                                        .'`mark_student` = (case '.$sql_markstu.' end),';
        if(!$checkCondition[1]) $sql .= '`mark_classroom` = (case '.$sql_markcla.' end),';

        if(!$checkCondition[2]) $sql .= '`mark_faculty` = (case '.$sql_markfac.' end),';

        if(!$checkCondition[3]) $sql .= '`mark_school` = (case '.$sql_marksch.' end)';

        $sql = rtrim($sql, ",");//remove comma before WHERE
        return $sql .= 'WHERE criteria_id in ('.implode(",", $request->cri_man['criteria_id']).') AND student_id = '.$request->student_id;
    }

    //private function to generate updating cmd
    private function generateInsertCmd(Request $request, $dataCriteria, $tableName, $isCriSelf){
        $data = array();
        $count = collect($dataCriteria['mark_classroom'])->count();
        // generate cmd to insert student_cri
        if($isCriSelf)
            $sql = 'INSERT INTO '.$tableName.' (`student_id`, `criteria_id`, `content_regis`, `self_assessment`, `mark_student`, `mark_classroom`, `mark_faculty`, `mark_school`, `created_at`, `updated_at`) VALUES ';
        else
            $sql = 'INSERT INTO '.$tableName.' (`student_id`, `criteria_id`, `self_assessment`, `mark_student`, `mark_classroom`, `mark_faculty`, `mark_school`, `created_at`, `updated_at`) VALUES ';

        for ($i=0; $i < $count; $i++) {
            $sql .= '(\''.$request->student_id.'\', \''.$dataCriteria['criteria_id'][$i].'\', ';
            if($isCriSelf) $sql .= '\''.$dataCriteria['content_regis'][$i].'\', ';
            $sql .= '\''.$dataCriteria['self_assessment'][$i].'\', ';
            $sql .= '\''.$dataCriteria['mark_student'][$i].'\', ';
            $sql .= '\''.$dataCriteria['mark_classroom'][$i].'\', ';
            $sql .= '\''.$dataCriteria['mark_faculty'][$i].'\', ';
            $sql .= '\''.$dataCriteria['mark_school'][$i].'\', CURDATE(), CURDATE()),';
        }
        return $sql = rtrim($sql, ",");//remove comma before WHERE
    }

    private function convertUnicode($data){
        // return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}

<?php

use Illuminate\Http\Request;
use App\Student;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Admin
Route::apiResources(['role_admin' => 'API\RoleController']);
Route::apiResources(['user_admin' => 'API\UserController']);
Route::apiResources(['faculty_admin' => 'API\FacultyController']);
Route::apiResources(['classroom_admin' => 'API\ClassRoomController']);
Route::apiResources(['student_admin' => 'API\StudentController']);
Route::apiResources(['criteria_mandatory' => 'API\CriteriaMandatoryController']);
Route::apiResources(['criteria_selfregis' => 'API\CriteriaSelfregisController']);
//-------------------------- cam -------------------------
Route::apiResources(['school_activities' => 'API\SchoolsActivityController']);
Route::apiResources(['self_activities' => 'API\SelfActivityController']);
Route::apiResources(['temps' => 'API\TempController']);

//__________________________ Event _______________________________

Route::get('/createEvaluationEvent/{id}/{year}', 'API\EventController@createEvaluationEvent');
Route::get('/getTotalStudent', 'API\EventController@getTotalStudent');
Route::get('/getCurrentScoreboard/{year}', 'API\EventController@getCurrentScoreboard');
Route::get('/getMissCurrentScoreboard/{year}', 'API\EventController@getMissCurrentScoreboard');

// _________________________ score board __________________________
    Route::apiResources(['score_board' => 'API\ScoreBoardController']);
    Route::get('/showScore/{student_id}/{currentYear}','API\ScoreBoardController@showScore');
    Route::post('/storeSchoolsActivitiesScore/{scoreBoard_id}/{schoolsActivity_id}','API\ScoreBoardController@storeSchoolsActivityScore');
    Route::put('/updateSchoolsActivitiesScore/{scoreBoard_id}/{schoolsActivity_id}','API\ScoreBoardController@updateSchoolsActivityScore');
    Route::post('/storeSelfActivitiesScore/{scoreBoard_id}/{selfActivity_id}','API\ScoreBoardController@storeSelfActivityScore');
    Route::put('/updateSelfActivitiesScore/{scoreBoard_id}/{selfActivity_id}','API\ScoreBoardController@updateSelfActivityScore');

    Route::get('/getReportByClassID/{class_id}', 'API\ScoreBoardController@getReportByClassID');
    Route::get('/getReportByFaculty/{fac_id}', 'API\ScoreBoardController@getReportByFaculty');
    Route::get('/getReportBySchool', 'API\ScoreBoardController@getReportBySchool');

    Route::get('/getMyTaskByClassID/{class_id}', 'API\ScoreBoardController@getMyTaskByClassID');
    Route::get('/getMyTaskByFaculty/{fac_id}', 'API\ScoreBoardController@getMyTaskByFaculty');
    Route::get('/getMyTaskBySchool', 'API\ScoreBoardController@getMyTaskBySchool');

    Route::get('/getStatisticScoreBoard/{year}', 'API\ScoreBoardController@getStatisticScoreBoard');
    Route::get('/getAllAvgScoreYear', 'API\ScoreBoardController@getAllAvgScoreYear');

//____________________________ image ______________________________

    Route::put('/moveImage','API\ImageController@moveImage');
    Route::get('/showImagesSchoolActivity/{id}','API\ImageController@showImagesSchoolActivity');
    Route::get('/showImagesSelfActivity/{id}','API\ImageController@showImagesSelfActivity');
    Route::post('/storeImagesSchoolActivity/{id}/{name}','API\ImageController@storeImagesSchoolActivity');
    Route::post('/storeImagesSelfActivity/{id}/{name}','API\ImageController@storeImagesSelfActivity');
    Route::delete('/deleteImagesSchoolActivity/{name}','API\ImageController@deleteImagesSchoolActivity');

//____________________________ end image __________________________

//--------------------------- end cam --------------------------------------------

//Client
//Faculty
Route::get('/getSchoolLeaderAccs', 'API\FacultyController@getSchoolLeaderAccs');
Route::get('/getAllFaculties', 'API\FacultyController@getAllFaculties');
Route::get('/findFaculty', 'API\FacultyController@search');

//ClassRoom
Route::get('/getFacultyLeaderAccs/{faculty_id}', 'API\FacultyController@getFacultyLeaderAccs');
Route::get('/getClassroomsClient/{faculty_id}', 'API\ClassRoomController@index_client');
Route::get('/getAllClassrooms', 'API\ClassRoomController@getAllClassrooms');
Route::get('/findClassroom', 'API\ClassRoomController@search');
Route::get('/findClassroomAdmin', 'API\ClassRoomController@searchByAdmin');

//Student
Route::get('/getClassroomAccs/{classroom_id}', 'API\ClassRoomController@getClassroomAccs');
Route::get('/getStudentsClient/{classroom_id}', 'API\StudentController@index_client');
Route::put('/updateProfile', 'API\StudentController@updateProfile');
Route::post('/createStudent', 'API\StudentController@store');
Route::get('/findStudent', 'API\StudentController@search');
Route::get('/findStudentAdmin', 'API\StudentController@searchByAdmin');

//get user student info by user_id
Route::get('/getUserStudentInfoByUserId/{user_id}', 'API\UserController@getUserStudentInfoByUserId');
//get user student info by student_id
Route::get('/getUserStudentInfoByStuId/{student_id}', 'API\UserController@getUserStudentInfoByStuId');
Route::get('/getRelationsByStuId/{student_id}', 'API\StudentController@getRelationsByStuId');

//get role
Route::get('/indexWithoutSchoolLeaderAccs', 'API\RoleController@indexWithoutSchoolLeaderAccs');

//Criteria evaluation
Route::get('/getMarkCriMan/{student_id}', 'API\StudentCriteriaMandatoryController@show');
Route::get('/getMarkCriSel/{student_id}', 'API\StudentCriteriaSelregisController@show');
Route::post('/submitEvaluation', 'API\SubmitEvaluationInfoController@submitEvaluation');

Route::get('/getStatisticClassroomDetail/{classroom_id}', 'API\StudentController@getStatisticClassroomDetail');
Route::get('/getStatisticClassroomDashboard/{classroom_id}', 'API\StudentController@getStatisticClassroomDashboard');

Route::get('/getStatisticFacultyDetail/{faculty_id}', 'API\ClassRoomController@getStatisticFacultyDetail');
Route::get('/getStatisticFacultyDashboard/{faculty_id}', 'API\ClassRoomController@getStatisticFacultyDashboard');

Route::get('/findEvaluateClassroomStatistic', 'API\StudentController@findEvaluateClassroomStatistic');

//blahblah
Route::get('/allblahblah', function(){
    return Student::where('class_room_id', '15DTH12')->latest()->get()->chunk(50);
});

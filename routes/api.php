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

//Client
//Faculty
Route::get('/getSchoolLeaderAccs', 'API\FacultyController@getSchoolLeaderAccs');
Route::get('/getAllFaculties', 'API\FacultyController@getAllFaculties');

//ClassRoom
Route::get('/getFacultyLeaderAccs/{faculty_id}', 'API\FacultyController@getFacultyLeaderAccs');
Route::get('/getClassroomsClient/{faculty_id}', 'API\ClassRoomController@index_client');
Route::get('/getAllClassrooms', 'API\ClassRoomController@getAllClassrooms');

//Student
Route::get('/getClassroomAccs/{classroom_id}', 'API\ClassRoomController@getClassroomAccs');
Route::get('/getStudentsClient/{classroom_id}', 'API\StudentController@index_client');
Route::put('/updateProfile', 'API\StudentController@updateProfile');

//get user student info by user_id
Route::get('/getUserStudentInfoByUserId/{user_id}', 'API\UserController@getUserStudentInfoByUserId');
//get user student info by student_id
Route::get('/getUserStudentInfoByStuId/{student_id}', 'API\UserController@getUserStudentInfoByStuId');
Route::get('/getRelationsByStuId/{student_id}', 'API\StudentController@getRelationsByStuId');

//get role
Route::get('/indexWithoutSchoolLeaderAccs', 'API\RoleController@indexWithoutSchoolLeaderAccs');
Route::get('/allblahblah', function(){
    return Student::where('class_room_id', '15DTH12')->latest()->get()->chunk(50);
});
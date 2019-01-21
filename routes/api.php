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
Route::apiResources(['role_admin' => 'RoleController']);
Route::apiResources(['user_admin' => 'UserController']);
Route::apiResources(['faculty_admin' => 'FacultyController']);
Route::apiResources(['classroom_admin' => 'ClassRoomController']);
Route::apiResources(['student_admin' => 'StudentController']);

//Client
//Faculty
Route::get('/getSchoolLeaderAccs', 'FacultyController@getSchoolLeaderAccs');
Route::get('/getAllFaculties', 'FacultyController@getAllFaculties');

//ClassRoom
Route::get('/getFacultyLeaderAccs/{faculty_id}', 'FacultyController@getFacultyLeaderAccs');
Route::get('/getClassroomsClient/{faculty_id}', 'ClassRoomController@index_client');
Route::get('/getAllClassrooms', 'ClassRoomController@getAllClassrooms');

//Student
Route::get('/getClassroomAccs/{classroom_id}', 'ClassRoomController@getClassroomAccs');
Route::get('/getStudentsClient/{classroom_id}', 'StudentController@index_client');
Route::put('/updateProfile', 'StudentController@updateProfile');

//get user student info by user_id
Route::get('/getUserStudentInfoByUserId/{user_id}', 'UserController@getUserStudentInfoByUserId');
//get user student info by student_id
Route::get('/getUserStudentInfoByStuId/{student_id}', 'UserController@getUserStudentInfoByStuId');
Route::get('/getRelationsByStuId/{student_id}', 'StudentController@getRelationsByStuId');

//get role
Route::get('/indexWithoutSchoolLeaderAccs', 'RoleController@indexWithoutSchoolLeaderAccs');
Route::get('/allblahblah', function(){
    return Student::where('class_room_id', '15DTH12')->latest()->get()->chunk(50);
});
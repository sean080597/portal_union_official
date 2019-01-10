<?php

use Illuminate\Http\Request;

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

Route::apiResources(['role_admin' => 'RoleController']);
Route::apiResources(['user_admin' => 'UserController']);
Route::apiResources(['faculty_admin' => 'FacultyController']);
Route::apiResources(['classroom_admin' => 'ClassRoomController']);

Route::get('/getSchoolAccounts', 'FacultyController@getSchoolAccounts');
Route::get('/getUserStudentInfo/{user_id}', 'UserController@getUserStudentInfo');
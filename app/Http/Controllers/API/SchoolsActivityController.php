<?php

namespace App\Http\Controllers\API;

use App\SchoolsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolsActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SchoolsActivity::oldest('title')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SchoolsActivity::create($request->all());
        return response(['result' => 'Tạo thành công'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolsActivity  $schoolsActivity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schoolsActivity = SchoolsActivity::findOrFail($id);
        return $schoolsActivity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolsActivity  $schoolsActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schoolsActivity = SchoolsActivity::findOrFail($id);
        $schoolsActivity->update($request->all());
        return response(['result' => 'Cập nhật thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolsActivity  $schoolsActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolsActivity = SchoolsActivity::findOrFail($id);
        $schoolsActivity->delete();
        return response(['result' => 'Đã xóa thành công'],200);
    }
}

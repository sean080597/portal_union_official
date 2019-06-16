<?php

namespace App\Http\Controllers\API;

use App\SelfActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelfActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SelfActivity::oldest('title')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SelfActivity::create($request->all());
        return response(['result' => 'Tạo thành công'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SelfActivity  $selfActivity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $selfActivity = SelfActivity::findOrFail($id);
        return $selfActivity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SelfActivity  $selfActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $selfActivity = SelfActivity::findOrFail($id);
        $selfActivity->update($request->all());
        return response(['result' => 'Cập nhật thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SelfActivity  $selfActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $selfActivity = SelfActivity::findOrFail($id);
        $selfActivity->delete();
        return response(['result' => 'Đã xóa thành công'],200);
    }
}

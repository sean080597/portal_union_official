<?php

namespace App\Http\Controllers\API;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role){
        return $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->role->oldest('name')->get();
    }

    public function indexWithoutSchoolLeaderAccs()
    {
        return Role::whereNotIn('id', ['sec', 'de1', 'de2'])->orderBy('name', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->role->create($request->all());
        return response([
            'result' => 'Tạo thành công'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return $role;
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
       $role = Role::findOrFail($id);
       $role->update($request->all());
        return response([
            'result' => 'Cập nhật thành công.'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response([
            'result' => 'Đã xóa'
        ],200);
    }
}

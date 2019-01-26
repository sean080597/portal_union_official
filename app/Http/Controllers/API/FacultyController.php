<?php

namespace App\Http\Controllers\API;

use App\Faculty;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');
        return Faculty::with('secretary')->orderBy('name', 'ASC')->paginate(10);
        // if (Gate::allows('isAccFaculty')) {
        //     return Faculty::with('secretary')->orderBy('name', 'ASC')->paginate(10);
        // }else{
        //     abort(403);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string|max:4|unique:faculties',
            'name' => 'required|string|max:50',
            'note' => 'max:20',
        ]);

        return Faculty::create([
            'id' => $request['id'],
            'name' => $request['name'],
            'note' => $request['note'],
        ]);
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
    public function update(Request $request, $idToUpdate)
    {
        $fa = Faculty::findOrfail($idToUpdate);
        //unique faculty_id --> no space
        $this->validate($request, [
            'id' => 'required|string|max:4|unique:faculties,id,'.$fa->id,
            'name' => 'required|string|max:50',
            'note' => 'max:20',
        ]);
        $fa->update($request->all());
        return ['message' => 'Updated Faculty'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($faculty_id)
    {
        Faculty::findOrfail($faculty_id)->delete();
        return ['message' => 'Deleted Faculty'];
    }

    //get account type in secretary, deputy_secretary
    public function getSchoolLeaderAccs(){
        return User::whereIn('role_id', ['sec', 'de1', 'de2'])->get();
    }

    //get account type in secretary, deputy_secretary
    public function getFacultyLeaderAccs($faculty_id){
        return Faculty::with(['secretary', 'deputySecretary1', 'deputySecretary2'])->findOrFail($faculty_id);
    }

    //get all faculties
    public function getAllFaculties(){
        return Faculty::orderBy('name', 'ASC')->get();
    }
}

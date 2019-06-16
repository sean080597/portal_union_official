<?php

namespace App\Http\Controllers\API;

use App\Image;
use App\ScoreboardSchoolsactivity;
use App\ScoreboardSelfactivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
class ImageController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    public function showImagesSchoolActivity($id){
        $school = ScoreboardSchoolsactivity::find($id);
        $images = $school->images()->get();
        return $images;
    }

    public function showImagesSelfActivity($id){
        $self = ScoreboardSelfactivity::find($id);
        $images = $self->images()->get();
        return $images;
    }
    
    public function storeImagesSchoolActivity($id,$name){
        $school = ScoreboardSchoolsactivity::find($id);
        $image = new Image();
        $image->image = $name;
        $school->images()->save($image);
        return response(['result' => $school],200);
    }

    public function storeImagesSelfActivity($id,$name){
        $self = ScoreboardSelfactivity::find($id);
        $image = new Image();
        $image->image = $name;
        $self->images()->save($image);
        return response(['result' => $self],200);
    }

    public function deleteImagesSchoolActivity($name){
        $image = Image::where('image',$name)->firstOrFail();
        $image->delete();
        return response(['result' => 'Deleted'],200);
    }

    public function moveImage(Request $request)
    {
        if($request->image){
            $name = time() . '.' . explode('/', explode(':', substr($request->image,0,strpos($request->image,';')))[1])[1];
            \Image::make($request->image)->save(public_path('theme/activity_images/').$name);
        }
        return response(['result' => $name],200);
    }
}

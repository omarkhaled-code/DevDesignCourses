<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( $id )
    {
        return view('course.videos.create',['id'=> $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        
        $incomingFields = $request->validate([
            'course_id' => "required",
            'name' => "required",
            'video' => "required|file|mimes:mp4",
        ]);
        

        if($request->has('image')) {
            $image = $request->image;
            $newImg = time().$image->getClientOriginalName();
            $image->move('assets/courses/imgs',$newImg);
            $incomingFields['image'] = "assets/courses/imgs/".$newImg;
        }
        
        if($request->has('description')) {
            $incomingFields['description'] = $request->description;
        }


        $video = $request->file('video');
        $videoSize = $video->getSize();
        $sizeInMega = $videoSize / 1024/ 1024;
        $path = Storage::putFile('videos',$video);
        $videoModel = new Videos();
        $videoModel->name = $incomingFields['name'];
        
        if($request->has('image')) {
            $videoModel->image = $incomingFields['image'];
        }

        
        $videoModel->video = $path;
        $videoModel->course_id = $incomingFields['course_id'];
        if($request->has('description')) {
            $videoModel->description = $incomingFields['description'];
        }

        
        

        $videoModel->save();
        
        return redirect("/course-info/{$videoModel->course_id}");        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $video = Videos::where('id', $id)->get()->first();

        $videos = Videos::where('course_id',$video->course_id)->get();
        $userId = auth()->user()->id;
        if($video->course->created_by == $userId) {
            return view("course.videos.show", ['video' => $video, 'videos' => $videos, 'access' => 'teacher']);   
        }

         return view("course.videos.show", ['video' => $video, 'videos' => $videos, 'access' => 'null']);
    }

    public function streamVideo($id) {

        $video = Videos::where('id', $id)->get()->first();

        $video = Videos::findOrFail($id);
        


       $filContents = Storage::get($video->video);
       $response = Response::make($filContents, 200);
       $response->header('Content-Type', 'video/mp4');
       return $response;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videos $videos)
    {

        $userId = auth()->user()->id;
        $course_id = $videos->course->id;
        if($videos->course->creator->id == $userId) 
            return view('course.videos.update',['video' => $videos, 'course_id' =>  $course_id]);
    
        else 
            return view('course.videos.update', ['video'=> '']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videos $videos)
    {

        
        $incomingFields = $request->validate([
            'course_id' => "required",
            'name' => "required",
        ]);
        

        if($request->has('image')) {
            $image = $request->image;
            $newImg = time().$image->getClientOriginalName();
            $image->move('assets/courses/imgs',$newImg);
            $incomingFields['image'] = "assets/courses/imgs/".$newImg;
        }
        
        if($request->has('description')) {
            $incomingFields['description'] = $request->description;
        }


        if($request->has('video')) {
          
        $request->validate([
            'video' => "required|file|mimes:mp4",
        ]);
        $video = $request->file('video');
        $videoSize = $video->getSize();
        $sizeInMega = $videoSize / 1024/ 1024;
        $path = Storage::putFile('videos',$video);
        $videoModel = new Videos();
        $videoModel->name = $incomingFields['name'];
        
        if($request->has('image')) {
            $videoModel->image = $incomingFields['image'];
        }

    
        $videoModel->video = $path;
        $videoModel->course_id = $incomingFields['course_id'];
        if($request->has('description')) {
            $videoModel->description = $incomingFields['description'];
        }

        

        
        $videos->update($videoModel);
        }
        $videos->update($incomingFields);
        
        return redirect("/course-info/{$request->course_id}")->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videos $videos)
    {
        $videos->delete();
        return redirect('/my_courses')->with('msg', 'deleted successfully');
    }
}

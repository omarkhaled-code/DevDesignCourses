<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\User;
use App\Models\Like;

use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Courses::all();
        return view('users_pages.home', ['courses' => $courses]);
    }
    public function myCourses()
    {
        if (auth()->user()->access == 'teacher') {
            $courses = [];
            $created_by = auth()->user()->id;
            $courses = auth()->user()->coursesCreated()->get();
            return view('users_pages.myCourses', ['courses' => $courses]);
        } else {

            // $courses = auth()->user()->coursesParticipated()->first();

            $courses = [];
            $student = auth()->user();
            // $students = User::with('coursesParticipated')->find($studentId);
            $courses = $student->coursesParticipated()->get();

            if ($courses->isEmpty()) {

                return view('users_pages.myCourses', ['courses' => $courses]);
            } else {

                return view('users_pages.myCourses', ['courses' => $courses]);
            }
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->access == "teacher") {
            return view('course.create');
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $incomingFiled = $request->validate([
            'title' => 'required',
            'description' => ['max:500'],
            'image' => ['image', 'required'],
        ]);


        $image = $request->image;
        $newImg = time() . $image->getClientOriginalName();
        $image->move('assets/courses/imgs', $newImg);

        $incomingFiled['image'] = "assets/courses/imgs/" . $newImg;
        $incomingFiled['title'] = strip_tags($incomingFiled['title']);
        $incomingFiled['description'] = strip_tags($incomingFiled['description']);
        $incomingFiled['created_by'] = auth()->user()->id;


        Courses::create($incomingFiled);
        return redirect('/')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Courses $courses)
    {

        $userId = auth()->user()->id;
        if ($courses->creator->id === $userId) {
            return view('course.show', ['course' => $courses, 'access' => 'teacher']);
        } else {
            foreach ($courses->students as $student) {
                if ($student->id == $userId) {
                    return view('course.show', ['course' => $courses, 'access' => 'student']);
                }
            }
        }

        return view('course.show', ['course' => $courses, 'access' => 'null']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courses $courses)
    {
        if (auth()->user()->access = "teacher")
            return view('course.update', ['course' => $courses]);

        else
            return view('course.update', ['course' => '']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courses $courses)
    {
        $incomingFiled = $request->validate([
            'title' => 'required',
            'description' => ['max:500'],

        ]);

        if ($request->has('image')) {

            $image = $request->image;
            $newImg = time() . $image->getClientOriginalName();
            $image->move('assets/courses/imgs', $newImg);
            $incomingFiled['image'] = "assets/courses/imgs/" . $newImg;
        }

        $incomingFiled['title'] = strip_tags($incomingFiled['title']);
        $incomingFiled['description'] = strip_tags($incomingFiled['description']);
        $incomingFiled['created_by'] = auth()->user()->id;

        $courses->update($incomingFiled);


        return redirect('/my_courses')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courses $courses)
    {
        $courses->delete();
        return redirect('/my_courses')->with('msg', 'deleted successfully');
    }


    public function likeCourse($id)
    {



        $course = Courses::find($id);


        $user = auth()->user();
        $like = $user->likes()->where('likeable_id', $course->id)->where('likeable_type', get_class($course))->first();

        if (!$like) {


            $data = [
                'user_id' => $user->id,
                'likeable_type' => get_class($course),
                'likeable_id' => $course->id,
            ];

            $isDefined = Like::where('likeable_id', $course->id)->get();
            if (!$isDefined->count() > 0) {
                $course->likes()->create($data);
            }
            return back();
        }
        // if(!$courses->likes()->where('user_id',$user->id)->exists()) {
        //     $courses->likes()->create(['user_id'=>$user->id]);
        // }
        // return back();
    }

    public function unlikeCourse(Request $request, $id)
    {
        $course = Courses::find($id);

        $user = auth()->user();
        $like = $course->likes()->where('likeable_id', $id)->where('likeable_type', get_class($course))->first();



        if ($like) {
            $like->delete();
        }
        return back();
    }



    public function showLikedCourses(Request $request)
    {

        $user = auth()->user();
        $likedCourses = $user->likes()->with('likeable')->get()->pluck('likeable');

        $likes = Like::where('user_id', $user->id)->get();

        return view('users_pages.liked-courses', ['likes' => $likes]);
    }


    public function search(Request $request)
    {


        $searchData = $request->search;
        $courses = Courses::all();
        $filterCourses = Courses::where('title', 'like', "%$searchData%")
            ->orWhere('description', 'like', "%$searchData%")->get();


        if ($filterCourses->count() > 0) {
            return view('users_pages.home')->with(
                ['courses' => $filterCourses]
            );
        } else {

            return redirect('.')->with(['msg' => "the $searchData is not defined", 'courses' => $courses]);
        }
    }


    public function autoCompleteSearch()
    {

        $courses = Courses::all();
        $data = [];

        foreach ($courses as $course) {
            $data[] = $course['title'];
        }
        return $data;
    }
}

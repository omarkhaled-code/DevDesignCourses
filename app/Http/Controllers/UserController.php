<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Courses;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $incomingField = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'access' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:40'],
        ]);


        if ($request->has('image')) {
            $image = $request->image;
            $newImg = time() . $image->getClientOriginalName();
            $image->move('assets/imgs', $newImg);
            $incomingField['image'] = 'assets/imgs/' . $newImg;
        }

        $incomingField['password'] = bcrypt($incomingField['password']);

        $user = User::create($incomingField);
        auth()->login($user);

        return redirect()->back()->with('user', $user);
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
    public function login(Request $request)
    {
        $incomingField = $request->validate([
            'email' => ['email', 'required'],
            'password' => ['min:8', 'required'],
        ]);


        if (auth()->attempt(['email' => $incomingField['email'], 'password' => $incomingField['password']])) {

            $request->session()->regenerate();
            return redirect('/')->with('msg', ' login successfully!');
        }

        return redirect('/')->with(['msg' => "Invalid email/password"]);
    }
    public function update(User $user)
    {
        return view('users_pages.registration.update', compact('user'));
    }

    public function store(User $user, Request $request)
    {
        $incomingField = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'access' => 'required',
            'email' => 'required',
        ]);

        if (!is_null($request->old_password)) {
            if (auth()->attempt(['email' => $incomingField['email'], 'password' => $request['old_password']])) {
                $request['password'] = bcrypt($request['password']);
            } else {
                return redirect('/');
            }
        }
        if ($request->has('image')) {
            $image = $request->image;
            $newImg = time() . $image->getClientOriginalName();
            $image->move('assets/imgs', $newImg);
            $incomingField['image'] = 'assets/imgs/' . $newImg;
        }

        $user->update($incomingField);
        return redirect('/');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect('/');
    }

    public function subscription(Courses $courses)
    {

        $studentId = auth()->user()->id;

        $authorCourseId = Courses::where('created_by', $studentId)->get();



        if ($courses->students->count() > 0) {


            $coursesCount = $courses->students->count();
            $status = false;
            for ($i = 0; $i < $coursesCount; $i++) {

                if ($courses->students[$i]->pivot->student_id == $studentId || $authorCourseId->count() > 0) {

                    $status = true;
                } else {

                    $status = false;
                }
            }
            if ($status) {
                return redirect('/')->with('msg', 'some thing is wrong!');
            } else {
                $courses->students()->attach($studentId);
                return redirect('/')->with('msg', 'buying successfully');
            }
        } else {
            $courses->students()->attach($studentId);
            return redirect('/')->with('msg', 'buying successfully');
        }
    }

    public function unSubscription(Courses $courses)
    {
        $studentId = auth()->user()->id;

        $coursesCount = $courses->students->count();

        if ($coursesCount > 0) {

            $status = false;

            for ($i = 0; $i < $coursesCount; $i++) {

                if ($courses->students[$i]->pivot->student_id == $studentId) {

                    $status = true;
                } else {

                    $status = false;
                }
            }
            if ($status) {

                $courses->students()->detach($studentId);
                return redirect('/')->with('msg', 'Un Subscription Successfully!');
            }
        } else {
            return redirect('/')->with('msg', 'buying the course first!');
        }
    }
}

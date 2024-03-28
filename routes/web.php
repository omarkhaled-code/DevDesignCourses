<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\VideosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[CoursesController::class, 'index']);

// Route::get('/my_courses', function () {
//     return view('users_pages.myCourses');
// });

Route::get('/my_courses',[CoursesController::class, 'myCourses']);


Route::get('/profile', function () {
    return view('users_pages.profile');
});


Route::get('/setting', function () {
    return view('users_pages.setting');
});







// Route::get('/update-profile', function () {
//     return view('users_pages.registration.update');
// });

Route::post('/register', [UserController::class, 'register']);
Route::delete('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/update-profile/{user}', [UserController::class, 'update']);
Route::put('/store-profile/{user}', [UserController::class, 'store']);
Route::delete('/delete-profile/{user}', [UserController::class, 'delete']);
Route::get('/subscription/{courses}', [UserController::class, 'subscription']);
Route::delete('/un-subscription/{courses}', [UserController::class, 'unSubscription']);


//courses routes
Route::get('/create-course', [CoursesController::class, 'create']);
Route::post('/create-course', [CoursesController::class, 'store']);
Route::get('/course-info/{courses}', [CoursesController::class, 'show']);
Route::get('/getStudentsCourse/{courses}', [CoursesController::class, 'show']);
Route::delete('/delete-course/{courses}', [CoursesController::class, 'destroy']);
Route::get('/update-course/{courses}', [CoursesController::class, 'edit']);
Route::put('/update-course/{courses}', [CoursesController::class, 'update']);
//search route
Route::get('/autoComplete-search', [CoursesController::class, 'autoCompleteSearch']);
Route::get('/search-course', [CoursesController::class, 'search']);




//videos routes
Route::get('/add-video/{id}', [VideosController::class, 'create']);
Route::post('/add-video', [VideosController::class, 'store']);
Route::get('/show-video/{id}', [VideosController::class, 'show']);
Route::delete('/delete-video/{videos}', [VideosController::class, 'destroy']);
Route::get('/update-video/{videos}', [VideosController::class, 'edit']);
Route::put('/update-video/{videos}', [VideosController::class, 'update']);


Route::get('/videos/{id}/stream', [VideosController::class, 'streamVideo']);
// Route::get('/getStudentsCourse/{courses}', [CoursesController::class, 'show']);



//courses liked routes
Route::post('/courses/{course}/like',[CoursesController::class,'likeCourse'])->name('courses.like');
Route::delete('/courses/{course}/unlike',[CoursesController::class,'unlikeCourse'])->name('courses.unlike');
Route::get('/users/liked-courses',[CoursesController::class,'showLikedCourses'])->name('users_pages.liked-courses');
// Route::get('/showLikedCourses', [CoursesController::class, 'showLikedCourses']);




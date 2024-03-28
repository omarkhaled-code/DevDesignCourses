@extends('users_pages.layout')


{{-- links --}}
@section('title')
    My Courses
@endsection

{{-- links --}}
@section('links')
    <li>
    <a href="/">
        <i class="fa-solid fa-home fa-fw"></i>
        <span>Home</span>
    </a>
    </li>
    <li class="active">
    <a href="/my_courses">
        <i class="fa-solid fa-graduation-cap fa-fw"></i>
        <span>My Courses</span>
    </a>
    </li>
    <li >
    <a href="/profile">
        <i class="fa-regular fa-user fa-fw"></i>
        <span>My Profile</span>
    </a>
    </li>
    <li>
    <a href="/setting">
        <i class="fa-solid fa-gear fa-fw"></i>
        <span>Setting</span>
    </a>
    </li>
    @if (auth()->user())
        @if (auth()->user()->access == 'teacher')
            <li>
                <a href="/create-course">
                <i class="fa-solid fa-diagram-project fa-fw"></i>
                <span>Add Course</span>
                </a>
            </li>
        
        @endif
    @endif
@endsection

{{-- content --}}

@section('content')
<div class="heading">
    <h1>My Courses</h1>
</div>
<div class="courses-container">


    @if ($courses->count() > 0)
            
        @foreach ($courses as $course)

        <div class="course">
            <div class="img">
                <a href="/course-info/{{$course->id}}"><img src="{{$course->image}}" alt="" class="main-img"></a>
                <img src="{{$course->creator->image}}" alt="" class="author-img">
            </div>
            <div class="title">
                <h3>{{$course->title}}</h3>
                
            </div>
            <div class="info">
                <a href="/likes/{{$course->id}}"><i class="fa-regular fa-heart like"></i></a>
                <button class="sub">
                    <a href='/course-info/{{$course->id}}'>View</a>
                </button>
            </div>
        </div>
        @endforeach
    @else 
        <h2 style="position:absolute; margin:10px auto;">You Have no Courses Now</h2>
    @endif
    
</div>
@endsection

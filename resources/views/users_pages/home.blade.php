@extends('users_pages.layout')


{{-- links --}}
@section('title')
    Home
@endsection

{{-- links --}}


@section('links')
    <li class="active">
        <a href="/">
            <i class="fa-solid fa-home fa-fw"></i>
            <span>Home</span>
        </a>
    </li>
    <li>
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
        <h1>Home</h1>
        
    </div>
    @auth
        
    
    <div class="courses-container">

        
        
        @if (session('msg'))
            {{session('msg')}}
        @endif
        
        
            
        
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


                    <?php
                        if($course) {
                            $coursesLikeCount = $course->likes->count();
                            $isLike = false;
                            if($coursesLikeCount > 0) {
                                $isLike = true;
                            }
                        }    
                        ?>       
                        @if ($isLike)
                        
                            <form action="{{route('courses.unlike',$course->id)}}" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="fa-solid fa-heart active"></i>
                                </button>
                            </form>
                        @else 

                            <form action="{{route('courses.like',$course->id)}}" method="POST">
                                @csrf
                                <button type="submit">
                                    <i class="fa-regular fa-heart like"></i>
                                </button>
                            </form>
                        @endif
                    


                    <button class="sub">

                        
                        <?php

                        $studentId = auth()->user()->id;
                        $status = false;
                        if($course->students) {
                                $studentCourseCount = $course->students->count();
                                    if($course->students->count() > 0) {
                                        for($i = 0; $i < $studentCourseCount; $i++) {
                                            if($course->students[$i]->pivot->student_id === $studentId) {
                                                                                    
                                                $status = true;
                                                
                                            }else {
                                                $status = false;                                    
                                            }
                                        }
                                    }
                                }
                                ?>
                                @if ($status)
                                    <a href='/course-info/{{$course->id}}'>View</a>
                                @else 
                                    <a href='/subscription/{{$course->id}}'>Subscripe</a>
                                @endif

                    </button>
                </div>
            </div>
        @endforeach
        @else
        <h1 style="position: absolute;width: calc(100% - 100px); margin: 20px auto;">No Courses Defined</h1>
        @endif
    </div>
    @endauth
@endsection

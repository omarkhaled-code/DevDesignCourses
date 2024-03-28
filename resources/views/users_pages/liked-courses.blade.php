@extends('users_pages.layout')

@section('titel')
    Liked Courses
@endsection

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
@endsection

@section('content')



    <div class="courses-container">
        @if ($likes->count() > 0) 
            
        
            @foreach ($likes as $like)
                    <div class="course">
                        <div class="img">
                            <a href="/course-info/{{$like->likeable->id}}"><img src="{{asset($like->likeable->image)}}" alt="" class="main-img"></a>
                            <img src="{{asset($like->likeable->creator->image)}}" alt="" class="author-img">
                        </div>
                        <div class="title">
                            <h3>{{$like->likeable->title}}</h3>
                            
                        </div>
                        <div class="info">
                            <form action="{{route('courses.unlike',$like->likeable->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="fa-solid fa-heart active"></i>
                                </button>
                            </form>


                            <button class="sub">

                                
                                <?php

                                    $studentCourseCount = $like->likeable->students->count();
                                    $studentId = auth()->user()->id;
                                    $status = false;
                                    
                                    if($like->likeable->students->count() > 0) {
                                        for($i = 0; $i < $studentCourseCount; $i++) {
                                            if($like->likeable->students[$i]->pivot->student_id === $studentId) {
                                                                                    
                                                $status = true;
                                                
                                            }else {
                                                $status = false;                                    
                                            }
                                        }
                                    }

                                        ?>
                                        @if ($status)
                                            <a href='/course-info/{{$like->likeable->id}}'>View</a>
                                        @else 
                                            <a href='/subscription/{{$like->likeable->id}}'>Subscripe</a>
                                        @endif
                                
                                    
                                    
                                
                            </button>
                        </div>
                    </div>

            @endforeach
        @endif
    </div>
@endsection
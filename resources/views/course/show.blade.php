@extends('users_pages.layout')

@section('titel')
     Course Info
@endsection

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


    
    
@endsection

@section('content')
    <div class="show-course">
        <div class="img">
            <img src="{{asset($course->image)}}" alt="">
        </div>
        <div class="info">
            <h3>{{$course->title}}</h3>
            <p>{{$course->description}}</p>
        </div>
        
        @if($access == 'student') 
            <form action="/un-subscription/{{$course->id}}" method="POST">
                @csrf
                @method("DELETE")
                <button class="deleteCourse">UnSubscription</button>
            </form>           
        @endif


        @if ($access== 'teacher')
            <button class="update">
                <a href="/update-course/{{$course->id}}">
                    <i class="fa-solid fa-edit"></i>
                </a>
            </button>
            <form action="/delete-course/{{$course->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="delete">Delete</button>
            </form>
        @endif
    </div>
    <h2 class="videos-container-title">Videos ({{$course->CourseVideos->count()}})</h2>
    <div class="videos-container">
        @if ($access== 'teacher')
        <div class="add-video">
            <a href="/add-video/{{$course->id}}">
                Add New Video
            </a>
        </div>
        @endif
        
        @if ($access == 'teacher' || $access == 'student') 
            @foreach ($course->CourseVideos as $video)
                <div class="video">
                    <a href='/show-video/{{$video->id}}'>
                        {{-- <img src="{{$video->image}}" alt="video img"> --}}
                        
                        @if ($video->image)
                            <img src="{{asset($video->image)}}" alt="">
                        @else
                            <img src="{{asset($course->image)}}" alt="">
                            
                        @endif
                    </a>
                    <h3 class="title">{{$video->name}}</h3>
                </div>
            @endforeach
        @else 
            
        @endif


        
        
      
    </div>

        
    
@endsection

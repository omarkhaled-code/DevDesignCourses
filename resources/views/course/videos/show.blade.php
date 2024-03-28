@extends('users_pages.layout')

@section('titel')
    Video Info
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
<div class='actions'>
    
        @if ($access== 'teacher')
            <button class="update">
                <a href="/update-video/{{$video->id}}">
                    <i class="fa-solid fa-edit"></i>
                </a>
            </button>
            <form action="/delete-video/{{$video->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="delete">Delete</button>
            </form>
        @endif
</div>
    <div class="content-container">
        
        <div class="video-box">
            <h3>{{$video->name}}</h3>

            @if ($video->image)
            <video src="{{url('/videos/'.$video->id.'/stream')}}" poster="{{asset($video->course->image)}}"  type="video/mp4" controls></video>
                
            @else
            <video src="{{url('/videos/'.$video->id.'/stream')}}" poster="{{asset($video->course->image)}}"  type="video/mp4" controls></video>
            @endif
            <div class="info">
                
                <p>{{$video->description}}</p>

            </div>
            

        
        </div>
        <h2 class="other-videos">Other Course Videos</h2>
        <div class="videos-scroll">


            @foreach ($videos as $item)
                @if ($video->id == $item->id)
                    <div class="video active">
                @else 
                <div class="video">
                @endif
                    <a href='/show-video/{{$item->id}}'>
                        
                        @if ($item->image)
                            <img src="{{asset($item->image)}}" alt="">
                        @else
                            <img src="{{asset($item->course->image)}}" alt="">
                        @endif
                    </a>
                    <h3 class="title">{{$item->name}}</h3>
                </div>
            @endforeach
        </div>
    </div>

@endsection
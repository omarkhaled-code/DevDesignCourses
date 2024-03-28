@extends('users_pages.layout')

@section('titel')
    Create Course
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
    
    
    <li>
        <a href="/create-course">
        <i class="fa-solid fa-diagram-project fa-fw"></i>
        <span>Add Course</span>
        </a>
    </li>
        
    
    
@endsection



@section('content')

    <div class="form">
        
        <form action="/update-video/{{$video->id}}" method="post" enctype="multipart/form-data" id="form">
            @csrf

            @method('PUT')

            <input type="text" value="{{$course_id}}" name="course_id" hidden>
            <div class="input">
                <input type="text" name="name" placeholder="Video Title" id="name" value="{{$video->name}}">
            </div>
            <div class="input">
                <textarea name="description" placeholder="Video Description" id="description">{{$video->description}}</textarea>
            </div>
            <div class="img">
                <label for="image">Uploud Image</label>
                <input type="file" name="image" id="image" id="image" value="{{$video->image}}">
            </div>
            <div class="video">
                <label for="video">Uploud Video</label>
                <input type="file" name="video" id="video" value="{{$video->video}}">
                
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
@endsection
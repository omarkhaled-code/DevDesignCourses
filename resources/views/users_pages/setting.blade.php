@extends('users_pages.layout')


{{-- links --}}
@section('title')
    Setting
@endsection

{{-- links --}}
@section('links')
    <li>
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
    <li class="active">
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

<?php $user = auth()->user();?>

    <div class="heading">
        <h1>Setting</h1>
    </div>
    <div class="general-info">
        <div class="header">
            <div class="heading">
                <h3>General Info</h3>
            <p>General Information About Your Account</p>
            </div>
            <div class="img">
                
                      <img src="{{$user->image}}" alt="image">
                
                
            </div>
        </div>

        <div class="info">
            
            <div class="input">
                <label for="name">Name</label>
                <input type="text" name="name" readonly value="{{$user->first_name}} {{$user->last_name}}" id="name">
            </div>
            <div class="input">
                <label for="email">Email</label>
                <input type="text" name="email" readonly value="{{$user->email}}" id="email">
            </div>
        </div>
        <div class="actions">
            
                <a href="/update-profile/{{$user->id}}">Update</a>
            
            <form action="/delete-profile/{{$user->id}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="delelte">Delete Account</button>
            </form>
        </div>
    </div>
@endsection

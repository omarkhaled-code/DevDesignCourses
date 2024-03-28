@extends('users_pages.layout')


{{-- links --}}
@section('title')
    Update
@endsection


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
@endsection

@section('content')
    
<?php $user = auth()->user()?>
<div class="update-profile">
    <form action="/store-profile/{{$user->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h3>Update Account</h3>
            <div class="input">
                <input type="text" name="first_name" placeholder="First Name" value="{{$user->first_name}}">
                <input type="text" name="last_name" placeholder="Last Name" value="{{$user->last_name}}">
            </div>
            <div class="input">
                <input type="text" name="phone" placeholder="Phone Number" value="{{$user->phone}}">
                <input type="email" name="email" placeholder="Email" value="{{$user->email}}" readonly>
            </div>
            <div class="input">
                <input type="password" name="old_password" placeholder="Old Password">
                <input type="password" name="password" placeholder="New Password">
            </div>
            <div class="select">
                <div class="access">
                    <label for="access">Your Access </label>
                    <select id="access" name="access" >
                        <option value="{{$user->access}}" selected >{{$user->access}}</option>
                        <option value="student" >Student</option>
                        <option value="teacher" >Teacher</option>
                    </select>
                </div>
            </div>

            <div class="input">
                <label for="img" class="img">Uploud Img</label>
                <input type="file" name="image" id="img">
            </div>
        
        <button type="submit">Update</button>
    </form>
</div>
@endsection
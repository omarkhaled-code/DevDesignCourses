<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Dashborad')</title>
        @vite('resources/scss/main.scss')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    </head>
    <body>
        @auth        

            <?php $user = auth()->user()?>
            <nav class="sidebar">
                <div class="name">{{auth()->user()->first_name}}</div>
                <ul class="links">
                    @yield('links')
                </ul>
            </nav>
            <header>
                <div class="search ui-widget">
                    <form action="/search-course" method="GET">
                        
                        
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="search" name="search" placeholder="Type KeyWord" id="search_course" >
                    </form>
                    
                </div>
                <div class="header-info">

                        
                        <form action="/logout" method="POST" class="logout">
                            @csrf
                            @method('DELETE')
                            <button class="yes">Logout</button>
                        </form>

                    
                    
                    <a href="/users/liked-courses"><i class="fa-solid fa-heart like"></i></a>
                    @if (auth()->user()->image)
                        {{-- <a href="/profile"><img src="{{assets($user->image)}}" alt=""></a> --}}
                        <a href="/profile"><img src="{{asset($user->image)}}" alt=""></a>
                    @else
                        
                        
                    @endif
                </div>
            </header>
            

            <div class="container ">
                <div class="layout"></div>
                
                @yield('content')
            </div>
                
            
            @endauth        

            @guest
            
        
        <div class="form-container active" id="form-container">
            <form action="/register" method="POST" class="form-box sign-up" enctype="multipart/form-data">
                @csrf
                <h3>Create Account</h3>
                    <div class="names">
                        <input type="text" name="first_name" placeholder="First Name" required >
                        <input type="text" name="last_name" placeholder="Last Name" required >
                    </div>
                    <input type="text" name="phone" placeholder="Phone Number">
                    <input type="email" name="email" placeholder="Email" required >
                    <input type="password" name="password" placeholder="Password" required >
                    <div class="gender">
                        <label for="gender">Your Gender </label>
                        <select id="gender" name="gender"  required >
                            <option selected value="male">Male</option>
                            <option  value="female">Female</option>
                        </select>
                    </div>
                    <div class="access">
                        <label for="access">Your Access </label>
                        <select id="access" name="access" required >
                            <option value="student" >Student</option>
                            <option value="teacher" >Teacher</option>
                        </select>
                    </div>
                    <label for="img" class="img">Uploud Img</label>
                    <input type="file" name="image" id="img">
                
                <button type="submit">Create</button>
            </form>
            <div class="form-box sign-in">
                <form action="/login" method="post" class="form">
                    @csrf
                    @if (session('msg'))
                        <div class="error">
                            <p>{{session('msg')}}</p>
                        </div>
                        
                    @endif
                    <h3> Sign In</h3>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <p><a href="/forgot-password">Forget Your Password?</a></p>
                    
                    <button>Sign In</button>
                </form>
            </div>
            <div class="toggle-box">
                <div class="sign-up-toggle">
                    <h3>Welcome Back!</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, sunt?</p>
                    <button id="login">Sign In</button>
                </div>


                <div class="sign-in-toggle">
                    <h3>Hello,Fried</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, sunt?</p>
                    <button  id="register">Sign Up</button>
                </div>
            </div>
            <div class="toggle-box-small">

                <div class="toggle-register-small">
                    <button id="small-register">Sign Up</button>
                </div>
                <div class="toggle-login-small">
                    <button id="small-login">Sign In</button>
                </div>
            </div>
        </div>
        
        @endguest
        
        @vite('resources/js/script.js')
        <script>

            
            var avaliableCourses = [];


        
                    $.ajax({
                        method: "GET",
                        url: "/autoComplete-search",

                        success : function (response) {
                            console.log(response);
                            startAutoSearch(response);
                        }
                    })
                
                  function startAutoSearch(avaliableCourses) {
                    $('#search_course').autocomplete({
                        source: avaliableCourses
                    });
                  }
        </script>
        
    </body>
</html>

@yield('script')

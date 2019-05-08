<div class="container-fluid">
    <<nav class="navbar border-warning rounded-bottom border-bottom fixed-top" id="nav">
        <div class="container">
               
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand mb-0 text-warning" href="{{ url('home') }}" role="button">
                        <img src="{{ asset('images/logo.svg') }}" style="height:30%;width:30%;" id="img-logo" alt="" srcset="">
                    </a>

                </ul>
                @if (Auth::check())
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto d-inline">
                    <a href="{{ url('profile') }}" id="user"> {{ Auth::user()->name }}</a>
                    <span style="color:white;font-size:20px;">|</span>
                
                    <span title="Cerrar sesión" style="margin-right: 10px;"> 
                        <a href="{{ url('/logout') }}"> logout </a>
                    </span>
                </ul>
                @endif
                
        </div>
    </nav> 

</div>



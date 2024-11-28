<header id="header" class="header fixed-top d-flex align-items-center">
    <style>
        .loginBtn {
            background-color: #3CC78F;
            color: white;
        }
    </style>
    {{--  !-- Start Logo -->  --}}


    <div class="d-flex align-items-center justify-content-between">
        <a style="justify-content: space-around;" href="{{ route('index') }}" class="logo d-flex align-items-center">
            <img style="width:150px; max-height: 49px;" src="{{ asset('img/logo.png') }}" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>



    <nav class="header-nav ms-auto">


        <form class="loginBtn" action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn loginBtn">
                <i class="fas fa-sign-out-alt"></i> {{ __('messages.LogoutA') }}
            </button>
        </form>




    </nav>

</header>

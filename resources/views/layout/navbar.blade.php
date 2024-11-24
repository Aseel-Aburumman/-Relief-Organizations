<header>
    <style>
        .loginBtn {
            background-color: #3CC78F;
            color: white;
        }

        .loginBtn>a {
            color: white !important;
        }

        .loginBtn:hover {
            background-color: white;
            color: black;
            border: 2px solid #3CC78F;
        }

        .loginBtn>a:hover {
            color: black !important;
        }
    </style>
    <div class="header-area ">
        <div class="header-top_area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-lg-8">
                        <div class="short_contact_list">
                            <ul>
                                <li><a href="#"> <i class="fa fa-phone"></i> +962 (79) 661-5656</a></li>
                                <li><a href="#"> <i class="fa fa-envelope"></i>contact@charifit.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-lg-4">
                        <div class="social_media_links d-none d-lg-block">
                            <a href="{{ url('lang/en') }}">English &nbsp | </a>

                            <a href="{{ url('lang/ar') }}"> العربية</a>
                            @guest
                                <button type="submit" class="btn loginBtn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <a href="{{ route('register.view') }}">Register
                                        Now</a>

                                </button>
                            @else
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn loginBtn">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>

                            @endguest

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="{{ route('index') }}">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ route('index') }}">home</a></li>
                                    <li><a href="About.html">About</a></li>
                                    <li><a href="{{ route('orgnization.all') }}">Our Orgnaization</a></li>


                                    {{--  <li><a href="#">pages <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="elements.html">elements</a></li>
                                            <li><a href="Cause.html">Cause</a></li>
                                        </ul>
                                    </li>  --}}
                                    <li><a href="{{ route('contact') }}">Contact</a></li>
                                    @role('orgnization')
                                        <li><a href="{{ route('need') }}">Make a Donatition</a></li>
                                    @endrole
                                    @role('doner')
                                        <li><a href="{{ route('need') }}">Make a Donatition</a></li>
                                    @endrole
                                </ul>


                            </nav>
                            @guest
                                <div class="Appointment">
                                    <div class="book_btn d-none d-lg-block">
                                        <a href="{{ route('need') }}">Make a Donatition</a>
                                    </div>
                                </div>
                            @endguest
                            @role('orgnization')
                                <div class="Appointment">
                                    <div class="book_btn d-none d-lg-block">
                                        <a href="{{ route('orgnization.dashboard') }}">Dashboard</a>
                                    </div>
                                </div>
                            @endrole
                            @role('doner')
                                <div class="Appointment">
                                    <div class="book_btn  d-lg-block">
                                        <a href="{{ route('doner.dashboard') }}">Dashboard</a>
                                    </div>
                                </div>
                            @endrole

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

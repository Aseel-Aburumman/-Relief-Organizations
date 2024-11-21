<header id="header" class="header fixed-top d-flex align-items-center">

    {{--  !-- Start Logo -->  --}}


    <div class="d-flex align-items-center justify-content-between">
        <a style="justify-content: space-around;" href="{{ route('orgnization.dashboard') }}"
            class="logo d-flex align-items-center">
            <img style="width:150px; max-height: 49px;" src="{{ asset('pic/logoHorizantal.png') }}" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    {{--  !-- End Logo -->  --}}

    {{--  <!-- start Search Bar -->  --}}

    {{--  <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>  --}}

    {{--  <!-- End Search Bar -->  --}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->







            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                    {{--  <img src="{{ url('storage/organization_images/' . $admindata->image) }}" alt="Profile"  --}}
                    <img src="{{ url('storage/organization_images/post_1.png') }}" alt="Profile"
                        class="rounded-circle">

                    {{--  <span class="d-none d-md-block dropdown-toggle ps-2">{{ $admindata->name }}</span>  --}}
                </a>
                {{--  <!-- End Profile Iamge Icon -->  --}}





        </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>

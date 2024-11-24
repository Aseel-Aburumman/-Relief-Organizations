<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @role('orgnization')
            <li class="nav-item">
                <a class="nav-link " href="{{ route('orgnization.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            {{--  <!-- End Dashboard Nav -->  --}}
        @endrole

        @role('doner')
            <li class="nav-item">
                <a class="nav-link " href="{{ route('doner.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            {{--  <!-- End Dashboard Nav -->  --}}
        @endrole

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('orgnization.manage_Needs') }}">
                <i class="bi bi-card-list"></i>
                <span>Needs Control Center</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('orgnization.manage_Needs') }}">
                <i class="bi bi-card-list"></i>
                <span>Organaization Control Center</span>
            </a>
        </li>

        <!-- Add Manage Posts option -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('posts.manage') }}">
                <i class="bi bi-pencil-square"></i>
                <span>Posts Control Center</span>
            </a>
        </li>
        {{--
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Needs Control Center</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>  --}}
        {{--  <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.manage_customers') }}">
                        <i class="bi bi-circle"></i><span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.manage_handymans') }}">
                        <i class="bi bi-circle"></i><span>Manage Handymans</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.manage_store_owners') }}">
                        <i class="bi bi-circle"></i><span>Manage Store Owners</span>
                    </a>
                </li>


        </li>


    </ul>  --}}
        {{--  </li>  --}}





        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->


    </ul>

</aside><!-- End Sidebar-->

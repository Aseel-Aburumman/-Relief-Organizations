<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @role('organization')
            <li class="nav-item">
                <a class="nav-link " href="{{ route('organization.dashboard') }}">
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
        @role('organization')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('organization.manage_Needs') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Needs Control Center</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('donations.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>donations Control Center</span>
                </a>
            </li>

            <!-- Add Manage Posts option -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('posts.manage') }}">
                    <i class="bi bi-pencil-square"></i>
                    <span>Posts Control Center</span>
                </a>
            </li>
            @endrole

            @role('admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('organization.manage_Needs') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Needs Control Center</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('donations.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>donations Control Center</span>
                </a>
            </li>

            <!-- Add Manage Posts option -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('posts.manage') }}">
                    <i class="bi bi-pencil-square"></i>
                    <span>Posts Control Center</span>
                </a>
            </li>
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Organization Control Center</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
             <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            </a>
         <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('organization.manage_organization') }}">
                        <i class="bi bi-circle"></i><span>Manage Organization</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('organization.pending') }}">
                        <i class="bi bi-circle"></i><span>Application center</span>
                    </a>
                </li>



            </ul>


    </ul>
             </li>
        @endrole






        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->


    </ul>

</aside><!-- End Sidebar-->

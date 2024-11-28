<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @role('organization')
            <li class="nav-item {{ Request::routeIs('organization.dashboard') ? 'activeSideBar' : '' }}">
                <a class="nav-link " href="{{ route('organization.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>{{ __('messages.Dashboard') }}</span>
                </a>
            </li>
            {{--  <!-- End Dashboard Nav -->  --}}
        @endrole

        @role('doner')
            <li class="nav-item {{ Request::routeIs('doner.dashboard') ? 'activeSideBar' : '' }}">
                <a class="nav-link " href="{{ route('doner.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>{{ __('messages.Dashboard') }} </span>
                </a>
            </li>
            {{--  <!-- End Dashboard Nav -->  --}}
        @endrole
        @role('organization')
            <li class="nav-item {{ Request::routeIs('organization.manage_Needs') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" href="{{ route('organization.manage_Needs') }}">
                    <i class="bi bi-card-list"></i>
                    <span>{{ __('messages.NeedControlCenter') }} </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('donations.index') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" href="{{ route('donations.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>{{ __('messages.DonationCenter') }} </span>
                </a>
            </li>

            <!-- Add Manage Posts option -->
            <li class="nav-item {{ Request::routeIs('posts.manage') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" href="{{ route('posts.manage') }}">
                    <i class="bi bi-pencil-square"></i>
                    <span>{{ __('messages.PostControlCenter') }} </span>
                </a>
            </li>
        @endrole

        @role('admin')
            {{-- @role('organization') --}}
            <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'activeSideBar' : '' }}">
                <a class="nav-link " href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>{{ __('messages.Dashboard') }}</span>
                </a>
            </li>
            {{--  <!-- End Dashboard Nav -->  --}}
            <li class="nav-item {{ Request::routeIs('organization.manage_Needs') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed " href="{{ route('organization.manage_Needs') }}">
                    <i class="bi bi-card-list"></i>
                    <span>{{ __('messages.NeedControlCenter') }} </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('donations.index') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" href="{{ route('donations.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>{{ __('messages.DonationCenter') }} </span>
                </a>
            </li>

            <!-- Add Manage Posts option -->
            <li class="nav-item {{ Request::routeIs('posts.manage') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" href="{{ route('posts.manage') }}">
                    <i class="bi bi-pencil-square"></i>
                    <span>{{ __('messages.PostControlCenter') }} </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('ManageOrganization') ? 'activeSideBar' : '' }}">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>{{ __('messages.OrganizationControlCenter') }} </span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    </a>
                    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('organization.manage_organization') }}">
                                <i class="bi bi-circle"></i><span>{{ __('messages.ManageOrganization') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('organization.pending') }}">
                                <i class="bi bi-circle"></i><span>{{ __('messages.Applicationcenter') }}</span>
                            </a>
                        </li>



                    </ul>


                </ul>
            </li>
        @endrole






        <li class="nav-heading">{{ __('messages.Pages') }}</li>

        <li class="nav-item {{ Request::routeIs('profile') ? 'activeSideBar' : '' }}">
            <a class="nav-link collapsed" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>{{ __('messages.Profile') }}</span>
            </a>
        </li><!-- End Profile Page Nav -->


    </ul>

</aside><!-- End Sidebar-->

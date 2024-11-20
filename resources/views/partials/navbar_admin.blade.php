<header id="header" class="header fixed-top d-flex align-items-center">

    {{--  !-- Start Logo -->  --}}


    <div class="d-flex align-items-center justify-content-between">
        <a style="justify-content: space-around;" href="{{ route('admin.dashboard') }}"
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

            {{--  <!-- Start Notification Nav -->  --}}
            <li class="nav-item dropdown">
                {{--  <!-- Start Notification Icon -->  --}}
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span
                        class="badge bg-primary badge-number">{{ $adminNotifications->where('is_read', 0)->count() }}</span>
                </a>
                {{--  <!-- End Notification Icon -->  --}}

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have {{ $adminNotifications->where('is_read', 0)->count() }} new notifications
                        <a href="{{ route('admin.notification') }}"><span
                                class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @forelse ($adminNotifications as $notification)
                        <li class="notification-item">
                            @if ($notification->category == 'primary')
                                <i class="bi bi-exclamation-circle text-primary"></i>
                            @elseif ($notification->category == 'success')
                                <i class="bi bi-check-circle text-success"></i>
                            @elseif ($notification->category == 'danger')
                                <i class="bi bi-x-circle text-danger"></i>
                            @elseif ($notification->category == 'warning')
                                <i class="bi bi-info-circle text-warning"></i>
                            @endif
                            <div>
                                <h4>{{ $notification->message }}</h4>
                                <p>{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @empty
                        <li class="notification-item">
                            <div>
                                <h4>No new notifications</h4>
                            </div>
                        </li>
                    @endforelse

                    <li class="dropdown-footer">
                        <a href="{{ route('admin.notification') }}">Show all notifications</a>
                    </li>
                </ul>
                <!-- End Notification Dropdown Items -->
            </li>
            {{--  <!-- End Notification Nav -->  --}}
            {{--  <!-- Start Messages nav -->  --}}
            <li class="nav-item dropdown">
                {{--  <!-- Start Messages Icon -->  --}}
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span
                        class="badge bg-success badge-number">{{ $unreadMessages->where('is_read', 0)->count() }}</span>
                </a>
                {{--  <!-- End Messages Icon -->  --}}

                {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
      <li class="dropdown-header">
        You have {{ $messages->where('is_read', 0)->count() }} new messages
        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>

      @forelse ($messages as $message)
        <li class="message-item">
          <a href="#">
            <img src="assets/img/default-avatar.png" alt="" class="rounded-circle">
            <div>
            <h4>{{ $message->sender->name }}</h4> <!-- Display the sender's name -->
              <p>{{ Str::limit($message->message_content, 50) }}</p>
              <p>{{ $message->created_at->diffForHumans() }}</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
      @empty
        <li class="message-item">
          <div>
            <h4>No new messages</h4>
          </div>
        </li>
      @endforelse

      <li class="dropdown-footer">
        <a href="#">Show all messages</a>
      </li>
    </ul> --}}

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have {{ $unreadMessages->count() }} new messages
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @forelse ($unreadMessages as $unreadMessage)
                        <li class="message-item">
                            <a href="#">
                                <img src="{{ asset('storage/profile_images/' . $unreadMessage->sender->image) }}"
                                    alt="" class="rounded-circle">
                                <div>
                                    <h4>{{ $unreadMessage->sender->name }}</h4>
                                    {{--  <!-- Display the sender's name -->  --}}
                                    <p>{{ Str::limit($unreadMessage->message_content, 50) }}</p>
                                    <p>{{ $unreadMessage->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @empty
                        <li class="message-item">
                            <div>
                                <h4>No new messages</h4>
                            </div>
                        </li>
                    @endforelse

                    <li class="dropdown-footer">
                        <a href="#">Show all messages</a>
                    </li>
                </ul>

                {{--  <!-- End Messages Dropdown Items -->  --}}
            </li>
            {{--  <!-- End Messages nav -->  --}}
            {{--  <!-- End Messages Nav -->  --}}

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{--  <img src="{{ asset('storage/' . $admindata->image) }}" alt="Profile" class="img-thumbnail">  --}}

                    {{--  <img src="{{ asset('storage/' . $admindata->image) }}" alt="Profile" class="rounded-circle">  --}}
                    <img src="{{ url('storage/profile_images/' . $admindata->image) }}" alt="Profile"
                        class="rounded-circle">

                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ $admindata->name }}</span>
                </a>
                {{--  <!-- End Profile Iamge Icon -->  --}}

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ $admindata->name }}</h6>
                        {{--  <span>Web Designer</span>  --}}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    {{--  <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>  --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    {{--
            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>  --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center"
                                style="border:none; background:none;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </li>


                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>

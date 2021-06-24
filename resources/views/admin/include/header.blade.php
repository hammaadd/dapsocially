<div id="main" class='layout-navbar'>
    <header class='mb-3'>
        <nav class="navbar navbar-expand navbar-light shadow-sm ">
            <div class="container-fluid">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                       
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <h6 class="dropdown-header">Notifications</h6>
                                </li>
                                @if (auth()->user()->unreadNotifications)
                                    @foreach (auth()->user()->unreadNotifications as $read)

                                        <li><a class="dropdown-item" href="{{route('notification.read',$read->id)}}">{{ $read->data['data'] }}}</a></li>

                                    @endforeach
                                @else
                                    <li><a class="dropdown-item" href="#">No new notifications</a></li>
                                @endif

                            </ul>
                        </li>
                    </ul>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                    <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <img src="{{ asset('admin/profile/' . Auth::user()->image . '') }}">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('profile.setting') }}"><i
                                        class="icon-mid bi bi-person me-2"></i> My
                                    Profile</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

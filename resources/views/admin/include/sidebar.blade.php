<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <a href="index.html"><img src="{{ asset('admin/assets/images/logo/logo.png') }}" alt="Logo"
                                srcset=""></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{Request::is('dashboard')? 'active' : '' }} ">
                        <a href="{{route('dashboard')}}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{Request::is('short-code')? 'active' : '' }}  ">
                        <a href="{{route('short.code')}}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>short Codes</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item  has-sub {{Request::is('add-roles')? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Roles</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item {{Request::is('add-roles')? 'active' : '' }} ">
                                <a href="{{route('add.roles')}}">Add Roles</a>
                            </li>
                           
                        </ul>
                    </li>
                    
                    <li class="sidebar-item {{Request::is('contactus-list')? 'active' : '' }}  ">
                        <a href="{{route('contactus.list')}}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Contact us</span>
                        </a>
                    </li>
                    <li class="sidebar-item  has-sub {{Request::is('content-form')? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Contents</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item {{Request::is('content-form') ? 'active' : '' }} ">
                                <a href="{{route('content.form')}}">Add Content</a>
                            </li>
                            
                            <li class="submenu-item {{Request::is('show-content')? 'active' : '' }} ">
                                <a href="{{route('show.content')}}">List Contents</a>
                            </li>
                           
                        </ul>
                    </li>

                    

                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>

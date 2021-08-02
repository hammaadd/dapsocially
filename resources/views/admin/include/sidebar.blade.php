<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active shadow-sm">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <a href="{{route('dashboard')}}"><img src="{{ asset('admin/assets/images/logo/logo1.png') }}" alt="Logo" style="height: 40px;"
                                srcset=""></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">

                    <li class="sidebar-title">User</li>
                    <li class="sidebar-item {{Request::is('orders-list')? 'active' : '' }}  ">
                        <a href="{{route('orders.list')}}" class='sidebar-link'>
                            <i class="bi bi-archive-fill"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{Request::is('dashboard')? 'active' : '' }} ">
                        <a href="{{route('dashboard')}}" class='sidebar-link'>
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Users List</span>
                        </a>
                    </li>


                    <li class="sidebar-item  has-sub {{Request::is('add-roles')? 'active' : '' }} {{Request::is('all-roles')? 'active' : '' }} {{Request::is('assignpermission-form')? 'active' : '' }}"  >
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-person-check-fill"></i>
                            <span>Roles</span>
                        </a>

                        <ul class="submenu " style="{{Request::is('add-roles')? 'display:block; ' : '' }} {{Request::is('all-roles')? 'display:block;' : '' }} {{Request::is('assignpermission-form')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('all-roles') ?  'active' : '' }} ">
                                <a href="{{route('all.roles')}}">All Roles</a>
                            </li>
                            <li class="submenu-item {{Request::is('add-roles')? 'active' : '' }} ">
                                <a href="{{route('add.roles')}}">Add Roles</a>
                            </li>
                            <li class="submenu-item {{Request::is('assignpermission-form')? 'active' : '' }} ">
                                <a href="{{route('assignpermission.form')}}">Permission to role</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-title">Contenet Management</li>
                    <li class="sidebar-item  has-sub {{Request::is('content-form')? 'active' : '' }} {{Request::is('show-content')? 'active' : '' }} ">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Contents</span>
                        </a>
                        <ul class="submenu " style="{{Request::is('content-form')? 'display:block; ' : '' }} {{Request::is('show-content')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('content-form') ? 'active' : '' }} ">
                                <a href="{{route('content.form')}}">Add Content</a>
                            </li>

                            <li class="submenu-item {{Request::is('show-content')? 'active' : '' }} ">
                                <a href="{{route('show.content')}}">List Contents</a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item  has-sub {{Request::is('short-code')? 'active' : '' }} {{Request::is('list-shortcode')? 'active' : '' }} ">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-file-code-fill"></i>
                            <span>Short Codes</span>
                        </a>
                        <ul class="submenu " style="{{Request::is('short-code')? 'display:block; ' : '' }} {{Request::is('list-shortcode')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('short-code') ? 'active' : '' }} ">
                                <a href="{{route('short.code')}}">Add short code</a>
                            </li>

                            <li class="submenu-item {{Request::is('list-shortcode')? 'active' : '' }} ">
                                <a href="{{route('list.shortcode')}}">List Short codes</a>
                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-item  has-sub {{Request::is('short-code')? 'active' : '' }} {{Request::is('list-shortcode')? 'active' : '' }} ">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-file-code-fill"></i>
                            <span>Images</span>
                        </a>
                        <ul class="submenu " style="{{Request::is('short-code')? 'display:block; ' : '' }} {{Request::is('list-shortcode')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('short-code') ? 'active' : '' }} ">
                                <a href="{{route('short.code')}}"></a>
                            </li>

                            <li class="submenu-item {{Request::is('list-shortcode')? 'active' : '' }} ">
                                <a href="{{route('list.shortcode')}}">List Short codes</a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-title">Payment Plans</li>
                    <li class="sidebar-item  has-sub {{Request::is('price-packages')? 'active' : '' }} {{Request::is('all-payment_plans')? 'active d-block' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-wallet-fill"></i>
                            <span>Payment Plans</span>
                        </a>

                        <ul class="submenu " style="{{Request::is('all-payment_plans')? 'display:block; ' : '' }} {{Request::is('price-packages')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('all-payment_plans')? 'active ' : '' }} ">
                                <a href="{{route('all.payment_plans')}}">All Payment plans</a>
                            </li>
                            <li class="submenu-item {{Request::is('price-packages')? 'active' : '' }} ">
                                <a href="{{route('price.package')}}">Add Payment plan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-title">Others</li>

                    <li class="sidebar-item {{Request::is('contactus-list')? 'active' : '' }}  ">
                        <a href="{{route('contactus.list')}}" class='sidebar-link'>
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span>Contact us</span>
                        </a>
                    </li>





                    <li class="sidebar-item  has-sub {{Request::is('messages')? 'active' : '' }} {{Request::is('all-messages')? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-wallet-fill"></i>
                            <span>Message for slider</span>
                        </a>

                        <ul class="submenu " style="{{Request::is('messages')? 'display:block; ' : '' }} {{Request::is('all-messages')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('messages')? 'active ' : '' }} ">
                                <a href="{{route('messages')}}">Add message</a>
                            </li>
                            <li class="submenu-item {{Request::is('all-messages')? 'active' : '' }} ">
                                <a href="{{route('all.messages')}}">List all messages</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-item {{Request::is('send-notifications')? 'active' : '' }}  ">
                        <a href="{{route('send-notifications')}}" class='sidebar-link'>
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span>Notification management</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item  has-sub {{Request::is('image-adds')? 'active' : '' }} {{Request::is('video-adds')? 'active d-block' : '' }} {{Request::is('list-adds')? 'active d-block' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-badge-ad-fill"></i>
                            <span>Upload ads</span>
                        </a>

                        <ul class="submenu {{Request::is('image-adds')? 'active ' : '' }}" style="{{Request::is('image-adds')? 'display:block; ' : '' }} {{Request::is('video-adds')? 'display:block;' : '' }} {{Request::is('list-adds')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('image-adds')? 'active ' : '' }} ">
                                <a href="{{route('image.adds')}}">Add image ad</a>
                            </li>
                            <li class="submenu-item {{Request::is('video-adds')? 'active' : '' }} ">
                                <a href="{{route('video.adds')}}">Add video ad</a>
                            </li>
                            <li class="submenu-item {{Request::is('list-adds')? 'active' : '' }} ">
                                <a href="{{route('show.adds')}}">All Ads</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item  has-sub {{Request::is('add-category')? 'active' : '' }} {{Request::is('list-category')? 'active d-block' : '' }} {{Request::is('show-adds')? 'active d-block' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi  bi-basket2-fill"></i>
                            <span>Category</span>
                        </a>

                        <ul class="submenu " style="{{Request::is('add-category')? 'display:block; ' : '' }} {{Request::is('list-category')? 'display:block;' : '' }}">
                            <li class="submenu-item {{Request::is('add-category')? 'active ' : '' }} ">
                                <a href="{{route('add.category')}}">Add Category</a>
                            </li>
                            <li class="submenu-item {{Request::is('list-category')? 'active' : '' }} ">
                                <a href="{{route('list.category')}}">All categories</a>
                            </li>
                            {{-- <li class="submenu-item {{Request::is('show.adds')? 'active' : '' }} ">
                                <a href="{{route('show.adds')}}">All Adds</a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="sidebar-item {{Request::is('layout-control')? 'active' : '' }}  ">
                        <a href="{{route('layout.control')}}" class='sidebar-link'>
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span>Layout Control</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>

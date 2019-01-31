<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HUTECH | DOAN HOI') }}</title>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- @yield('link_css') --}}
</head>
<body>
    <section class="container-fluid">
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="navbar">
            <a href="/" class="navbar-brand mr-auto" style="width:130px">
                <img src="{{ asset('theme/images/logo1.png') }}" alt="Logo" style="width:100%">
            </a>
            <div class="student-info">
                <div class="dropdown">
                    <span>Hi! </span>
                    <button type="button" class="btn dropdown-toggle pr-4" data-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="fas fa-user mr-1"></i>Thông Tin</a>
                        <a href="#" class="dropdown-item"><i class="fas fa-key mr-1"></i>Đổi mật khẩu</a>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                            <i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav><!-- End navbar -->

        <section class="wrapper" id="app">
            <nav id="sidebar">
                <section class="sidebar-header d-flex flex-column align-items-center">
                    <div class="wrap-avatar">
                        <img src="{{ !empty(auth()->user()->image) ? asset('theme/images_profile/'.auth()->user()->image) : asset('theme/images/img_avatar1.png') }}"
                        alt="avatar">
                    </div>
                    <h4>{{ auth()->user()->name }}</h4>
                </section>
                <ul class="list-unstyled components" id="test">
                    <li class="active">
                        <router-link to="/">Trang Chủ</router-link>
                    </li>
                    @can('isAdmin')
                    <li>
                        <router-link to="/developer">Developer</router-link>
                    </li>
                    <li>
                        <a href="#quan-ly-admin" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">Quản lý</a>
                        <ul class="collapse list-unstyled" id="quan-ly-admin">
                            <li><router-link to="/students-admin">Đoàn viên</router-link></li>
                            <li><router-link to="/classrooms-admin">Lớp</router-link></li>
                            <li><router-link to="/faculties-admin">Khoa</router-link></li>
                            <li><router-link to="/users-admin">Tài khoản</router-link></li>
                        </ul>
                    </li>
                    <li><a href="#">Thống Kê</a></li>
                    @endcan
                    <li>
                        <a href="#thong-tin-dv" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">Thông tin đoàn viên</a>
                        <ul class="collapse list-unstyled" id="thong-tin-dv">
                            @cannot('isAdminOrAccSchool')
                                <li><router-link to="/student-profile/{{ auth()->user()->student->id }}">Thông tin cá nhân</router-link></li>
                                @cannot('isAccStudent')
                                <li><router-link to="/students/{{ auth()->user()->student->class_room_id }}">Thông tin lớp</router-link></li>
                                @endcannot
                                @can('isAccFaculty')
                                <li><router-link to="/classrooms/{{ auth()->user()->getFaculty->id }}">Thông tin khoa</router-link></li>
                                @endcan
                            @endcannot
                            @can('isAdminOrAccSchool')
                            <li><router-link to="/faculties">Thông tin trường</router-link></li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="#ql-dv" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                            ĐG đoàn viên
                        </a>
                        <ul class="collapse list-unstyled" id="ql-dv">
                            <li><a href="#">ĐG cá nhân</a></li>
                            <li><a href="#">Lớp quản lý</a></li>
                            <li><a href="#">Khoa quản lý</a></li>
                            <li><a href="#">Trường quản lý</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Hỗ trợ</a></li>
                </ul>
            </nav><!-- End nav sidebar -->
            <div id="content" class="container-fluid">
            <!-- Setting -------------------------------------------------->
            <section class="d-flex" id="nav-setting">
                    <!-- Btn Collapse for sidebar -->
                    <button class="btn btn-primary" type="button" id="sidebarCollapse">
                        <i class="fas fa-align-left"></i>
                        <span id="btn-sidebar">Sidebar</span>
                    </button>
                    <!-- End Collapse Sidebar -->
                    <!-- Breadcrum ------------->
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        {{-- @yield('show_tab') --}}
                    </ul>
                    <!-- End Breadcrum --------->
                </section>
                <!-- End Setting ---------------------------------------------->
                <section class="main-content"><!-- Main content -->

<!---------------------------------------------------------------------------------------------------------->
                    {{-- @yield('content') --}}
                    <router-view :key="$route.fullPath"></router-view>
                    <vue-progress-bar></vue-progress-bar>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------->

                </section><!-- End main content -->
                <section class="footer">
                    <small>Bản quyền của <a href="#">HUTECH</a> - Được phát triển bởi <a href="#">Author</a> &copy; 2018-2019</small>
                </section>
            </div><!-- End content -->
        </section>
    </section>

    @auth
    <script>
        window.user = @json(auth()->user());
        window.stud = @json(auth()->user()->student);
        window.facu = @json(auth()->user()->getFaculty);
        // console.log(@json(auth()->user()->getFaculty));
    </script>
    @endauth

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" defer></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('theme/JS/javascript.js') }}" async></script>
    {{-- @yield('link_js') --}}
</body>
</html>
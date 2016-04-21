 <style type="text/css">
    ul#menu {
        padding: 0;
    }

    ul#menu li {
        display: inline;
    }

    ul#menu li a {
        background-color: black;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px 4px 0 0;
    }

    ul#menu li a:hover {
        background-color: orange;
    }
</style>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Tìm kiếm...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>  
            </li>
            {{-- <li>
                <a href="{{ url('/') }}"><i class="fa fa-home"></i> Dashboard</a>
            </li> --}}
            @can('RoleController.index')
            <li>
                <a href="{{ url('role') }}"><i class="fa fa-lock"></i> Phân quyền</a>
            </li>
            @endcan
            @can('UserController.index')
            <li>
                <a href="#"><i class="fa fa-user"></i> Người dùng<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('user') }}">Danh sách người dùng</a>
                    </li>
                    <li>
                        <a href="{{ url('profile') }}">Hồ sơ của bạn</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('ArticleController.index')
            <li>
                <a href="{{ url('article') }}"><i class="fa fa-book"></i> Bài viết</a>
            </li>
            @endcan
            <li>
                <a href="#"><i class="fa fa-cog"></i> Cài đặt<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('setting-general') }}">Chung</a>
                    </li>
                    <li>
                        <a href="{{ url('setting-permalink') }}">Đường dẫn</a>
                    </li>
                </ul>  
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
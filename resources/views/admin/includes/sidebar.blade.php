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
    <div class="sidebar-nav ">

        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <ul id="menu">
                    @can('UserController.index')
                    <li><a href="{{ url('user') }}" title="Danh sách người dùng"><i class="fa fa-user"></i></a></li>
                    @endcan
                    @can('RoleController.index')
                    <li><a href="{{ url('role') }}" title="Quản lý quyền"><i class="fa fa-lock"></i></a></li>
                    @endcan
                    <li><a href="" title="Thiết lập cấu hình"><i class="fa fa-cog"></i></a></li>
                </ul>  
            </li>
            @can('ArticleController.index')
            <li>
                <a href="{{ url('article') }}"><i class="fa fa-dashboard fa-fw"></i> Bài viết</a>
            </li>
            @endcan
            <li>
                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Menu</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
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
            <ul id="menu">
                <li><a href="{{ url('user') }}"><i class="fa fa-user"></i></a></li>
                <li><a href="{{ url('role') }}"><i class="fa fa-lock"></i></a></li>
                <li><a href=""><i class="fa fa-cog"></i></a></li>
            </ul>  
        </li>

        <li>
            <a href="{{ url('article') }}"><i class="fa fa-dashboard fa-fw"></i> Bài viết</a>
        </li>
        <li>
            <a href="{{asset('/')}}"><i class="fa fa-dashboard fa-fw"></i> Menu</a>
        </li>
    </ul>
</div>
<!-- /.sidebar-collapse -->
</div>
            <!-- /.navbar-static-side -->
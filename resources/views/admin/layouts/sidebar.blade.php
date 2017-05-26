<?php
use App\Models\RoleMenu;
$admin_id = $admin_user->id;

$menuList = RoleMenu::getMenuList($admin_id);
//dd($menuList);
?>


        <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$admin_user->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
       {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <?php if(RoleMenu::hasMenuCategory($menuList,'控制面板','category')): ?>
            <li class="treeview">
                <a href="{{action('Admin\IndexController@getIndex')}}"><i class="fa  fa-home"></i>
                    <span>控制面板</span>
                </a>
            </li>
            <?php endif ?>
            <?php if(RoleMenu::hasMenuCategory($menuList,'用户管理','category')): ?>
            <li class="treeview">
                <a href="{{action('Admin\UserController@getList')}}"><i class="fa  fa-user"></i>
                    <span>用户管理</span>
                </a>
            </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'业务管理','category')): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-briefcase"></i>
                        <span>业务管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if(RoleMenu::hasMenuCategory($menuList,'业务列表','menuName')): ?>
                            <li class="admin-business-list"><a href="{{action('Admin\BusinessController@getList')}}"><i class="fa fa-circle-o"></i>业务列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'添加业务','menuName')): ?>
                            <li class="admin-business-add"><a href="{{action('Admin\BusinessController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加业务</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'点击量查询','menuName')): ?>
                            <li class="admin-business-hitslist"><a href="{{action('Admin\BusinessController@getHitslist')}}"><i class="fa fa-circle-o"></i>点击量查询</a></li>
                        <?php endif ?>
                    </ul>
                </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'信用卡管理','category')): ?>
                <li class="treeview ">
                    <a href="#"><i class="fa fa-credit-card"></i>
                        <span>信用卡管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if(RoleMenu::hasMenuCategory($menuList,'信用卡列表','menuName')): ?>
                            <li class="admin-card-list"><a href="{{action('Admin\CardController@getList')}}"><i class="fa fa-circle-o"></i>信用卡列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'添加信用卡','menuName')): ?>
                            <li class="admin-card-add"><a href="{{action('Admin\CardController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加信用卡</a></li>
                        <?php endif ?>

                    </ul>
                </li>
            <?php endif ?>


            <?php if(RoleMenu::hasMenuCategory($menuList,'渠道管理','category')): ?>
                <li class="treeview ">
                    <a href="#"><i class="fa fa-desktop"></i>
                        <span>渠道管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if(RoleMenu::hasMenuCategory($menuList,'添加渠道','menuName')): ?>
                            <li class="admin-channel-add"><a href="{{action('Admin\ChannelController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加渠道</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'基础渠道列表','menuName')): ?>
                            <li class="admin-channel-list"><a href="{{action('Admin\ChannelController@getList')}}"><i class="fa fa-circle-o"></i>基础渠道列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'生成渠道编号','menuName')): ?>
                            <li class="admin-channel-addno"><a href="{{action('Admin\ChannelController@anyAddno')}}"><i class="fa fa-circle-o"></i>生成渠道编号</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'渠道编号列表','menuName')): ?>
                            <li class="admin-channel-nolist"><a href="{{action('Admin\ChannelController@getNolist')}}"><i class="fa fa-circle-o"></i>渠道编号列表</a></li>
                        <?php endif ?>

                            <?php if(RoleMenu::hasMenuCategory($menuList,'比例设置','menuName')): ?>
                            <li class="admin-channel-nolist"><a href="{{action('Admin\ChannelNoProController@getList')}}"><i class="fa fa-circle-o"></i>比例设置</a></li>
                            <?php endif ?>

                    </ul>
                </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'Banner管理','category')): ?>
                <li class="treeview ">
                    <a href="#"><i class="fa fa-picture-o"></i>
                        <span>Banner管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if(RoleMenu::hasMenuCategory($menuList,'Banner列表','menuName')): ?>
                            <li class="admin-slide-list"><a href="{{action('Admin\SlideController@getList')}}"><i class="fa fa-circle-o"></i>Banner列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'添加Banner','menuName')): ?>
                            <li class="admin-slide-add"><a href="{{action('Admin\SlideController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加Banner</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'Banner分类列表','menuName')): ?>
                            <li class="admin-slidecat-list"><a href="{{action('Admin\SlideCatController@getList')}}"><i class="fa fa-circle-o"></i>Banner分类列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'添加Banner分类','menuName')): ?>
                            <li class="admin-slidecat-add"><a href="{{action('Admin\SlideCatController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加Banner分类</a></li>
                        <?php endif ?>

                    </ul>
                </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'APP日志','category')): ?>
            <li class="treeview">
                <a href="{{action('Admin\AppLogController@getList')}}"><i class="fa  fa-file-text-o"></i>
                    <span>APP日志</span>
                </a>
            </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'及时雨贷款APP','category')): ?>
            <li class="treeview ">
                <a href="#"><i class="fa fa-apple"></i>
                    <span>及时雨贷款APP</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">

                    <?php if(RoleMenu::hasMenuCategory($menuList,'提醒列表','menuName')): ?>
                    <li class="admin-message-list"><a href="{{action('Admin\MessageController@getList')}}"><i class="fa fa-circle-o"></i>提醒列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'意见反馈','menuName')): ?>
                    <li class="admin-feedback-add"><a href="{{action('Admin\FeedBackController@getList')}}"><i class="fa fa-circle-o"></i>意见反馈</a></li>
                    <?php endif ?>

                </ul>
            </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'渠道注册查询','category')): ?>
            <li class="treeview">
                <a href="{{action('Admin\ChannelRegController@getList')}}"><i class="fa  fa-user"></i>
                    <span>渠道注册查询</span>
                </a>
            </li>
            <?php endif ?>

            <?php if(RoleMenu::hasMenuCategory($menuList,'权限管理','category')): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-lock"></i>
                        <span>权限管理</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if(RoleMenu::hasMenuCategory($menuList,'新增管理员','menuName')): ?>
                            <li class="admin-adminuser-add"><a href="{{action('Admin\AdminUserController@anyAdd')}}"><i class="fa fa-circle-o"></i>新增管理员</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'管理员列表','menuName')): ?>
                            <li class="admin-adminuser-list"><a href="{{action('Admin\AdminUserController@getList')}}"><i class="fa fa-circle-o"></i>管理员列表</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'新增角色','menuName')): ?>
                            <li class="admin-role-add"><a href="{{action('Admin\RoleController@anyAdd')}}"><i class="fa fa-circle-o"></i>新增角色</a></li>
                        <?php endif ?>

                        <?php if(RoleMenu::hasMenuCategory($menuList,'角色列表','menuName')): ?>
                            <li class="admin-role-list"><a href="{{action('Admin\RoleController@getList')}}"><i class="fa fa-circle-o"></i>角色列表</a></li>
                        <?php endif ?>

                    </ul>
                </li>
            <?php endif ?>
           {{-- <li class="treeview ">
                <a href="#"><i class="fa  fa-cog"></i>
                    <span>系统设置</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{action('Admin\LoginController@getLoginout')}}"><i class="fa fa-circle-o"></i>退出登录</a></li>
                </ul>
            </li>--}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    function parseURL(url) {
        var a =  document.createElement('a');
        a.href = url;
        return {
            source: url,
            protocol: a.protocol.replace(':',''),
            host: a.hostname,
            port: a.port,
            query: a.search,
            params: (function(){
                var ret = {},
                        seg = a.search.replace(/^\?/,'').split('&'),
                        len = seg.length, i = 0, s;
                for (;i<len;i++) {
                    if (!seg[i]) { continue; }
                    s = seg[i].split('=');
                    ret[s[0]] = s[1];
                }
                return ret;
            })(),
            file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
            hash: a.hash.replace('#',''),
            path: a.pathname.replace(/^([^\/])/,'/$1'),
            relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
            segments: a.pathname.replace(/^\//,'').split('/')
        };
    }
    var myUrl=parseURL(window.location.href);
    var path=myUrl.path;
    path=path.replace(/\//g,'-');
    path=path.substring(1);
    $('.'+path).addClass('active');
    $('.'+path).parent().parent().addClass('active');

</script>
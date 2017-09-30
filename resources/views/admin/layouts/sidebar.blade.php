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
                <a href="#"><i class="fa  fa-user"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if(RoleMenu::hasMenuCategory($menuList,'用户管理','menuName')): ?>
                    <li class="admin-user-list"><a href="{{action('Admin\UserController@getList')}}"><i class="fa fa-circle-o"></i>用户管理</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'用户点击统计','menuName')): ?>
                    <li class="admin-user-userhits"><a href="{{action('Admin\UserController@getUserhits')}}"><i class="fa fa-circle-o"></i>用户点击统计</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'恶意用户统计','menuName')): ?>
                        <li class="admin-sendcode-list"><a href="{{action('Admin\SendCodeController@getList')}}"><i class="fa fa-circle-o"></i>恶意用户统计</a></li>
                    <?php endif ?>
                </ul>
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

                        <?php if(RoleMenu::hasMenuCategory($menuList,'H5展示','menuName')): ?>
                            <li class="admin-businessshow-add"><a href="{{action('Admin\BusinessShowController@anyAdd')}}"><i class="fa fa-circle-o"></i>H5展示</a></li>
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

                        <?php if(RoleMenu::hasMenuCategory($menuList,'渠道点击量','menuName')): ?>
                            <li class="admin-channel-hits"><a href="{{action('Admin\ChannelController@getHits')}}"><i class="fa fa-circle-o"></i>渠道点击量</a></li>
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

            <?php if(RoleMenu::hasMenuCategory($menuList,'积分商城管理','category')): ?>
            <li class="treeview ">
                <a href="#"><i class="fa fa-gift"></i>
                    <span>积分商城管理</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">

                    <?php if(RoleMenu::hasMenuCategory($menuList,'新增商品','menuName')): ?>
                    <li class="admin-scoreproduct-add"><a href="{{action('Admin\ScoreProductController@anyAdd')}}"><i class="fa fa-circle-o"></i>新增商品</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'商品列表','menuName')): ?>
                    <li class="admin-scoreproduct-list"><a href="{{action('Admin\ScoreProductController@getList')}}"><i class="fa fa-circle-o"></i>商品列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'兑换记录','menuName')): ?>
                        <li class="admin-scoreproduct-orderlist"><a href="{{action('Admin\ScoreProductController@getOrderlist')}}"><i class="fa fa-circle-o"></i>兑换记录</a></li>
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

                    <?php if(RoleMenu::hasMenuCategory($menuList,'推送日志','menuName')): ?>
                        <li class="admin-pushlog-list"><a href="{{action('Admin\PushLogController@getList')}}"><i class="fa fa-circle-o"></i>推送日志</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'意见反馈','menuName')): ?>
                    <li class="admin-feedback-add"><a href="{{action('Admin\FeedBackController@getList')}}"><i class="fa fa-circle-o"></i>意见反馈</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'添加银行','menuName')): ?>
                        <li class="admin-bank-add"><a href="{{action('Admin\BankController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加银行</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'银行列表','menuName')): ?>
                        <li class="admin-bank-list"><a href="{{action('Admin\BankController@getList')}}"><i class="fa fa-circle-o"></i>银行列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'添加banner','menuName')): ?>
                        <li class="admin-banner-add"><a href="{{action('Admin\BannerController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加Banner</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'banner列表','menuName')): ?>
                        <li class="admin-banner-list"><a href="{{action('Admin\BannerController@getList')}}"><i class="fa fa-circle-o"></i>Banner列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'添加产品','menuName')): ?>
                        <li class="admin-product-add"><a href="{{action('Admin\ProductController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加产品</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'产品列表','menuName')): ?>
                        <li class="admin-product-list"><a href="{{action('Admin\ProductController@getList')}}"><i class="fa fa-circle-o"></i>产品列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'产品点击','menuName')): ?>
                        <li class="admin-producthitslog-list"><a href="{{action('Admin\ProductHitsLogController@getList')}}"><i class="fa fa-circle-o"></i>产品点击</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'添加产品分类','menuName')): ?>
                        <li class="admin-productcate-add"><a href="{{action('Admin\ProductCateController@anyAdd')}}"><i class="fa fa-circle-o"></i>添加产品分类</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'产品分类列表','menuName')): ?>
                        <li class="admin-productcate-list"><a href="{{action('Admin\ProductCateController@getList')}}"><i class="fa fa-circle-o"></i>产品分类列表</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'编辑分享内容','menuName')): ?>
                        <li class="admin-share-edit"><a href="{{action('Admin\ShareController@anyEdit')}}"><i class="fa fa-circle-o"></i>编辑分享内容</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'安卓APP更新','menuName')): ?>
                        <li class="admin-appupdate-edit"><a href="{{action('Admin\AppUpdateController@anyEdit')}}"><i class="fa fa-circle-o"></i>安卓APP更新</a></li>
                    <?php endif ?>

                    <?php if(RoleMenu::hasMenuCategory($menuList,'启动页设置','menuName')): ?>
                        <li class="admin-bootpage-edit"><a href="{{action('Admin\BootPageController@anyEdit')}}"><i class="fa fa-circle-o"></i>启动页设置</a></li>
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
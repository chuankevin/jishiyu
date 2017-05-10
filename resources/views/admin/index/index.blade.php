@extends('admin.layouts.layout')
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">今日新增</span>
                        <span class="info-box-number">{{$today_sum}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">昨日新增</span>
                        <span class="info-box-number">{{$yesterday_sum}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">周新增</span>
                        <span class="info-box-number">{{$week_sum}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">月新增</span>
                        <span class="info-box-number">{{$month_sum}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">用户总量</span>
                        <span class="info-box-number">{{$sum}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

        </div>
        <!-- /.row -->
        <!-- Main row -->
        {{--<div class="row">
            <!-- Left col -->
            <section class="col-lg-8 connectedSortable ui-sortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom" style="cursor: move;">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                        --}}{{--<li><a href="#sales-chart" data-toggle="tab">Donut</a></li>--}}{{--
                        <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart"
                             style="position: relative; height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            <svg height="300" version="1.1" width="711" xmlns="http://www.w3.org/2000/svg"
                                 style="overflow: hidden; position: relative;">
                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël
                                    2.1.0
                                </desc>
                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                <text x="50.5625" y="259" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none"
                                      fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                                </text>
                                <path fill="none" stroke="#aaaaaa" d="M63.0625,259H686" stroke-width="0.5"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="50.5625" y="200.5" text-anchor="end" font="10px &quot;Arial&quot;"
                                      stroke="none" fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7,500</tspan>
                                </text>
                                <path fill="none" stroke="#aaaaaa" d="M63.0625,200.5H686" stroke-width="0.5"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="50.5625" y="142" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none"
                                      fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000</tspan>
                                </text>
                                <path fill="none" stroke="#aaaaaa" d="M63.0625,142H686" stroke-width="0.5"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="50.5625" y="83.5" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none"
                                      fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">22,500</tspan>
                                </text>
                                <path fill="none" stroke="#aaaaaa" d="M63.0625,83.5H686" stroke-width="0.5"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="50.5625" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none"
                                      fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30,000</tspan>
                                </text>
                                <path fill="none" stroke="#aaaaaa" d="M63.0625,25H686" stroke-width="0.5"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="571.7064854191981" y="271.5" text-anchor="middle" font="10px &quot;Arial&quot;"
                                      stroke="none" fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal"
                                      transform="matrix(1,0,0,1,0,8)">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan>
                                </text>
                                <text x="294.6771719319562" y="271.5" text-anchor="middle" font="10px &quot;Arial&quot;"
                                      stroke="none" fill="#888888"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;"
                                      font-size="12px" font-family="sans-serif" font-weight="normal"
                                      transform="matrix(1,0,0,1,0,8)">
                                    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                                </text>
                                <path fill="#74a5c1" stroke="none"
                                      d="M63.0625,217.4104C80.47144592952613,217.91740000000001,115.28933778857838,220.948675,132.6982837181045,219.4384C150.10722964763062,217.928125,184.92512150668287,207.57511147540984,202.33406743620898,205.3282C219.55378569258806,203.10571147540983,253.99322220534626,203.357725,271.21294046172534,201.5608C288.43265871810445,199.76387499999998,322.87209523086267,193.47297786885247,340.0918134872418,190.9528C357.5007594167679,188.40492786885247,392.3186512758202,181.182325,409.7275972053463,181.2886C427.1365431348724,181.394875,461.9544349939246,202.66209180327868,479.36338092345073,191.803C496.58309917982984,181.06194180327867,531.022535692588,101.29188618784531,548.2422539489671,94.888C565.2727445321992,88.55448618784531,599.3337256986633,134.20465000000002,616.3642162818954,140.85340000000002C633.7731622114215,147.64990000000003,668.5910540704739,146.7151,686,148.669L686,259L63.0625,259Z"
                                      fill-opacity="1"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                                <path fill="none" stroke="#3c8dbc"
                                      d="M63.0625,217.4104C80.47144592952613,217.91740000000001,115.28933778857838,220.948675,132.6982837181045,219.4384C150.10722964763062,217.928125,184.92512150668287,207.57511147540984,202.33406743620898,205.3282C219.55378569258806,203.10571147540983,253.99322220534626,203.357725,271.21294046172534,201.5608C288.43265871810445,199.76387499999998,322.87209523086267,193.47297786885247,340.0918134872418,190.9528C357.5007594167679,188.40492786885247,392.3186512758202,181.182325,409.7275972053463,181.2886C427.1365431348724,181.394875,461.9544349939246,202.66209180327868,479.36338092345073,191.803C496.58309917982984,181.06194180327867,531.022535692588,101.29188618784531,548.2422539489671,94.888C565.2727445321992,88.55448618784531,599.3337256986633,134.20465000000002,616.3642162818954,140.85340000000002C633.7731622114215,147.64990000000003,668.5910540704739,146.7151,686,148.669"
                                      stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <circle cx="63.0625" cy="217.4104" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="132.6982837181045" cy="219.4384" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="202.33406743620898" cy="205.3282" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="271.21294046172534" cy="201.5608" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="340.0918134872418" cy="190.9528" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="409.7275972053463" cy="181.2886" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="479.36338092345073" cy="191.803" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="548.2422539489671" cy="94.888" r="4" fill="#3c8dbc" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="616.3642162818954" cy="140.85340000000002" r="4" fill="#3c8dbc"
                                        stroke="#ffffff" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="686" cy="148.669" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <path fill="#eaf2f5" stroke="none"
                                      d="M63.0625,238.2052C80.47144592952613,237.9868,115.28933778857838,239.52145000000002,132.6982837181045,237.3316C150.10722964763062,235.14175,184.92512150668287,221.65594426229507,202.33406743620898,220.6864C219.55378569258806,219.72739426229506,253.99322220534626,231.46795,271.21294046172534,229.6174C288.43265871810445,227.76685,322.87209523086267,207.72728606557376,340.0918134872418,205.882C357.5007594167679,204.01643606557377,392.3186512758202,212.83375,409.7275972053463,214.774C427.1365431348724,216.71425,461.9544349939246,230.62202295081966,479.36338092345073,221.404C496.58309917982984,212.28617295081966,531.022535692588,147.18252900552486,548.2422539489671,141.4306C565.2727445321992,135.74187900552485,599.3337256986633,169.23757857142857,616.3642162818954,175.6414C633.7731622114215,182.18752857142857,668.5910540704739,188.83315,686,193.2304L686,259L63.0625,259Z"
                                      fill-opacity="1"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                                <path fill="none" stroke="#a0d0e0"
                                      d="M63.0625,238.2052C80.47144592952613,237.9868,115.28933778857838,239.52145000000002,132.6982837181045,237.3316C150.10722964763062,235.14175,184.92512150668287,221.65594426229507,202.33406743620898,220.6864C219.55378569258806,219.72739426229506,253.99322220534626,231.46795,271.21294046172534,229.6174C288.43265871810445,227.76685,322.87209523086267,207.72728606557376,340.0918134872418,205.882C357.5007594167679,204.01643606557377,392.3186512758202,212.83375,409.7275972053463,214.774C427.1365431348724,216.71425,461.9544349939246,230.62202295081966,479.36338092345073,221.404C496.58309917982984,212.28617295081966,531.022535692588,147.18252900552486,548.2422539489671,141.4306C565.2727445321992,135.74187900552485,599.3337256986633,169.23757857142857,616.3642162818954,175.6414C633.7731622114215,182.18752857142857,668.5910540704739,188.83315,686,193.2304"
                                      stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <circle cx="63.0625" cy="238.2052" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="132.6982837181045" cy="237.3316" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="202.33406743620898" cy="220.6864" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="271.21294046172534" cy="229.6174" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="340.0918134872418" cy="205.882" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="409.7275972053463" cy="214.774" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="479.36338092345073" cy="221.404" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="548.2422539489671" cy="141.4306" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="616.3642162818954" cy="175.6414" r="4" fill="#a0d0e0" stroke="#ffffff"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="686" cy="193.2304" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            </svg>

                        </div>

                    </div>
                </div>
                <!-- /.nav-tabs-custom -->


            </section>
            <!-- /.Left col -->
        </div>--}}

        <!-- /.row (main row) -->

    </section>








@endsection
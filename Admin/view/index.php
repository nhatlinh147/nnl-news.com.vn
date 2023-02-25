<?php
Path::path_file_include('Dashboard');
$dashboard = new Dashboard();
$statistic = $dashboard->marketUpdateStatistic();

$visitor = $dashboard->visitorStatisticArea();
$visitor = !empty($visitor) ? $visitor : 'null';

$order = $dashboard->orderStatistic(0);
$order = !empty($order) ? $order : 'null';

$order_01 = $dashboard->orderStatistic(1);
$order_01 = !empty($order_01) ? $order_01 : 'null';

$visitor_bar = $dashboard->visitorStatisticDonut(0);
$visitor_bar = !empty($visitor_bar) ? $visitor_bar : 'null';

$visitor_bar_prev = $dashboard->visitorStatisticDonut(1);
$visitor_bar_prev = !empty($visitor_bar_prev) ? $visitor_bar_prev : 'null';

$customer_line = $dashboard->customerStatisticLine();
$customer_line = !empty($customer_line) ? $customer_line : 'null';


$sales_line = $dashboard->salesStatisticLine();
$sales_line = !empty($sales_line) ? $sales_line : 'null';
?>

<!-- Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Inc_header_resource') ?>

<body>
   <section id="container">

      <!-- Phần đầu trong nội dung trang web -->
      <?php Path::path_file_include('Inc_header'); ?>

      <!-- Thanh sidebar: menu quản lý các đường dẫn trong trang web -->
      <?php Path::path_file_include('Inc_sidebar') ?>

      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <!-- //market-->
            <div class="market-updates">
               <div class="col-md-3 market-update-gd">
                  <div class="market-update-block clr-block-2">
                     <div class="col-md-4 market-update-right">
                        <i class="fa fa-eye"> </i>
                     </div>
                     <div class="col-md-8 market-update-left">
                        <h4>Visitors</h4>
                        <h3><?php echo $statistic->visitor ?></h3>
                        <p>Other hand, we denounce</p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
               </div>
               <div class="col-md-3 market-update-gd">
                  <div class="market-update-block clr-block-1">
                     <div class="col-md-4 market-update-right">
                        <i class="fa fa-users"></i>
                     </div>
                     <div class="col-md-8 market-update-left">
                        <h4>Users</h4>
                        <h3><?php echo $statistic->customer ?></h3>
                        <p>Other hand, we denounce</p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
               </div>
               <div class="col-md-3 market-update-gd">
                  <div class="market-update-block clr-block-3">
                     <div class="col-md-4 market-update-right">
                        <i class="fa fa-usd"></i>
                     </div>
                     <div class="col-md-8 market-update-left">
                        <h4>Sales</h4>
                        <h3><?php echo $statistic->sales ?></h3>
                        <p>Other hand, we denounce</p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
               </div>
               <div class="col-md-3 market-update-gd">
                  <div class="market-update-block clr-block-4">
                     <div class="col-md-4 market-update-right">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                     </div>
                     <div class="col-md-8 market-update-left">
                        <h4>Orders</h4>
                        <h3><?php echo $statistic->order ?></h3>
                        <p>Other hand, we denounce</p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
               </div>
               <div class="clearfix"> </div>
            </div>
            <!-- //market-->
            <div class="row">
               <div class="panel-body">
                  <div class="col-md-12 w3ls-graph" style="margin-bottom: 1rem;">
                     <!--agileinfo-grap-->
                     <div class="agileinfo-grap">
                        <div class="agileits-box">
                           <header class="agileits-box-header clearfix">
                              <h3>Thống kê số lượng người xem sản phẩm</h3>
                              <div class="toolbar">


                              </div>
                           </header>
                           <div class="agileits-box-body clearfix">
                              <div id="hero-area"></div>
                           </div>
                        </div>
                     </div>
                     <!--//agileinfo-grap-->

                  </div>

                  <div class="col-md-6 w3ls-graph">
                     <div class="agileinfo-grap">
                        <div class="agileits-box">
                           <header class="agileits-box-header clearfix">
                              <h3>Thống kê doanh thu và giá bán</h3>
                              <div class="toolbar">


                              </div>
                           </header>
                           <div class="agileits-box-body clearfix">
                              <div id="order_statistic_morris"></div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6 w3ls-graph">
                     <div class="agileinfo-grap">
                        <div class="agileits-box">
                           <header class="agileits-box-header clearfix">
                              <h3>Thống kê doanh thu và giá bán</h3>
                              <div class="toolbar">


                              </div>
                           </header>
                           <div class="agileits-box-body clearfix">
                              <div id="order_statistic_morris_01"></div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6 w3ls-graph" style="margin-top: 1rem;">
                     <!--agileinfo-grap-->
                     <div class="agileinfo-grap">
                        <div class="agileits-box">
                           <header class="agileits-box-header clearfix">
                              <h3>Số lượng người xem sản phẩm ngày gần nhất</h3>
                              <div class="toolbar">

                              </div>
                           </header>
                           <div class="agileits-box-body clearfix">
                              <div id="Visitor_donut_01"></div>
                           </div>
                        </div>
                     </div>
                     <!--//agileinfo-grap-->

                  </div>

                  <div class="col-md-6 w3ls-graph" style="margin-top: 1rem;">
                     <!--agileinfo-grap-->
                     <div class="agileinfo-grap">
                        <div class="agileits-box">
                           <header class="agileits-box-header clearfix">
                              <h3>Số lượng người xem sản phẩm cuối tuần trước</h3>
                              <div class="toolbar">

                              </div>
                           </header>
                           <div class="agileits-box-body clearfix">
                              <div id="Visitor_donut_02"></div>
                           </div>
                        </div>
                     </div>
                     <!--//agileinfo-grap-->

                  </div>

               </div>
            </div>
            <div class="agil-info-calendar">
               <!-- calendar -->
               <div class="col-md-6 agile-calendar">
                  <div class="calendar-widget">
                     <div class="panel-heading ui-sortable-handle">
                        <span class="panel-icon">
                           <i class="fa fa-calendar-o"></i>
                        </span>
                        <span class="panel-title"> Calendar Widget</span>
                     </div>
                     <!-- grids -->
                     <div class="agile-calendar-grid">
                        <div class="page">

                           <div class="w3l-calendar-left">
                              <div class="calendar-heading">

                              </div>
                              <div class="monthly" id="mycalendar"></div>
                           </div>

                           <div class="clearfix"> </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- //calendar -->
               <div class="col-md-6 w3agile-notifications">
                  <div class="notifications">
                     <!--notification start-->

                     <header class="panel-heading">
                        Notification
                     </header>
                     <div class="notify-w3ls">
                        <div class="alert alert-info clearfix">
                           <span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
                           <div class="notification-info">
                              <ul class="clearfix notification-meta">
                                 <li class="pull-left notification-sender"><span><a href="#">Jonathan Smith</a></span>
                                    send you a mail </li>
                                 <li class="pull-right notification-time">1 min ago</li>
                              </ul>
                              <p>
                                 Urgent meeting for next proposal
                              </p>
                           </div>
                        </div>
                        <div class="alert alert-danger">
                           <span class="alert-icon"><i class="fa fa-facebook"></i></span>
                           <div class="notification-info">
                              <ul class="clearfix notification-meta">
                                 <li class="pull-left notification-sender"><span><a href="#">Jonathan Smith</a></span>
                                    mentioned you in a post </li>
                                 <li class="pull-right notification-time">7 Hours Ago</li>
                              </ul>
                              <p>
                                 Very cool photo jack
                              </p>
                           </div>
                        </div>
                        <div class="alert alert-success ">
                           <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                           <div class="notification-info">
                              <ul class="clearfix notification-meta">
                                 <li class="pull-left notification-sender">You have 5 message unread</li>
                                 <li class="pull-right notification-time">1 min ago</li>
                              </ul>
                              <p>
                                 <a href="#">Anjelina Mewlo, Jack Flip</a> and <a href="#">3 others</a>
                              </p>
                           </div>
                        </div>
                        <div class="alert alert-warning ">
                           <span class="alert-icon"><i class="fa fa-bell-o"></i></span>
                           <div class="notification-info">
                              <ul class="clearfix notification-meta">
                                 <li class="pull-left notification-sender">Domain Renew Deadline 7 days ahead</li>
                                 <li class="pull-right notification-time">5 Days Ago</li>
                              </ul>
                              <p>
                                 Next 5 July Thursday is the last day
                              </p>
                           </div>
                        </div>
                        <div class="alert alert-info clearfix">
                           <span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
                           <div class="notification-info">
                              <ul class="clearfix notification-meta">
                                 <li class="pull-left notification-sender"><span><a href="#">Jonathan Smith</a></span>
                                    send you a mail </li>
                                 <li class="pull-right notification-time">1 min ago</li>
                              </ul>
                              <p>
                                 Urgent meeting for next proposal
                              </p>
                           </div>
                        </div>

                     </div>

                     <!--notification end-->
                  </div>
               </div>
               <div class="clearfix"> </div>
            </div>
            <!-- tasks -->
            <div class="agile-last-grids">

               <div class="col-md-6 agile-last-left agile-last-middle">
                  <div class="agile-last-grid">
                     <div class="area-grids-heading">
                        <h3>Biểu đồ doanh thu và giá bán </h3>
                     </div>
                     <div id="morris_visitor_bar"></div>

                  </div>
               </div>
               <div class="col-md-6 agile-last-left agile-last-right">
                  <div class="agile-last-grid">
                     <div class="area-grids-heading">
                        <h3>Số lượng người dùng 1 tuần trước</h3>
                     </div>
                     <div id="morris_customer_line"></div>

                  </div>
               </div>
               <div class="clearfix"> </div>
            </div>

            <div class="agile-last-grids" style="margin-top: 1rem">

               <div class="col-md-6 agile-last-left agile-last-middle">
                  <div class="agile-last-grid">
                     <div class="area-grids-heading">
                        <h3>Số lượng doanh số bán hàng 1 tuần trước</h3>
                     </div>
                     <div id="morris_sales_line"></div>

                  </div>
               </div>
               <div class="col-md-6 agile-last-left agile-last-right">
                  <div class="agile-last-grid">
                     <div class="area-grids-heading">
                        <h3>Số lượng người xem sản phẩm</h3>
                     </div>
                     <div id="morris_visitor_line"></div>

                  </div>
               </div>
               <div class="clearfix"> </div>
            </div>

            <!-- //tasks -->
            <div class="agileits-w3layouts-stats">
               <div class="col-md-4 stats-info widget">
                  <div class="stats-info-agileits">
                     <div class="stats-title">
                        <h4 class="title">Browser Stats</h4>
                     </div>
                     <div class="stats-body">
                        <ul class="list-unstyled">
                           <li>GoogleChrome <span class="pull-right">85%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar green" style="width:85%;"></div>
                              </div>
                           </li>
                           <li>Firefox <span class="pull-right">35%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar yellow" style="width:35%;"></div>
                              </div>
                           </li>
                           <li>Internet Explorer <span class="pull-right">78%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar red" style="width:78%;"></div>
                              </div>
                           </li>
                           <li>Safari <span class="pull-right">50%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar blue" style="width:50%;"></div>
                              </div>
                           </li>
                           <li>Opera <span class="pull-right">80%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar light-blue" style="width:80%;"></div>
                              </div>
                           </li>
                           <li class="last">Others <span class="pull-right">60%</span>
                              <div class="progress progress-striped active progress-right">
                                 <div class="bar orange" style="width:60%;"></div>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-md-8 stats-info stats-last widget-shadow">
                  <div class="stats-last-agile">
                     <table class="table stats-table ">
                        <thead>
                           <tr>
                              <th>S.NO</th>
                              <th>PRODUCT</th>
                              <th>STATUS</th>
                              <th>PROGRESS</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <th scope="row">1</th>
                              <td>Lorem ipsum</td>
                              <td><span class="label label-success">In progress</span></td>
                              <td>
                                 <h5>85% <i class="fa fa-level-up"></i></h5>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">2</th>
                              <td>Aliquam</td>
                              <td><span class="label label-warning">New</span></td>
                              <td>
                                 <h5>35% <i class="fa fa-level-up"></i></h5>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">3</th>
                              <td>Lorem ipsum</td>
                              <td><span class="label label-danger">Overdue</span></td>
                              <td>
                                 <h5 class="down">40% <i class="fa fa-level-down"></i></h5>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">4</th>
                              <td>Aliquam</td>
                              <td><span class="label label-info">Out of stock</span></td>
                              <td>
                                 <h5>100% <i class="fa fa-level-up"></i></h5>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">5</th>
                              <td>Lorem ipsum</td>
                              <td><span class="label label-success">In progress</span></td>
                              <td>
                                 <h5 class="down">10% <i class="fa fa-level-down"></i></h5>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">6</th>
                              <td>Aliquam</td>
                              <td><span class="label label-warning">New</span></td>
                              <td>
                                 <h5>38% <i class="fa fa-level-up"></i></h5>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="clearfix"> </div>
            </div>
         </section>
         <!-- footer -->
         <div class="footer">
            <div class="wthree-copyright">
               <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
            </div>
         </div>
         <!-- / footer -->
      </section>
      <!--main content end-->
   </section>


   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Inc_script_resource') ?>


   <!-- morris JavaScript -->
   <script>
      $(document).ready(function() {
         //BOX BUTTON SHOW AND CLOSE
         jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
         }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
         });
         jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
         });

         //CHARTS
         function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
         }

         var visitor = <?php echo $visitor ?>;

         var visitor_bar = <?php echo $visitor_bar ?>;

         var visitor_bar_prev = <?php echo $visitor_bar_prev ?>;

         var order = <?php echo $order ?>;

         var order_01 = <?php echo $order_01 ?>;

         var customer_line = <?php echo $customer_line ?>;

         var sales_line = <?php echo $sales_line ?>;

         const date_format = function(date) {
            return ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date
               .getFullYear();
         };

         function morris_area(object) {
            if (object != null) {
               Morris.Area({
                  element: object.id,
                  padding: 10,
                  behaveLikeLine: true,
                  gridEnabled: false,
                  gridLineColor: '#c1bebe',
                  axes: true,
                  resize: true,
                  smooth: true,
                  pointSize: 0,
                  lineWidth: 0,
                  fillOpacity: 0.85,
                  data: object.data,
                  lineColors: object.lineColors,
                  xkey: object.xkey,
                  xLabelFormat: function(d) {
                     return date_format(d);
                  },
                  dateFormat: function(date) {
                     var date = new Date(date);
                     return date_format(date);
                  },
                  redraw: true,
                  ykeys: object.ykeys,
                  labels: object.labels,
                  yLabelFormat: function(number) {
                     if (number > 10000000) {
                        return format_number(Math.round(number / 1000000), " tr");
                     } else {
                        return format_number(number, "");
                     }
                  },
                  ymin: object.ymin,
                  ymax: object.ymax,
                  pointSize: 2,
                  hideHover: 'auto',
                  resize: true
               });
            }
         }

         morris_visitor = morris_area(visitor);
         morris_order = morris_area(order);
         morris_order_01 = morris_area(order_01);

         function morris_donut(object) {
            if (object != null) {
               Morris.Donut({
                  element: object.id,
                  data: object.data,
                  labelColor: 'Black',
                  labels: ['Áo sơ mi nam', 'Áo len', 'Quần jean'],
                  colors: object.colors,
                  formatter: function(x) {
                     $("div svg text").css({
                        'font-family': 'none',
                        'font-size': '20pt !important',
                        'font-weight': '500'
                     });
                     return format_number(Number(x), "");
                  }
               });
            }
         }

         morris_visitor_bar = morris_donut(visitor_bar);
         morris_visitor_bar_prev = morris_donut(visitor_bar_prev);

         function morris_bar(object) {
            if (object != null) {
               Morris.Bar({
                  element: 'morris_visitor_bar',
                  data: object.data,
                  xkey: object.xkey,
                  xLabelFormat: function(d) {
                     let key = Object.keys(d.src)[0];
                     var date = new Date(d.src[key]);
                     return date_format(date);
                  },
                  ykeys: object.ykeys,
                  labels: object.labels,
                  ymin: object.ymin,
                  ymax: object.ymax,
                  xLabelAngle: 60
               });
            }
         }

         morris_visitor_bar = morris_bar(order);

         function morris_line(id, object) {
            if (object != null) {
               Morris.Line({
                  element: id,
                  data: object.data,
                  xkey: object.xkey,
                  xLabelFormat: function(d) {
                     let key = Object.keys(d.src)[0];
                     var date = new Date(d.src[key]);
                     return date_format(date);
                  },
                  ykeys: object.ykeys,
                  labels: object.labels,
                  ymin: object.ymin,
                  ymax: object.ymax,
                  lineColors: object.lineColors,
                  parseTime: false
               });
            }
         }

         morris_customer_line = morris_line('morris_customer_line', customer_line);
         morris_sales_line = morris_line('morris_sales_line', sales_line);
         morris_visitor_line = morris_line('morris_visitor_line', visitor);

      });
   </script>
   <!-- calendar -->
   <script type="text/javascript" src="js/monthly.js"></script>
   <script type="text/javascript">
      $(window).load(function() {

         $('#mycalendar').monthly({
            mode: 'event',

         });

         switch (window.location.protocol) {
            case 'http:':
            case 'https:':
               // running on a server, should be good.
               break;
            case 'file:':
               alert('Just a heads-up, events will not work when run locally.');
         }

      });
   </script>
   <!-- //calendar -->
</body>

</html>
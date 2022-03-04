<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skin (Blue) -->
    <link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Toastr -->
    <link href="{{ asset('/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- SweetAlert2 -->
    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
	 <!-- Icons -->
    <link href="../css/font-awesome-4.5.0/css/font-awesome.css"  rel="stylesheet">  

	 <!--Data tables Css-->
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
	
    <!-- Date Picker -->
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet"> 
    
    <!-- checkbox-->
    <link href="../css/awesome-bootstrap-checkbox.css" rel="stylesheet">
     
	
	 <link href="../css/bootstrap-select.min.css" rel="stylesheet">
	 
	<!--jQuery core --> 
	<script src="../js/jquery-1.11.2.min.js"></script>  

	<!-- bootstrap Js --> 
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	 
	 <!--Data Tables js-->
	<script src="../js/jquery.dataTables.min.js" type="text/javascript"></script>
	
	
	<script src="../js/bootstrap-select.js" type="text/javascript"></script>
    <!--Date picker js-->
    <script src="../js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    
    
    <!-- jQuery for Date picker intialixer and Dependency on region , xone ,wereda and so  control -->
  <script src="../js/dependencies.js" type="text/javascript"></script>
  
@yield('header-extra')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>ህወ</b>ሓት</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ህወሓት</b>/ኢህወደግ </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">4  ሓደሽቲ መልኧኽቲ</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="{{ Auth::user()->image }}" class="img-circle"
                                                     alt="User Image"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                               ክፍሊት
                                                <small><i class="fa fa-clock-o"></i> 5 ደቓይቕ</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>>ናይ ወርሒ ሰነ ክፍሊት </p>
                                        </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">ኩሉ መልኧኽቲ ርአ</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">10 ኖቲፊከሽናት ኣለዉኻ</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 ሓደሽቲ ኣባላት ተመዝጊቦም ኣለዉ
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">ኩሎም ኣርኢ</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">9 ኣለዉ</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                               
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% ተዛዚሙ ኣሎ</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">ኩሉ </a>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">እቶ</a></li>
                        <li><a href="{{ url('/register') }}">ተመዝገብ</a></li>
                @else
                    <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ Auth::user()->image }}" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->firstname." ".Auth::user()->lastname }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ url(Auth::user()->image) }}" class="img-circle" alt="User Image"/>
                                    <p>
                                        {{ Auth::user()->firstname." ".Auth::user()->lastname }}
                                        <small>{{ Auth::user()->created_at->diffForHumans() }}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ url('profile') }}" class="btn btn-default btn-flat">ፕሮፋይል</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            ውፃእ</a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<div class="col-sm-3 col-md-3 noprint" style="margin-top:-15px">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
         <!--   @if (! Auth::guest())
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ Auth::user()->image }}" class="img-circle" alt="User Image"/>
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->firstname." ".Auth::user()->lastname }}</p>
                      
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>-->
        @endif

        <!-- search form (Optional) -->
 
            <!-- /.search form -->
			<!-- Sidebar Menu -->
            <ul class="nav menu">
            <!-- USE {{ Request::is('route-name*') ? 'active' : '' }} to dynamically set active tab -->
                <li class="{{ Request::is('dashboard*') ? 'active' : '' }}"><a href="{{ url('dashboard') }}"><i
                                class='fa fa-tachometer'></i> <span>ዳሽ ቦርድ</span></a></li>
                <li class="{{ Request::is('admin*') ? 'active' : '' }}"><a href="{{ url('admin') }}"><i
                                class='fa fa-cogs'></i> <span>ዝርዝር ተጠቀምቲ ኣርኢ</span></a></li>
             
			  <div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseMembers"><span class="glyphicon glyphicon-folder-plus">
                            </span>ምሕደራ ኣባልነትን ምልመላን</a>
                        </h4>
                    </div>
                    <div id="collapseMembers" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							  
								<li class="{{ Request::is('hitsuy*') ? 'active' : '' }}"><a href="{{ url('hitsuy') }}">
							   <li class='fa fa-tachometer'></i> <span>ምልመላ</span></a></li></li>
							   <li class="{{ Request::is('membership*') ? 'active' : '' }}"><a href="{{ url('membership') }}">
							   <li class='fa fa-tachometer'></i> <span>አባልነት ምጽዳቅ</span></a></li></li>
							   <li class="{{ Request::is('membersReg*') ? 'active' : '' }}"><a href="{{ url('membersReg') }}">
							   <li class='fa fa-tachometer'></i> <span>ምዝገባ አባል</span></a></li></li>
							   <li class="{{ Request::is('dismissal*') ? 'active' : '' }}"><a href="{{ url('dismissal') }}">
							   <li class='fa fa-tachometer'></i> <span>ስንብት</span></a></li></li>
							   <li class="{{ Request::is('penality*') ? 'active' : '' }}"><a href="{{ url('penality') }}">
							   <li class='fa fa-tachometer'></i> <span>ቅጽዓት</span></a></li></li>
								<li class="{{ Request::is('coreDegefti*') ? 'active' : '' }}"><a href="{{ url('coreDegefti') }}">
							   <li class='fa fa-tachometer'></i> <span>ኮር ደገፍቲ </span></a></li></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
				
				<div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseAmerarha"><span class="glyphicon glyphicon-folder-plus">
                            </span>ምሕደራ ኣመራርሓ</a>
                        </h4>
                    </div>
                    <div id="collapseAmerarha" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							  <li class="{{ Request::is('mideba*') ? 'active' : '' }}"><a href="{{ url('mideba') }}">
                               <li class='fa fa-tachometer'></i> <span>ምደባ</span></a></li></li>
					           <li class="{{ Request::is('transfer*') ? 'active' : '' }}"><a href="{{ url('transfer') }}">
                               <li class='fa fa-tachometer'></i> <span>ዝውውር</span></a></li></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
				
				<div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseTraining"><span class="glyphicon glyphicon-folder-plus">
                            </span>ምሕደራ ስልጠና</a>
                        </h4>
                    </div>
                    <div id="collapseTraining" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							   <li class="{{ Request::is('training*') ? 'active' : '' }}"><a href="{{ url('training') }}">
							   <li class='fa fa-tachometer'></i> <span>ስልጠና</span></a></li></li>
							   <li class="{{ Request::is('trainingsetting*') ? 'active' : '' }}"><a href="{{ url('trainingsetting') }}">
							   <li class='fa fa-tachometer'></i> <span>ዓይነታት ስልጠና</span></a></li></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
					<div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseEvaluation"><span class="glyphicon glyphicon-folder-plus">
                            </span>ገምጋም ኣባላት</a>
                        </h4>
                    </div>
                    <div id="collapseEvaluation" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							  <li class="{{ Request::is('training*') ? 'active' : '' }}"><a href="{{ url('training') }}">
							   <li class='fa fa-tachometer'></i> <span>ላዕለዋይ ኣመራርሓ</span></a></li></li>
							   <li class="{{ Request::is('trainingsetting*') ? 'active' : '' }}"><a href="{{ url('trainingsetting') }}">
							   <li class='fa fa-tachometer'></i> <span>ማእኸላይ ኣመራርሓ</span></a></li></li>
							   <li class="{{ Request::is('training*') ? 'active' : '' }}"><a href="{{ url('training') }}">
							   <li class='fa fa-tachometer'></i> <span>ታሕተዋይ ኣመራርሓ</span></a></li></li>
							   <li class="{{ Request::is('trainingsetting*') ? 'active' : '' }}"><a href="{{ url('trainingsetting') }}">
							   <li class='fa fa-tachometer'></i> <span>ጀማሪ ኣመራርሓ</span></a></li></li>
							   <li class="{{ Request::is('evaluation*') ? 'active' : '' }}"><a href="{{ url('evaluation') }}">
                               <li class='fa fa-tachometer'></i> <span>ተራ ኣባል</span></a></li></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
				<div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapsePayment"><span class="glyphicon glyphicon-folder-plus">
                            </span>ምሕደራ ክፍሊት</a>
                        </h4>
                    </div>
                    <div id="collapsePayment" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							    <li class="{{ Request::is('fee*') ? 'active' : '' }}"><a href="{{ url('fee') }}">
								<li class='fa fa-tachometer'></i> <span>ምዝገባ ክፍሊት </span></a></li></a></li>
								<li class="{{ Request::is('tariff*') ? 'active' : '' }}"><a href="{{ url('tariff') }}">
                                <li class='fa fa-tachometer'></i> <span>ምሕደራ ከፍሊት </span></a></li>	</li>	
								<li class="{{ Request::is('gift*') ? 'active' : '' }}"><a href="{{ url('gift') }}">
								<li class='fa fa-tachometer'></i> <span>ውህብቶ</span></a></li></a></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
								<div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapsePlan"><span class="glyphicon glyphicon-folder-close">
                            </span>ምሕደራ ትልሚ</a>
                        </h4>
                    </div>
                    <div id="collapsePlan" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
			   
						 <li>
							<ul class="nav child_menu">
							     <li class="{{ Request::is('plan*') ? 'active' : '' }}"><a href="{{ url('plan') }}">
							   <li class='fa fa-tachometer'></i> <span>ትልሚ</span></a></li></li>
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
		
			   <div class="panel-group" id="accordion">
                <div class="header">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseSetting"><span class="glyphicon glyphicon-folder-plus">
                            </span>ምሕደራ ሶፍትዌር</a>
                        </h4>
                    </div>
                    <div id="collapseSetting" class="panel-collapse collapse"> <!-- in  default expanded-->
                        <div class="panel-body">
						 <li>
							<ul class="nav child_menu">
							    <li class="{{ Request::is('zone*') ? 'active' : '' }}"><a href="{{ url('zone') }}">
                               <li class='fa fa-tachometer'></i> <span>ከባብያዊ ኣቀማምጣ  </span></a></li>	
								<li class="{{ Request::is('woreda*') ? 'active' : '' }}"><a href="{{ url('woreda') }}">
                               <li class='fa fa-tachometer'></i> <span>ወረዳ  </span></a></li>	
							    <li class="{{ Request::is('tabia*') ? 'active' : '' }}"><a href="{{ url('tabia') }}">
                               <li class='fa fa-tachometer'></i> <span>ጣብያ</span></a></li>			
							   <li class="{{ Request::is('meseretawiwdabe*') ? 'active' : '' }}"><a href="{{ url('meseretawiwdabe') }}">
                               <li class='fa fa-tachometer'></i> <span>መሰረታዊ ውዳበ  </span></a></li>
							   	<li class="{{ Request::is('wahio*') ? 'active' : '' }}"><a href="{{ url('wahio') }}">
                               <li class='fa fa-tachometer'></i> <span>ዋህዮ  </span></a></li>												   
								<li class="{{ Request::is('educationlevel*') ? 'active' : '' }}"><a href="{{ url('educationlevel') }}">
                               <li class='fa fa-tachometer'></i> <span>ደረጃ ትምህርቲ  </span></a></li>			
				
						     </ul>
						  </li>
						</div>
					</div>
				  </div>
			   </div>
			</ul>	
        </section>
        <!-- /.sidebar -->
    </aside>
  </div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('contentheader_title', 'Page Header here')
                <small>@yield('contentheader_description')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class='control-sidebar-menu'>
                    <li>
                        <a href=''>
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class='control-sidebar-menu'>
                    <li>
                        <a href=''>
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

            </div><!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked/>
                        </label>
                        <p>
                            Some information about this general settings option
                        </p>
                    </div><!-- /.form-group -->
                </form>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class='control-sidebar-bg'></div>

</div><!-- ./wrapper -->

@include('layouts.partials.scripts')

</body>
</html>
<script>
!function ($) {
    
    // Le left-menu sign
    /* for older jquery version
    $('#left ul.nav li.parent > a > span.sign').click(function () {
        $(this).find('i:first').toggleClass("icon-minus");
    }); */
    
    $(document).on("click","#left ul.nav li.parent > a > span.sign", function(){          
        $(this).find('i:first').toggleClass("icon-minus");      
    }); 
    
    // Open Le current menu
    $("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("icon-minus");
    $("#left ul.nav li.current").parents('ul.children').addClass("in");

}(window.jQuery);
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skin (Blue) -->
    <link href="{{ asset('/css/skins/_all-skins.css') }}" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Toastr -->
    <link href="{{ asset('/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- SweetAlert2 -->
    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>


@yield('header-extra')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

</head>
<body class="skin-blue sidebar-mini" data-gr-c-s-loaded="true" style="height: auto; min-height: 100%;">
<div>

<header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>ህወ</b>ሓት</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ህወሓት</b> /ኢህወደግ </span>
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
                                                <small><i class="fa fa-clock-o"></i> 5 ደቒቓን 20 ሰከንድን</small>
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
                            <li class="header">10 ዘይተርኣዩ መልእኽቲታት （ኖቲፊከሽናት） ኣለዉዎም</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 90 ኣባላት ኣብዚ ሰሙን ተመዝጊቦም ኣለዉ
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">ዝርዝር ኣርኢ</a></li>
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
                            <li class="header">ኣብዚ 9 ኣባላት ተሰንዮም</li>
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
                                                    <span class="sr-only">20% Complete</span>
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
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
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
                                        <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout</a>

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
                    <!-- <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li> -->
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    

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
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
      <!-- dashoboard-shows summerized information -->
            <ul class="sidebar-menu tree" data-widget="tree">
            <li><a class="{{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ዳሽ ቦርድ</span></a>
            </li>
      <li class="treeview {{(Request::is('hitsuy')||Request::is('membership*')||Request::is('corelist*')||Request::is('hitsuylist*')||Request::is('memberlist*')||Request::is('educationinfo*')||Request::is('careerinfo*')||Request::is('transfer*')||Request::is('mideba*')||Request::is('training*')||Request::is('penalty*')||Request::is('dismiss*')||Request::is('coreDegefti*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ምሕደራ ኣባልነት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview {{(Request::is('hitsuy*')||Request::is('membership*')||Request::is('corelist*')||Request::is('hitsuylist*')||Request::is('memberlist*')||Request::is('educationinfo*')||Request::is('careerinfo*'))?'active':''}}">
                  <a href="#">
                    <i class="fa fa-circle-o"></i> 
                    <span class="lbl">ምሕደራ ሕፁይ</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('hitsuy*')?'active':''}}">
                      <a href="{{ url('hitsuy') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ምዝገባ ሕፁይ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('membership*')?'active':''}}">
                      <a href="{{ url('membership') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ኣባልነት ምፅዳቕ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('corelist*')?'active':''}}">
                      <a href="{{ url('corelist') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማህደር ኮር ደገፍቲ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('hitsuylist*')?'active':''}}">
                      <a href="{{ url('hitsuylist') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማህደር ሕፁያት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('memberlist*')?'active':''}}">
                      <a href="{{ url('memberlist') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማህደር ኣባላት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('educationinfo*')?'active':''}}">
                      <a href="{{ url('educationinfo') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማህደር ትምህርቲ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('careerinfo*')?'active':''}}">
                      <a href="{{ url('careerinfo') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማህደር ስራሕ ልምዲ</span>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="treeview {{(Request::is('transfer*')||Request::is('mideba*')||Request::is('training*')||Request::is('penalty*')||Request::is('dismiss*'))?'active':''}}">
                  <a href="#">
                    <i class="fa fa-circle-o"></i> 
                    <span class="lbl">ምሕደራ ኣባላት</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('transfer*')?'active':''}}">
                      <a href="{{ url('transfer') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዝውውር</span>
                      </a>
                    </li>
                    <li class="{{Request::is('mideba*')?'active':''}}">
                      <a href="{{ url('mideba') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ምደባ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('training*')?'active':''}}">
                      <a href="{{ url('training') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስልጠና</span>
                      </a>
                    </li>
                    <li class="{{Request::is('penalty*')?'active':''}}">
                      <a href="{{ url('penalty') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ቅፅዓት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('dismiss*')?'active':''}}">
                      <a href="{{ url('dismiss') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስንብት</span>
                      </a>
                    </li>                
                  </ul>
                </li>

                <li class="{{Request::is('coreDegefti*')?'active':''}}">
                  <a href="{{ url('coreDegefti') }}">
                    <i class="fa fa-circle-o"></i> 
                    <span class="lbl">ኮር ደገፍቲ</span>
                  </a>
                </li>
              </ul>
        </li>
        <li class="treeview {{(Request::is('topleader*')||Request::is('mediumleader*')||Request::is('lowleader*')||Request::is('firstinstantleader*')||Request::is('expert*')||Request::is('taramember*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ገምጋም ኣባላት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="{{Request::is('topleader*')?'active':''}}">
                  <a href="{{ url('topleader') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ላዕለዋይ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="{{Request::is('mediumleader*')?'active':''}}">
                  <a href="{{ url('mediumleader') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ማእኸላይ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="{{Request::is('lowleader*')?'active':''}}">
                  <a href="{{ url('lowleader') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ታሕተዋይ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="{{Request::is('firstinstantleader*')?'active':''}}">
                  <a href="{{ url('firstinstantleader') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ጀማሪ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="{{Request::is('expert*')?'active':''}}">
                  <a href="{{ url('expert') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ሰብ ሞያ</span>
                  </a>
                </li>
                <li class="{{Request::is('taramember*')?'active':''}}">
                  <a href="{{ url('taramember') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ተራ ኣባል</span>
                  </a>
                </li>
              </ul>
            </li>
      <li class="treeview {{(Request::is('officeplan*')||Request::is('zoneplan*')||Request::is('woredaplan*')||Request::is('meseretawiwidabeplan*')||Request::is('wahioleaders*')||Request::is('meseretawileaders*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ምሕደራ ትልሚ</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="{{Request::is('officeplan*')?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ቤት ፅሕፈት</span>
                  </a>
                </li>
                <li class="{{Request::is('zoneplan*')?'active':''}}">
                  <a href="{{ url('zoneplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ዞባ</span>
                  </a>
                </li>
                <li class="{{Request::is('woredaplan*')?'active':''}}">
                  <a href="{{ url('woredaplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ወረዳ</span>
                  </a>
                </li>
                <li class="{{Request::is('meseretawiwidabeplan*')?'active':''}}">
                  <a href="{{ url('meseretawiwidabeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ መሰረታዊ ውዳበ</span>
                  </a>
                </li>
                <li class="{{Request::is('wahioleaders*')?'active':''}}">
                  <a href="{{ url('wahioleaders') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ኣመራርሓ ዋህዮ</span>
                  </a>
                </li>
                <li class="{{Request::is('meseretawileaders*')?'active':''}}">
                  <a href="{{ url('meseretawileaders') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ኣመራርሓ መሰረታዊ ውዳበ</span>
                  </a>
                </li>
              </ul>
            </li>
        <li class="treeview {{(Request::is('monthly*')||Request::is('yearly*')||Request::is('gift*')||Request::is('donor*')||Request::is('mewacho*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ምሕደራ ክፍሊት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview {{(Request::is('monthly*')||Request::is('yearly*'))?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ክፍሊት ኣባልነት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('monthly*')?'active':''}}">
                      <a href="{{ url('monthly') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወርሓዊ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('yearly*')?'active':''}}">
                      <a href="{{ url('yearly') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዓመታዊ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="treeview {{(Request::is('gift*')||Request::is('donor*')||Request::is('mewacho*'))?'active':''}}">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ውህብቶን መዋጮን</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="treeview {{(Request::is('gift*')||Request::is('donor*'))?'active':''}}">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ውህብቶ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{Request::is('gift*')?'active':''}}">
                          <a href="{{ url('gift') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ውህብቶ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('donor*')?'active':''}}">
                          <a href="{{ url('donor') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምዝገባ ለገስቲ</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="{{Request::is('mewacho*')?'active':''}}">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">መዋጮ</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            @if (Auth::user() && Auth::user()->usertype == 'admin') 
            <li class="treeview {{(Request::is('monthly*')||Request::is('yearly*')||Request::is('gift*')||Request::is('donor*')||Request::is('mewacho*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o"></i> 
                <span class="lbl">ምሕደራ ሪፖርት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview {{(Request::is('monthly*')||Request::is('yearly*'))?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ናይ ኣባልነት ሪፖርት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('hilwiabalrepor*')?'active':''}}">
                      <a href="{{ url('hilwiabalrepor') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ኣባላት ሪፖርት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('yearly*')?'active':''}}">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ሕፁያት ሪፖርት</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="treeview {{(Request::is('gift*')||Request::is('donor*')||Request::is('mewacho*'))?'active':''}}">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ናይ ኣመራርሓ ሪፖርት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                      <a href="{{ url('mewacho') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ላዕለዋይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{Request::is('variationtopleader*')?'active':''}}">
                          <a href="{{ url('variationtopleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totaltopleader*')?'active':''}}">
                          <a href="{{ url('totaltopleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('nominattopleader*')?'active':''}}">
                          <a href="{{ url('nominattopleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('penalitytopleader*')?'active':''}}">
                          <a href="{{ url('penalitytopleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ቅፅዓታት</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                      <a href="{{ url('mewacho') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማእኸላይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="{{Request::is('variationworedaleader*')?'active':''}}">
                          <a href="{{ url('variationworedaleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን ወ/ኣ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totalworedaleader*')?'active':''}}">
                          <a href="{{ url('totalworedaleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ ወ/ኣ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('variationmiddleleader*')?'active':''}}">
                          <a href="{{ url('variationmiddleleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totalmiddleleader*')?'active':''}}">
                          <a href="{{ url('totalmiddleleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('nominatmiddleleader*')?'active':''}}">
                          <a href="{{ url('nominatmiddleleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('penalityworedaleader*')?'active':''}}">
                          <a href="{{ url('penalityworedaleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ቅፅዓታት ወ/ኣመራርሓ</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                      <a href="{{ url('mewacho') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ጀማሪ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="{{Request::is('variation1stleader*')?'active':''}}">
                          <a href="{{ url('variation1stleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን</span>
                          </a>
                        </li>
                        <li class="{{Request::is('total1stleader*')?'active':''}}">
                          <a href="{{ url('total1stleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('nominat1stleader*')?'active':''}}">
                          <a href="{{ url('nominat1stleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                      <a href="{{ url('mewacho') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ታሕተዋይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="{{Request::is('totalmwnleader*')?'active':''}}">
                          <a href="{{ url('totalmwnleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ መ/ውዳበ ነበርቲ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totalmwtleader*')?'active':''}}">
                          <a href="{{ url('totalmwtleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ መ/ውዳበ <br>ተምሃሮን መ/ሰራሕተኛታት</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totalwnleader*')?'active':''}}">
                          <a href="{{ url('totalwnleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ ዋህዮ ነበርቲ</span>
                          </a>
                        </li>
                        <li class="{{Request::is('totalwtleader*')?'active':''}}">
                          <a href="{{ url('totalwtleader') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ ዋህዮ <br> ተምሃሮን መ/ሰራሕተኛታት</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                          <a href="{{ url('mewacho') }}">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠቕላላ ኣመራርሓ</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                          </a>
                          <ul class="treeview-menu">
                            <li class="{{Request::is('totalleaders*')?'active':''}}">
                                <a href="{{ url('totalleaders') }}">
                                <i class="fa fa-circle-o"></i> 
                                <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                                </a>
                              </li>
                              <li class="{{Request::is('toatlinoutleader*')?'active':''}}">
                                <a href="{{ url('toatlinoutleader') }}">
                                <i class="fa fa-circle-o"></i> 
                                <span class="lbl">ኣሃዛዊ መረዳእታ <br>ብዝውውር ናይ ዝኸዱን ዝመፁን</span>
                                </a>
                              </li>
                            </ul>
                    </li>
                  </ul>
                </li>
                <li class="treeview {{Request::is('mewacho*')?'active':''}}">
                      <a href="{{ url('mewacho') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ናይ ክፍሊት ሪፖርት</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="{{Request::is('mewacho*')?'active':''}}">
                          <a href="#">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ክፍሊት ኣባላት</span>
                          </a>
                        </li>
                        <li class="{{Request::is('mewacho*')?'active':''}}">
                          <a href="#">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ውህብቶ</span>
                          </a>
                        </li>
                      </ul>
                </li>
              </ul>
            </li>
                @endif
        <li class="treeview {{(Request::is('zone*')||Request::is('woreda*')||Request::is('tabia*')||Request::is('meseretawiwidabe*')||Request::is('wahio*')||Request::is('rankworeda*')||Request::is('rankwahio*')||Request::is('rankmwidabe*')||Request::is('monthlysetting*')||Request::is('mewachosetting*')||Request::is('trainingsetting*')||Request::is('adduser*'))?'active':''}}">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ምሕደራ ሶፍትዌር</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @if (Auth::user() && Auth::user()->usertype == 'admin') 
                <li class="treeview {{(Request::is('zone*')||Request::is('woreda*')||Request::is('tabia*')||Request::is('meseretawiwidabe*')||Request::is('wahio*'))?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ፓርቲ መዋቕር</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('zone*')?'active':''}}">
                      <a href="{{ url('zone') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዞባ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('woreda*')?'active':''}}">
                      <a href="{{ url('woreda') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወረዳ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('tabia*')?'active':''}}">
                      <a href="{{ url('tabia') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ጣብያ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('meseretawiwidabe*')?'active':''}}">
                      <a href="{{ url('meseretawiwidabe') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">መሰረታዊ ውዳበ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('wahio*')?'active':''}}">
                      <a href="{{ url('wahio') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዋህዮ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                @endif
                <li class="treeview {{(Request::is('rankworeda*')||Request::is('rankwahio*')||Request::is('rankmwidabe*'))?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ስርርዕ</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('rankworeda*')?'active':''}}">
                      <a href="{{ url('rankworeda') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስርርዕ ወረዳ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('rankmwidabe*')?'active':''}}">
                      <a href="{{ url('rankmwidabe') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስርርዕ መሰረታዊ ውዳበ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('rankwahio*')?'active':''}}">
                      <a href="{{ url('rankwahio') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስርርዕ ዋህዮ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="treeview {{(Request::is('')||Request::is(''))?'active':''}}">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ምሕደራ ኮሚቴታት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('mewacho*')?'active':''}}">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዞባ ኮሚቴ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('mewacho*')?'active':''}}">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወረዳ ኮሚቴ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="treeview {{(Request::is('monthlysetting*')||Request::is('mewachosetting*')||Request::is('trainingsetting*'))?'active':''}}">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ግበጣ ክፍሊትን ስልጠናን</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('monthlysetting*')?'active':''}}">
                      <a href="{{ url('monthlysetting') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወርሓዊ ክፍሊት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('yearlysetting*')?'active':''}}">
                      <a href="{{ url('yearlysetting') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዓመታዊ ክፍሊት</span>
                      </a>
                    </li>
                    <li class="{{Request::is('mewachosetting*')?'active':''}}">
                      <a href="{{ url('mewachosetting') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">መዋጮ</span>
                      </a>
                    </li>
                    <li class="{{Request::is('trainingsetting*')?'active':''}}">
                      <a href="{{ url('trainingsetting') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስልጠና መምልኢ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                @if (Auth::user() && Auth::user()->usertype == 'admin') 
                <li class="treeview {{(Request::is('adduser*'))?'active':''}}">
                  <a href="{{ url('officeplan') }}">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ሓደሽቲ መመዝገቢ</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{Request::is('adduser*')?'active':''}}">
                      <a href="{{ url('adduser') }}">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ተጠቀምቲ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>

            </li>
            </ul>
</section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
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
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="https://adminlte.io/themes/AdminLTE/index2.html#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li><li><a href="https://adminlte.io/themes/AdminLTE/index2.html#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="https://adminlte.io/themes/AdminLTE/index2.html#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked="">
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked="">
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked="">
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked="">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
@include('layouts.partials.scripts')

</body>
</html>
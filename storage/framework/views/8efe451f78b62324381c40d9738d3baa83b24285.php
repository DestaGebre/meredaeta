<?php 
    use  App\Hitsuy;
    use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> <?php echo $__env->yieldContent('htmlheader_title', 'Your title here'); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo e(asset('/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="<?php echo e(asset('/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="<?php echo e(asset('/css/AdminLTE.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skin (Blue) -->
    <link href="<?php echo e(asset('/css/skins/_all-skins.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="<?php echo e(asset('/plugins/iCheck/square/blue.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- Toastr -->
    <link href="<?php echo e(asset('/css/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- SweetAlert2 -->
    <link href="<?php echo e(asset('/css/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        @media  print {
            @page  { margin: 0; }
            body { margin: 1.6cm; }
        }
    </style>


<?php echo $__env->yieldContent('header-extra'); ?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini" data-gr-c-s-loaded="true" style="height: auto; min-height: 100%;">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo e(url('dashboard')); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <!-- <span class="logo-mini" ><b>ህወ</b>ሓት</span> -->
            <!-- logo for regular state and mobile devices 
			<p><img class="imaging" src="img/mini-logo.png" width="50" height="50"/>-->
            <span class="logo-lg"><b>ዳሽ ቦርድ</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
<!--                     <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">4  ሓደሽቲ መልኧኽቲ</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?php echo e(asset('img/'.Auth::user()->image)); ?>" class="img-circle"
                                                     alt="User Image"/>
                                            </div>
                                            <h4>
                                               ክፍሊት
                                                <small><i class="fa fa-clock-o"></i> 5 ደቒቓን 20 ሰከንድን</small>
                                            </h4>
                                            <p>>ናይ ወርሒ ሰነ ክፍሊት </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">ኩሉ መልኧኽቲ ርአ</a></li>
                        </ul>
                    </li> -->


<!--                     <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">10 ዘይተርኣዩ መልእኽቲታት （ኖቲፊከሽናት） ኣለዉዎም</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 90 ኣባላት ኣብዚ ሰሙን ተመዝጊቦም ኣለዉ
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">ዝርዝር ኣርኢ</a></li>
                        </ul>
                    </li> -->
                    <!-- Tasks Menu -->
					<?php $value = Auth::user()->area ?>
                       <?php if(array_search(Auth::user()->usertype, ['admin','zoneadmin','woredaadmin']) !== false): ?>
					<li><a href="<?php echo e(url('directpromotion')); ?>">ስግግር ኣመራርሓ</a></li>
				   <li><a href="<?php echo e(url('actions')); ?>">ፍፃመታት ርአ</a></li>
				   <li><a href="<?php echo e(url('users')); ?>">ምሕደራ ተጠቀምቲ</a></li>
                <?php endif; ?>
					<?php if(Auth::user() && Auth::user()->usertype == 'admin'): ?>
					<li><a href="<?php echo e(url('generatereport')); ?>">ሪፖርት ስራሕ</a></li>
					<li><a href="<?php echo e(url('importwidabe')); ?>">ውዳበ ኣእትው</a></li>
				   <li><a href="<?php echo e(url('import')); ?>">ኣባላት ኣእትው</a></li>
						
				<?php endif; ?>
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <?php $value = Auth::user()->area ?>
                            <?php if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false): ?>
                                <?php 
                                    $value = '__'.$value;
                                ?>
                            <?php endif; ?>
                            <?php
                            $new_cnt = Hitsuy::whereIn('hitsuy_status',['ሕፁይ'])->where('hitsuyID', 'LIKE', $value.'%')->where('regDate','<',Carbon::now()->subMonths(6))->count();
                            ?>
                            <span class="label label-danger"><?php echo e($new_cnt); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"> <a href="membership">እዋን ኣባልነቶም ዝበፅሐ <?php echo e($new_cnt); ?> ሕፁያት ኣለዉ</a> </li>
                            <!-- <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <h3>
                                               
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                Change the css width attribute to simulate progress
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <li class="footer">
                                <a href="#"></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-list-ul"></i>
                            <?php $value = Auth::user()->area ?>
                            <?php if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false): ?>
                                <?php 
                                    $value = '__'.$value;
                                ?>
                            <?php endif; ?>
                            <?php
                            $new_cnt = Hitsuy::whereIn('hitsuy_status',['ሕፁይ'])->where('hitsuyID', 'LIKE', $value.'%')->where('regDate','<',Carbon::now()->subMonths(6))->count();
                            ?>
                            <span class="label label-danger"><?php echo e($new_cnt); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"> <a href="membership">እዋን ኣባልነቶም ዝበፅሐ <?php echo e($new_cnt); ?> ሕፁያት ኣለዉ</a> </li>
                            <!-- <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <h3>
                                               
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                Change the css width attribute to simulate progress
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <li class="footer">
                                <a href="#"></a>
                            </li>
                        </ul>
                    </li>
					
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(url('login')); ?>">እቶ</a></li>
                        <li><a href="<?php echo e(url('register')); ?>">ተጠቃሚ መዝግብ</a></li>
                <?php else: ?>
                    <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo e(asset('img/'.Auth::user()->image)); ?>" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"><?php echo e(Auth::user()->firstname." ".Auth::user()->lastname); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo e(asset('img/'.Auth::user()->image)); ?>" class="img-circle" alt="ምስሊ ተጠቃሚ"/>
                                    <p>
                                        <?php echo e(Auth::user()->firstname." ".Auth::user()->lastname); ?>

                                        <small><?php echo e(Auth::user()->created_at->diffForHumans()); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo e(url('profile')); ?>" class="btn btn-default btn-flat">ፕሮፋይል</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo e(url('logout')); ?>" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            ውፃእ</a>

                                        <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST"
                                              style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                <?php endif; ?>

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
         <!--   <?php if(! Auth::guest()): ?>
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo e(Auth::user()->image); ?>" class="img-circle" alt="User Image"/>
                    </div>
                    <div class="pull-left info">
                        <p><?php echo e(Auth::user()->firstname." ".Auth::user()->lastname); ?></p>
                      
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>-->
        <?php endif; ?>  
		<!-- search form (Optional) -->
            
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            
  <div class="container">
	<div class="row">
		<div id="left" class="span3">
            <ul id="menu-group-1" class="nav menu">  
			<aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- dashoboard-shows summerized information -->
            <ul class="sidebar-menu tree" data-widget="tree">
            <!--<li><a class="<?php echo e(Request::is('newdocument')||Request::is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(url('dashboard')); ?>">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ዳሽ ቦርድ</span></a>
            </li>-->
            
           
            <!-- <li><a class="<?php echo e(Request::is('documentlist') ? 'active' : ''); ?>" href="<?php echo e(url('documentlist')); ?>">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ዶክመንታት</span></a>
            </li> -->
              <?php if(Auth::user() && Auth::user()->usertype != 'management'): ?>
                <li class="treeview <?php echo e((Request::is('hitsuy')||Request::is('core')||Request::is('membership')||Request::is('transfer')||Request::is('mideba')||Request::is('penalty')||Request::is('training')||Request::is('coreDegefti')||Request::is('dismiss'))?'active':''); ?>">
                  <a href="#">
                    <i class="glyphicon glyphicon-user text-primary"></i> 
                    <span class="lbl">ምሕደራ ኣባልነት</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                   <!-- <li class="<?php echo e(Request::is('import')?'active':''); ?>">
                      <a href="<?php echo e(url('import')); ?>">
                      <i class="glyphicon glyphicon-user"></i> 
                      <span class="lbl">ኣባላት ካብ ኤክሴል ኣእትው</span>
                      </a>
                    </li> -->
                    <li class="<?php echo e(Request::is('membership')?'active':''); ?>">
                      <a href="<?php echo e(url('membership')); ?>">
                      <i class="glyphicon glyphicon-pencil text-primary"></i> 
                      <span class="lbl">ምልመላ ሕፁያት</span>
                      </a>
                    </li>  
					<li class="<?php echo e(Request::is('core')?'active':''); ?>">
					  <a href="<?php echo e(url('core')); ?>">
						<i class="glyphicon glyphicon-pencil"></i> 
						<span class="lbl">ምልመላ ቀወምቲ ደገፍቲ</span>
					  </a>
					</li>
                    <li class="<?php echo e(Request::is('transfer')?'active':''); ?>">
                      <a href="<?php echo e(url('transfer')); ?>">
                      <i class="glyphicon glyphicon-repeat text-primary"></i> 
                      <span class="lbl">ዝውውር</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('mideba')?'active':''); ?>">
                      <a href="<?php echo e(url('mideba')); ?>">
                      <i class="glyphicon glyphicon-share text-primary"></i> 
                      <span class="lbl">ምደባ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('training')?'active':''); ?>">
                      <a href="<?php echo e(url('training')); ?>">
                      <i class="glyphicon glyphicon-open text-primary"></i> 
                      <span class="lbl">ስልጠና</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('penalty')?'active':''); ?>">
                      <a href="<?php echo e(url('penalty')); ?>">
                      <i class="glyphicon glyphicon-edit text-primary"></i> 
                      <span class="lbl">ቅፅዓት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('dismiss')?'active':''); ?>">
                      <a href="<?php echo e(url('dismiss')); ?>">
                      <i class="glyphicon glyphicon-edit text-primary"></i> 
                      <span class="lbl">ስንብት</span>
                      </a>
                    </li>                
			  </ul>
                </li>
			<?php endif; ?>
            <li class="treeview <?php echo e((Request::is('leaderlist')||Request::is('corelist')||Request::is('hitsuylist')||Request::is('memberlist')||Request::is('educationinfo')||Request::is('careerinfo'))||Request::is('removedlist')||Request::is('dismissedlist')?'active':''); ?>">
                  <a href="#">
                    <i class="glyphicon glyphicon-folder-open text-primary"></i> 
                    <span class="lbl">ማህደር</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('leaderlist')?'active':''); ?>">
                      <a href="<?php echo e(url('leaderlist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ኣመራርሓ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('memberlist')?'active':''); ?>">
                      <a href="<?php echo e(url('memberlist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ኣባላት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('corelist')?'active':''); ?>">
                      <a href="<?php echo e(url('corelist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ቀወምቲ ደገፍቲ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('hitsuylist')?'active':''); ?>">
                      <a href="<?php echo e(url('hitsuylist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ሕፁያት</span>
                      </a>
                    </li>
                    <!--<li class="<?php echo e(Request::is('removedlist')?'active':''); ?>">
                      <a href="<?php echo e(url('removedlist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ካብ ሕፁይነት ዝተሰረዙ</span>
                      </a>
                    </li>-->
                    <li class="<?php echo e(Request::is('dismissedlist')?'active':''); ?>">
                      <a href="<?php echo e(url('dismissedlist')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ዝተሰናበቱ ኣባላት</span>
                      </a>
                    </li>
                    
                    <li class="<?php echo e(Request::is('educationinfo*')?'active':''); ?>">
                      <a href="<?php echo e(url('educationinfo')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ትምህርቲ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('careerinfo')?'active':''); ?>">
                      <a href="<?php echo e(url('careerinfo')); ?>">
                      <i class="glyphicon glyphicon-folder-open"></i> 
                      <span class="lbl">ማህደር ስራሕ ልምዲ</span>
                      </a>
                    </li>
                  </ul>
            </li>
            <li class="treeview <?php echo e((Request::is('rankworeda*')||Request::is('rankwahio*')||Request::is('rankmwidabe*'))?'active':''); ?>">
                  <a href="#">
                  <i class="glyphicon glyphicon-transfer text-primary"></i> 
                  <span class="lbl">ስርርዕ</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) === false): ?>
                    <li class="<?php echo e(Request::is('rankworeda') || Request::is('rankworedalist')?'active':''); ?>">
                      <a href="<?php echo e(url('rankworeda')); ?>">
                      <i class="glyphicon glyphicon-transfer"></i> 
                      <span class="lbl">ስርርዕ ወረዳ</span>
                      </a>
                    </li>
                    <?php endif; ?>
                    <li class="<?php echo e(Request::is('rankmwidabe') || Request::is('rankmwidabelist')?'active':''); ?>">
                      <a href="<?php echo e(url('rankmwidabe')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስርርዕ መሰረታዊ ውዳበ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('rankwahio') || Request::is('rankwahiolist')?'active':''); ?>">
                      <a href="<?php echo e(url('rankwahio')); ?>">
                      <i class="glyphicon glyphicon-transfer"></i> 
                      <span class="lbl">ስርርዕ ዋህዮ</span>
                      </a>
                    </li>
                  </ul>
                </li>
        <li class="treeview <?php echo e((Request::is('topleader*')||Request::is('expert*')||Request::is('mediumleader*')||Request::is('middleleaders*')||Request::is('mdmleaders*')||Request::is('lowleader*')||Request::is('lowerleader*')||Request::is('firstinstantleader*')||Request::is('1stleaderslist*')||Request::is('taramember*'))?'active':''); ?>">
              <a href="#">
                <i class="glyphicon glyphicon-eye-close text-primary"></i> 
                <span class="lbl">ገምጋም ኣባላት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?php echo e(Request::is('topleader*')?'active':''); ?>">
                  <a href="<?php echo e(url('topleader')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ላዕለዋይ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('mediumleader*')||Request::is('mdmleaderslist*'))?'active':''); ?>">
                  <a href="<?php echo e(url('mediumleader')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ማእኸላይ ኣመራርሓ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('firstinstantleader*')||Request::is('1stleaderslist*'))?'active':''); ?>">
                  <a href="<?php echo e(url('firstinstantleader')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ጀማሪ ኣመራርሓ</span>
                  </a>
                </li>
                
                <li class="<?php echo e(Request::is('expert*')?'active':''); ?>">
                  <a href="<?php echo e(url('expert')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ሰብ ሞያ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('lowleader*')||Request::is('lowerleaderslist*'))?'active':''); ?>">
                  <a href="<?php echo e(url('lowleader')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ታሕተዋይ ኣመራርሓ</span>
                  </a>
                </li>
               <!-- <li class="<?php echo e(Request::is('taramember*')?'active':''); ?>">
                  <a href="<?php echo e(url('taramember')); ?>">
                  <i class="glyphicon glyphicon-eye-close"></i> 
                  <span class="lbl">ተራ ኣባል</span>
                  </a>
                </li>-->
              </ul>
            </li>
			<li class="treeview <?php echo e((Request::is('meseretawiwidabeplan')||Request::is('meseretawiwidabeplanlist')||Request::is('wahioplan'))||Request::is('wahioplanlist')||Request::is('individualplan')||Request::is('individualplanlist')?'active':''); ?>">

              <a href="#">
                <i class="glyphicon glyphicon-edit text-primary"></i> 
                <span class="lbl">ምሕደራ ትልሚ</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!-- <li class="<?php echo e(Request::is('officeplan')?'active':''); ?>">
                  <a href="<?php echo e(url('officeplan')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ቤት ፅሕፈት</span>
                  </a>
                </li> -->
                <li class="<?php echo e((Request::is('meseretawiwidabeplan')||Request::is('meseretawiwidabeplanlist'))?'active':''); ?>">
                  <a href="<?php echo e(url('meseretawiwidabeplan')); ?>">
                  <i class="glyphicon glyphicon-edit"></i> 
                  <span class="lbl">ትልሚ መሰረታዊ ውዳበ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('wahioplan')||Request::is('wahioplanlist'))?'active':''); ?>">
                  <a href="<?php echo e(url('wahioplan')); ?>">
                  <i class="glyphicon glyphicon-edit"></i> 
                  <span class="lbl">ትልሚ ዋህዮ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('individualplan')||Request::is('individualplanlist'))?'active':''); ?>">
                  <a href="<?php echo e(url('individualplan')); ?>">
                  <i class="glyphicon glyphicon-edit"></i> 
                  <span class="lbl">ትልሚ ውልቀ ሰብ</span>
                  </a>
                </li>
                <!-- <li class="<?php echo e(Request::is('zoneplan')?'active':''); ?>">
                  <a href="<?php echo e(url('zoneplan')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ዞባ</span>
                  </a>
                </li> -->
                <!-- <li class="<?php echo e(Request::is('woredaplan')?'active':''); ?>">
                  <a href="<?php echo e(url('woredaplan')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ትልሚ ወረዳ</span>
                  </a>
                </li> -->
                <!-- <li class="<?php echo e(Request::is('wahioleaders')?'active':''); ?>">
                  <a href="<?php echo e(url('wahioleaders')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ኣመራርሓ ዋህዮ</span>
                  </a>
                </li> -->
                <!-- <li class="<?php echo e(Request::is('meseretawileaders')?'active':''); ?>">
                  <a href="<?php echo e(url('meseretawileaders')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ኣመራርሓ መሰረታዊ ውዳበ</span>
                  </a>
                </li> -->
              </ul>
            </li>
				<li class="treeview <?php echo e((Request::is('monthly')||Request::is('monthlylist')||Request::is('yearly')||Request::is('yearlylist')||Request::is('gift')||Request::is('donor')||Request::is('mewacho')||Request::is('mewachodetail*'))?'active':''); ?>">
              <a href="#">
                <i class="glyphicon glyphicon-share text-primary"></i> 
                <span class="lbl">ምሕደራ ክፍሊት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('monthly*')?'active':''); ?>">
                      <a href="<?php echo e(url('monthly')); ?>">
                      <i class="glyphicon glyphicon-share"></i> 
                      <span class="lbl">ወርሓዊ ክፍሊት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('yearly*')?'active':''); ?>">
                      <a href="<?php echo e(url('yearly')); ?>">
                      <i class="glyphicon glyphicon-share"></i> 
                      <span class="lbl">ዓመታዊ ክፍሊት</span>
                      </a>
                    </li>
                        <li class="<?php echo e(Request::is('gift')?'active':''); ?>">
                          <a href="<?php echo e(url('gift')); ?>">
                          <i class="fglyphicon glyphicon-share"></i> 
                          <span class="lbl">ውህብቶ</span>
                          </a>
                        </li>
                    <li class="<?php echo e((Request::is('mewacho')||Request::is('mewachodetail*'))?'active':''); ?>">
                      <a href="<?php echo e(url('mewacho')); ?>">
                      <i class="lyphicon glyphicon-share"></i> 
                      <span class="lbl">መዋጮ</span>
                      </a>
                    </li>
              </ul>
            </li>
            <?php if(Auth::user() && array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false): ?>
            <li class="treeview <?php echo e((Request::is('ketemareport'))||(Request::is('geterreport'))||(Request::is('regionalreport'))||(Request::is('hilwiabalreport')||Request::is('paymentreport')||Request::is('variationtopleader')||Request::is('totaltopleader')||Request::is('nominattopleader')||Request::is('penalitytopleader')||Request::is('variationworedaleader*')||Request::is('totalworedaleader')||Request::is('variationmiddleleader*')||Request::is('totalmiddleleader*')||Request::is('nominatmiddleleader*')||Request::is('penalityworedaleader*')||Request::is('variation1stleader')||Request::is('total1stleader')||Request::is('nominat1stleader')||Request::is('totalmwnleader')||Request::is('totalmwtleader')||Request::is('totalwnleader')||Request::is('totalwtleader')||Request::is('totalleaders')||Request::is('toatlinoutleader')||Request::is('paymentyearlyreport')||Request::is('paymentgiftreport')||Request::is('paymentmewachoreport')||Request::is('woredaprogress'))?'active':''); ?>">
              <a href="#">
                <i class="glyphicon glyphicon-list-alt text-primary"></i> 
                <span class="lbl">ምሕደራ ሪፖርት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
			  
              <ul class="treeview-menu">
				 <?php if(Auth::user() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'zoneadmin') ): ?>
				<li><a class="<?php echo e(Request::is('woredaprogress') ? 'active' : ''); ?>" href="<?php echo e(url('woredaprogress')); ?>">
					<i class="glyphicon glyphicon-list"></i> 
					<span class="lbl">ወረዳታት ዝመዝገብኦ በዝሒ ኣባል</span></a>
				</li>
				<?php endif; ?>
                <li class="<?php echo e((Request::is('regionalreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('regionalreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ናይ ክልል ሪፖርት</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('ketemareport'))?'active':''); ?>">
                  <a href="<?php echo e(url('ketemareport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ናይ ከተማ ሪፖርት</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('geterreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('geterreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ናይ ገጠር ሪፖርት</span>
                  </a>
                </li>
                <li class="treeview <?php echo e((Request::is('paymentreport')||Request::is('paymentgiftreport')||Request::is('paymentyearlyreport')||Request::is('paymentmewachoreport'))?'active':''); ?>">
                <a href="#">
                <i class="glyphicon glyphicon-list"></i> 
                <span class="lbl">ናይ ክፍሊት ሪፖርት</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?php echo e((Request::is('paymentreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('paymentreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ወርሓዊ ክፍሊት</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('paymentyearlyreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('paymentyearlyreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ዓመታዊ ክፍሊት</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('paymentgiftreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('paymentgiftreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">ውህብቶ</span>
                  </a>
                </li>
                <li class="<?php echo e((Request::is('paymentmewachoreport'))?'active':''); ?>">
                  <a href="<?php echo e(url('paymentmewachoreport')); ?>">
                  <i class="glyphicon glyphicon-list"></i> 
                  <span class="lbl">መዋጮ</span>
                  </a>
                </li>
            </ul>
            </li>
                <!-- <li class="treeview <?php echo e((Request::is('hilwiabalreport')||Request::is(''))?'active':''); ?>">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ናይ ኣባልነት ሪፖርት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('hilwiabalreport')?'active':''); ?>">
                      <a href="<?php echo e(url('hilwiabalrepor')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ኣባላት ሪፖርት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('')?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ሕፁያት ሪፖርት</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="treeview <?php echo e((Request::is('variationtopleader')||Request::is('totaltopleader')||Request::is('nominattopleader')||Request::is('penalitytopleader')||Request::is('variationworedaleader*')||Request::is('totalworedaleader')||Request::is('variationmiddleleader*')||Request::is('totalmiddleleader*')||Request::is('nominatmiddleleader*')||Request::is('penalityworedaleader*')||Request::is('variation1stleader')||Request::is('total1stleader')||Request::is('nominat1stleader')||Request::is('totalmwnleader')||Request::is('totalmwtleader')||Request::is('totalwnleader')||Request::is('totalwtleader')||Request::is('totalleaders')||Request::is('toatlinoutleader'))?'active':''); ?>">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ናይ ኣመራርሓ ሪፖርት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="treeview <?php echo e((Request::is('variationtopleader')||Request::is('totaltopleader')||Request::is('nominattopleader')||Request::is('penalitytopleader'))?'active':''); ?>">
                      <a href="<?php echo e(url('')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ላዕለዋይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="<?php echo e(Request::is('variationtopleader')?'active':''); ?>">
                          <a href="<?php echo e(url('variationtopleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totaltopleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totaltopleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('nominattopleader')?'active':''); ?>">
                          <a href="<?php echo e(url('nominattopleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('penalitytopleader')?'active':''); ?>">
                          <a href="<?php echo e(url('penalitytopleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ቅፅዓታት</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview <?php echo e((Request::is('variationworedaleader*')||Request::is('totalworedaleader')||Request::is('variationmiddleleader*')||Request::is('totalmiddleleader*')||Request::is('nominatmiddleleader*')||Request::is('penalityworedaleader*'))?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ማእኸላይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="<?php echo e(Request::is('variationworedaleader*')?'active':''); ?>">
                          <a href="<?php echo e(url('variationworedaleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን ወ/ኣ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totalworedaleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totalworedaleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ ወ/ኣ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('variationmiddleleader*')?'active':''); ?>">
                          <a href="<?php echo e(url('variationmiddleleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totalmiddleleader*')?'active':''); ?>">
                          <a href="<?php echo e(url('totalmiddleleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('nominatmiddleleader*')?'active':''); ?>">
                          <a href="<?php echo e(url('nominatmiddleleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ ማ/ኣ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('penalityworedaleader*')?'active':''); ?>">
                          <a href="<?php echo e(url('penalityworedaleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ቅፅዓታት ወ/ኣመራርሓ</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview <?php echo e((Request::is('variation1stleader')||Request::is('total1stleader')||Request::is('nominat1stleader'))?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ጀማሪ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="<?php echo e(Request::is('variation1stleader')?'active':''); ?>">
                          <a href="<?php echo e(url('variation1stleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ወሰኽን ጉድለትን</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('total1stleader')?'active':''); ?>">
                          <a href="<?php echo e(url('total1stleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('nominat1stleader')?'active':''); ?>">
                          <a href="<?php echo e(url('nominat1stleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ምልመላ</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview <?php echo e((Request::is('totalmwnleader')||Request::is('totalmwtleader')||Request::is('totalwnleader')||Request::is('totalwtleader'))?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ታሕተዋይ ኣመራርሓ</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="<?php echo e(Request::is('totalmwnleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totalmwnleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ መ/ውዳበ ነበርቲ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totalmwtleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totalmwtleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ መ/ውዳበ <br>ተምሃሮን መ/ሰራሕተኛታት</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totalwnleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totalwnleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ ዋህዮ ነበርቲ</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('totalwtleader')?'active':''); ?>">
                          <a href="<?php echo e(url('totalwtleader')); ?>">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠርነፍቲ ዋህዮ <br> ተምሃሮን መ/ሰራሕተኛታት</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview <?php echo e((Request::is('totalleaders')||Request::is('toatlinoutleader'))?'active':''); ?>">
                          <a href="#">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ጠቕላላ ኣመራርሓ</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                          </a>
                          <ul class="treeview-menu">
                            <li class="<?php echo e(Request::is('totalleaders')?'active':''); ?>">
                                <a href="<?php echo e(url('totalleaders')); ?>">
                                <i class="fa fa-circle-o"></i> 
                                <span class="lbl">ኣሃዛዊ መረዳእታ</span>
                                </a>
                              </li>
                              <li class="<?php echo e(Request::is('toatlinoutleader')?'active':''); ?>">
                                <a href="<?php echo e(url('toatlinoutleader')); ?>">
                                <i class="fa fa-circle-o"></i> 
                                <span class="lbl">ኣሃዛዊ መረዳእታ <br>ብዝውውር ናይ ዝኸዱን ዝመፁን</span>
                                </a>
                              </li>
                            </ul>
                    </li>
                  </ul>
                </li> -->
                <!-- <li class="treeview <?php echo e(Request::is('')?'active':''); ?>">
                      <a href="<?php echo e(url('mewacho')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ናይ ክፍሊት ሪፖርት</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                      </a>
                      <ul class="treeview-menu">
                      <li class="<?php echo e(Request::is('')?'active':''); ?>">
                          <a href="#">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ክፍሊት ኣባላት</span>
                          </a>
                        </li>
                        <li class="<?php echo e(Request::is('')?'active':''); ?>">
                          <a href="#">
                          <i class="fa fa-circle-o"></i> 
                          <span class="lbl">ውህብቶ</span>
                          </a>
                        </li>
                      </ul>
                </li> -->
              </ul>
            </li>
                <?php endif; ?>
                <?php if(Auth::user() && (Auth::user()->usertype == 'admin') || (Auth::user()->usertype == 'woredaadmin') || (Auth::user()->usertype == 'zoneadmin')): ?>
				<li class="treeview <?php echo e((Request::is('zone')||Request::is('woreda')||Request::is('tabia')||Request::is('meseretawiwdabe')||Request::is('wahio')||Request::is('monthlysetting')||Request::is('yearlysetting')||Request::is('mewachosetting')||Request::is('trainingsetting')||Request::is('adduser')||Request::is('register')||Request::is('reset')||Request::is('actions')||Request::is('generatereport'))?'active':''); ?>">
              <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> 
                <span class="lbl">ምሕደራ ሶፍትዌር</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!-- <li>
                    <a class="<?php echo e(Request::is('newdocument') ? 'active' : ''); ?>" href="<?php echo e(url('newdocument')); ?>">
                    <i class="fa fa-circle-o text-aqua"></i> 
                    <span class="lbl">ዶክመንት ኣእትው</span></a>
                </li> -->
                <li class="treeview <?php echo e((Request::is('zone')||Request::is('woreda')||Request::is('tabia')||Request::is('meseretawiwdabe')||Request::is('wahio'))?'active':''); ?>">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ፓርቲ መዋቕር</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if(Auth::user() && (Auth::user()->usertype == 'admin')): ?>
                    <li class="<?php echo e(Request::is('zone')?'active':''); ?>">
                      <a href="<?php echo e(url('zone')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዞባ</span>
                      </a>
                    </li>
                    <?php endif; ?>
                    <?php if(Auth::user() && (Auth::user()->usertype == 'admin') || (Auth::user()->usertype == 'zoneadmin')): ?>
                    <li class="<?php echo e(Request::is('woreda')?'active':''); ?>">
                      <a href="<?php echo e(url('woreda')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወረዳ</span>
                      </a>
                    </li>
                    <?php endif; ?>
                    <li class="<?php echo e(Request::is('tabia')?'active':''); ?>">
                      <a href="<?php echo e(url('tabia')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ጣብያ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('meseretawiwdabe')?'active':''); ?>">
                      <a href="<?php echo e(url('meseretawiwdabe')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">መሰረታዊ ውዳበ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('wahio')?'active':''); ?>">
                      <a href="<?php echo e(url('wahio')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዋህዮ</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- <li class="treeview <?php echo e((Request::is('')||Request::is(''))?'active':''); ?>">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ምሕደራ ኮሚቴታት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('')?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዞባ ኮሚቴ</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('')?'active':''); ?>">
                      <a href="#">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወረዳ ኮሚቴ</span>
                      </a>
                    </li>
                  </ul>
                </li> -->
                <?php if(Auth::user() && (Auth::user()->usertype == 'admin')): ?>
                <li class="treeview <?php echo e((Request::is('monthlysetting')||Request::is('yearlysetting')||Request::is('mewachosetting')||Request::is('trainingsetting'))?'active':''); ?>">
                  <a href="#">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ግበጣ ክፍሊት</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('monthlysetting')?'active':''); ?>">
                      <a href="<?php echo e(url('monthlysetting')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ወርሓዊ ክፍሊት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('yearlysetting')?'active':''); ?>">
                      <a href="<?php echo e(url('yearlysetting')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ዓመታዊ ክፍሊት</span>
                      </a>
                    </li>
                    <li class="<?php echo e(Request::is('mewachosetting')?'active':''); ?>">
                      <a href="<?php echo e(url('mewachosetting')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">መዋጮ</span>
                      </a>
                    </li>
                    <!--<li class="<?php echo e(Request::is('trainingsetting')?'active':''); ?>">
                      <a href="<?php echo e(url('trainingsetting')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ስልጠና መምልኢ</span>
                      </a>
                    </li>-->
                  </ul>
                </li>
                <?php endif; ?>
				<!--<?php if(Auth::user() && Auth::user()->usertype == 'admin'): ?> 
				<li><a class="<?php echo e(Request::is('directpromotion') ? 'active' : ''); ?>" href="<?php echo e(url('directpromotion')); ?>">
					<i class="fa fa-circle-o text-aqua"></i> 
					<span class="lbl">ናብ ኣመራርሓ ስግግር</span></a>
				</li>
				<li><a class="<?php echo e(Request::is('importwidabe') ? 'active' : ''); ?>" href="<?php echo e(url('importwidabe')); ?>">
					<i class="fa fa-circle-o text-aqua"></i> 
					<span class="lbl">ውዳበን ዋህዮ ካብ ኤክሴል ኣእትው</span></a>
				</li>
				<?php endif; ?>
				
                 <?php if(Auth::user()->usertype != 'woredaadmin'): ?> 
                <li><a class="treeview <?php echo e(Request::is('register') ? 'active' : ''); ?>" href="<?php echo e(url('register')); ?>">
                    <i class="fa fa-circle-o text-aqua"></i> 
                    <span class="lbl">ሓዱሽ ተጠቃሚ መዝግብ</span></a>
                </li>
                  
                <li><a class="treeview <?php echo e(Request::is('reset') ? 'active' : ''); ?>" href="<?php echo e(url('reset')); ?>">
                    <i class="fa fa-circle-o text-aqua"></i> 
                    <span class="lbl">ፓስዎርድ ሪሴት</span></a>
                </li> 
				<?php endif; ?>
                <li><a class="treeview <?php echo e(Request::is('actions') ? 'active' : ''); ?>" href="<?php echo e(url('actions')); ?>">
                    <i class="fa fa-circle-o text-aqua"></i> 
                    <span class="lbl">ተግባራት ተጠቀምቲ</span></a>
                </li>
                <?php if(Auth::user() && (Auth::user()->usertype == 'admin')): ?>
                <li><a class="treeview <?php echo e(Request::is('generatereport') ? 'active' : ''); ?>" href="<?php echo e(url('generatereport')); ?>">
                    <i class="fa fa-circle-o text-aqua"></i> 
                    <span class="lbl">ሪፖርት ስራሕ</span></a>
                </li>  -->
                <?php endif; ?>
                <!-- <li class="treeview <?php echo e((Request::is('adduser*'))?'active':''); ?>">
                  <a href="<?php echo e(url('officeplan')); ?>">
                  <i class="fa fa-circle-o"></i> 
                  <span class="lbl">ሓደሽቲ መመዝገቢ</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo e(Request::is('adduser*')?'active':''); ?>">
                      <a href="<?php echo e(url('adduser')); ?>">
                      <i class="fa fa-circle-o"></i> 
                      <span class="lbl">ተጠቀምቲ</span>
                      </a>
                    </li>
                  </ul>
                </li> -->
              </ul>

            </li>
            <?php endif; ?>
            </ul>
</section>
        <!-- /.sidebar -->
    </aside>
			
		</div>
	</div>
</div>

        
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $__env->yieldContent('contentheader_title', 'Page Header here'); ?>
                <small><?php echo $__env->yieldContent('contentheader_description'); ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <?php echo $__env->yieldContent('main-content'); ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    


</div><!-- ./wrapper -->

<?php echo $__env->make('layouts.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<style type="text/css">
    .calendars-popup{
        z-index: 10000;
    }
    button[type="submit"]{
        margin-bottom: 10px;
    }
    .search-modal{
        margin-top: 10px;
    }
    .required{
        color: #d71b1b;
    }
    /*section.sidebar:hover {
        overflow-y: scroll;
    }*/
</style>
</body>
</html>
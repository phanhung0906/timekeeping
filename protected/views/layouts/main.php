
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/jquery/jquery-2.0.3.min.js"></script>
    <!-- TableSorter -->
    <link rel="stylesheet" href="http://<?php echo ROOT_URL ?>/assets/vendor/tablesorter/css/theme.bootstrap.css">
    <link rel="stylesheet" href="http://<?php echo ROOT_URL ?>/assets/vendor/tablesorter/addons/pager/jquery.tablesorter.pager.css">
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/tablesorter/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/tablesorter/js/jquery.tablesorter.widgets.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/tablesorter/addons/pager/jquery.tablesorter.pager.min.js"></script>
    <!-- //TableSorter -->

    <!----Loading---->
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/loading/waitMe.min.css" />
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/loading/waitMe.min.js"></script>
    <!----//Loading---->

    <!-- Bootstrap CSS framework -->
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrapValidator.min.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/datepicker3.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" />

    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrap-datepicker.js"></script>
    <!-- //Bootstrap CSS framework -->

    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/css/style.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/font-awesome/css/font-awesome.min.css" />

    <!-- TableSorter -->
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/highcharts/js/highcharts.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/highcharts/js/jquery.highchartTable.js"></script>
    <!-- //TableSorter -->

    <!----ckeditor---->
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/ckeditor/ckeditor.js"></script>
    <!----//ckeditor---->

    <!----Animation---->
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/animation/css/animations.min.css" />
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/animation/js/animations.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/animation/js/appear.min.js"></script>
    <!----//Animation---->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body style='position:relative'>
<?php Yii::app()->language= Yii::app()->session['language']; ?>
<div class='allpage'>

    <div class='d-wrapper'>
        <nav class="navbar navbar-fixed-top navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" id='logo' href="http://<?php echo ROOT_URL ?>" id='logo-text'><img src="http://<?php echo ROOT_URL.'/assets/vendor/picture/logo1.png' ?>" width='40px' > <?php echo CHtml::encode(Yii::app()->name); ?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(Yii::app()->session['role'] != null): ?>
                        <li class="dropdown" style='border-left: 1px solid #f1f1f1;'>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id='menu-dropdown'> <?php echo Yii::t('app','Hello'); ?> <strong><?php echo Yii::app()->session['user'] ?></strong> <b class="caret"></b></a>
                            <ul class="dropdown-menu" style='width:200px;'>
                                <li><a href="http://<?php echo ROOT_URL ?>"><span class='fa fa-home'></span> <?php echo Yii::t('app','Home'); ?></a></li>
                                <li class="divider"></li>
                                <li class='dropdown-header'> <?php echo Yii::t('app','Language'); ?></li>
                                <li><a href="#" class='lang' data-lang='en'> <?php echo Yii::t('app','English'); ?></a></li>
                                <li><a href="#" class='lang' data-lang='vi'> <?php echo Yii::t('app','Vietnamese'); ?></a></li>
                                <li class="divider"></li>
                                <li><a href="http://<?php echo ROOT_URL ?>/site/logout"><span class="fa fa-power-off"></span> <?php echo Yii::t('app','Sign out'); ?></a></li>
                            </ul>
                        </li>
                        <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo Yii::t('app','Action'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu" style='width:200px;'>
                                <li class='dropdown-header'> <?php echo Yii::t('app','Language'); ?></li>
                                <li><a href="#" class='lang' data-lang='en'> <?php echo Yii::t('app','English'); ?></a></li>
                                <li><a href="#" class='lang' data-lang='vi'> <?php echo Yii::t('app','Vietnamese'); ?></a></li>
                                <li class="divider"></li>
                                <li><a href="http://<?php echo ROOT_URL ?>/login"><span class="fa fa-sign-in"></span> <?php echo Yii::t('app','Sign in'); ?></a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="d-main" style="padding-top: 50px;">
            <div class="d-sidebar">
                <div class="list-group">
                    <ul class="sidebar-menu" id='mainmenu'>
                        <li class="">
                            <a class="sidebar-item dashboard" href="http://<?php echo ROOT_URL ?>" data-url='/'><i class="fa fa-dashboard"></i> <?php echo Yii::t('app','Dashboard') ?></a>
                        </li>
                        <li><a href="http://<?php echo ROOT_URL ?>/profile" data-url='/profile'><span class="fa fa-user"></span> <?php echo Yii::t('app','Profile'); ?></a></li>
                        <?php if(Yii::app()->session['role'] == 'admin'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/admin" data-url='/admin'><i class="fa fa-users"></i>  <?php echo Yii::t('app','List User'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'leader'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/leader" data-url='/leader'><i class="fa fa-users"></i>  <?php echo Yii::t('app','List User'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'director'): ?>
                            <li>   <a href="http://<?php echo ROOT_URL ?>/director" data-url='/director'><i class="fa fa-users"></i>  <?php echo Yii::t('app','List User'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin' || Yii::app()->session['role'] == 'leader'): ?>
                           <li>
                                <a class="sidebar-item" href="javascript:void(0)" data-url='/user'><i class="fa fa-bookmark"></i> <?php echo Yii::t('app','Register') ?><span class="arrow"></span></a>
                                <ul class="nav-custom">
                                    <li><a href="http://<?php echo ROOT_URL ?>/overtime"  data-url='/overtime'><span class="fa fa-bolt"></span> <?php echo Yii::t('app','Overtime'); ?></a></li>
                                    <li><a href="http://<?php echo ROOT_URL ?>/dayoff/list/ur/<?php echo Yii::app()->session['role'] ?>"  data-url='/dayoff'><span class="fa fa-wheelchair"></span> <?php echo Yii::t('app','Dayoff'); ?></a></li>
                                </ul>
                           </li>
                        <?php endif; ?>
                        <li>  <a href="http://<?php echo ROOT_URL ?>/timekeeping" data-url='/timekeeping'><i class="fa fa-clock-o"></i> <?php echo Yii::t('app','Timekeeping'); ?></a></li>
                        <li> <a href="http://<?php echo ROOT_URL ?>/salary"  data-url='/salary'><span class="fa fa-usd"></span> <?php echo Yii::t('app','Salary'); ?></a></li>

                       <?php if(Yii::app()->session['role'] == 'manager' || Yii::app()->session['role'] == 'admin'): ?>
                            <li>
                                <a class="sidebar-item" href="javascript:void(o)" data-url='/property'><i class="fa fa-desktop"></i> <?php echo Yii::t('app','Property'); ?><span class="arrow"></span></a>
                                <ul class="nav-custom">
                                    <li><a href="http://<?php echo ROOT_URL ?>/property" data-url='/property'><i class="fa fa-desktop"></i> <?php echo Yii::t('app','Property'); ?> </a></li>
                                    <li><a href="http://<?php echo ROOT_URL?>/property/lstsendmail" data-url='/property/lstsendmail' ><i class="fa fa-envelope-o "></i> <?php echo Yii::t('app','List Send Mail') ?></a></li>
                                    <li><a href="http://<?php echo ROOT_URL?>/property/create"  data-url='/property/create'> <i class="fa fa-plus " ></i> <?php echo Yii::t('app','CREATE') ?></a></li>
                                </ul>
                            </li>
                        <?php endif?>
                        <?php if(Yii::app()->session['role'] == 'user' || Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'leader'):  ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/property" data-url='/property'><i class="fa fa-desktop"></i> <?php echo Yii::t('app','Property'); ?> </a></li>
                        <?php endif?>

                        <li>
                            <a class="sidebar-item" href="javascript:void(o)" data-url='/Calendar'><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Calendar'); ?><span class="arrow"></span></a>
                            <ul class="nav-custom">
                                <li><a href="http://<?php echo ROOT_URL ?>/index.php/meeting" data-url='/meeting'><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Meeting room'); ?> </a></li>
                                <?php if(Yii::app()->session['role'] == 'leader' || Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin'): ?>
                                    <li><a href="http://<?php echo ROOT_URL ?>/index.php/wdcalendar " data-url='/seminar'><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Seminar'); ?> </a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php if(Yii::app()->session['role'] == 'admin' || Yii::app()->session['role'] == 'director'): ?>
                            <li> <a href="http://<?php echo ROOT_URL ?>/chart" data-url='/chart'><i class="fa fa-bar-chart-o"></i> <?php echo Yii::t('app','Chart'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'admin'): ?>
                            <li class="">
                                <a class="sidebar-item" href="javascript:void(0)" data-url='/1'><i class="fa fa-cog"></i> <?php echo Yii::t('app','Setting'); ?><span class="arrow"></span></a>
                                <ul class="nav-custom">
                                    <li> <a href="http://<?php echo ROOT_URL ?>/update"  data-url='/update'><i class="fa fa-refresh"></i> <?php echo Yii::t('app','Update'); ?></a></li>
                                    <li> <a href="http://<?php echo ROOT_URL ?>/setting"  data-url='/setting'><i class="fa fa-wrench"></i> <?php echo Yii::t('app','Set up'); ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
<!--                        <li class="">-->
<!--                            <a class="sidebar-item" href="javascript:void(0)" data-url='/user'><i class="fa fa-plus-square"></i>Others<span class="arrow"></span></a>-->
<!--                            <ul class="nav-custom">-->
<!--                                <li><a href="/samuraistation/support" data-url='/user'>Mail to Atmarkcafe support</a></li>-->
<!--                                <li><a href="/samuraistation/admin/suser/changePass" data-url='/user'>Change Password</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->

                    </ul>

                </div>
            </div>
            <div class="d-content-wrapper">
                <div class="d-content">

                    <?php echo $content; ?>

                    <div class="clear"></div>

                </div><!-- page -->
            </div>
        </div>
    </div>
<!--    <footer>-->
<!--        <div class='container'>-->
<!--            Copyright &copy; --><?php //echo date('Y'); ?><!-- All Rights Reserved-->
<!--        </div>-->
<!--    </footer>-->
</div>
<script type='text/javascript'>
    $(document).ready(function(){
        $('.lang').click(function(){
            $lang = $(this).data('lang');
            $.ajax({
                type:'post',
                url:"http://<?php echo ROOT_URL ?>/site/language",
                data:{
                    lang: $lang
                }
            }).done(function(response){
                    location.reload();
            })
        })

        $count = 0;
        $('#mainmenu').find('li').each(function(index, item) {
            $self = $(this);
            var path = window.location.pathname;
            if (path.substr(0, $self.find('a').data('url').length) == $self.find('a').data('url')) {
                $self.children('a').addClass('activeMenu').css('color','white');
                $self.css('background','#181B1F');
                $count++;
                $self.parent('ul').show();
            }
            if ($count > 1)
                $('#mainmenu').find('li').find('.dashboard').removeClass('activeMenu').css({'color':'#808b9c','background-color':'#23272D'});
        });

        if( parseInt($(window ).height()) >= parseInt($(document ).height()) )
            $('body').css({'height': $(window ).height()+'px'});

        $('.sidebar-item').click(function(){
            var check = $(this).parent().find("ul").hasClass('open');
            $('.sidebar-menu .nav-custom').removeClass('open');
            $('.sidebar-menu .nav-custom').slideUp();
            $('.sidebar-menu .arrow').removeClass('open');

            if(check) {
                $(this).parent().find("ul").removeClass('open');
                $(this).parent().find("ul").slideUp();
                $(this).find(".arrow").removeClass('open');
            } else {
                $(this).parent().find("ul").first().addClass('open');
                $(this).parent().find("ul").first().slideDown();
                $(this).find(".arrow").first().addClass('open');
            }

        });

        $('.sidebar-sub-item').click(function(){
            var check = $(this).parent().find("ul").hasClass('open');

            if(check) {
                $(this).parent().find("ul").removeClass('open');
                $(this).parent().find("ul").slideUp();
                $(this).find(".arrow").removeClass('open');
            } else {
                $(this).parent().find("ul").addClass('open');
                $(this).parent().find("ul").slideDown();
                $(this).find(".arrow").addClass('open');
            }

        });
//        $('.open .dropdown-menu').slideDown('slow');
    })
</script>
</body>
</html>

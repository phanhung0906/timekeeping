<?php
$this->pageTitle='Seminar';
Yii::app()->language= Yii::app()->session['language'];
?>
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

    <!-- Bootstrap CSS framework -->
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrapValidator.min.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" />

    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <!-- //Bootstrap CSS framework -->

    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/css/style.css" />
    <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/font-awesome/css/font-awesome.min.css" />

    <!----ckeditor---->
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/ckeditor/ckeditor.js"></script>
    <!----//ckeditor---->


    <!-- TableSorter -->
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/highcharts/js/highcharts.js"></script>
    <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/highcharts/js/jquery.highchartTable.js"></script>
    <!-- //TableSorter -->
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style='position:relative'>

<div class='allpage'>

    <div class='d-wrapper'>
        <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://<?php echo ROOT_URL ?>" id='logo-text'><img src="http://<?php echo ROOT_URL ?>/assets/vendor/picture/logo.png" /><?php echo CHtml::encode(Yii::app()->name); ?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav" id='mainmenu'>
                        <li><a href="http://<?php echo ROOT_URL ?>/profile" data-url='/profile'><span class="fa fa-user"></span> <?php echo Yii::t('app','Profile'); ?></a></li>
                        <?php if(Yii::app()->session['role'] == 'admin'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/admin" data-url='/admin'><i class="fa fa-users"></i>  <?php echo Yii::t('app','Manage Staff'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'leader'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/leader" data-url='/leader'><i class="fa fa-users"></i>  <?php echo Yii::t('app','Manage Staff'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'director'): ?>
                            <li>   <a href="http://<?php echo ROOT_URL ?>/director" data-url='/director'><i class="fa fa-users"></i>  <?php echo Yii::t('app','Manage Staff'); ?></a></li>
                        <?php endif; ?>
                        <?php if(Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin' || Yii::app()->session['role'] == 'leader'): ?>
                            <li>  <a href="http://<?php echo ROOT_URL ?>/overtime"  data-url='/overtime'><span class="fa fa-bolt"></span> <?php echo Yii::t('app','Overtime'); ?></a></li>
                        <?php endif; ?>
                        <li>  <a href="http://<?php echo ROOT_URL ?>/timekeeping" data-url='/timekeeping'><i class="fa fa-clock-o"></i> <?php echo Yii::t('app','Timekeeping'); ?></a></li>
                        <li> <a href="http://<?php echo ROOT_URL ?>/salary"  data-url='/salary'><span class="fa fa-usd"></span> <?php echo Yii::t('app','Salary'); ?></a></li>
                        <?php if(Yii::app()->session['role'] == 'manager' || Yii::app()->session['role'] == 'admin'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/property" data-url='/property'><i class="fa fa-users"></i> <?php echo Yii::t('app','Property'); ?></a></li>
                        <?php endif; ?>

                        <li><a href="http://<?php echo ROOT_URL ?>/index.php/meeting" data-url='/meeting'><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Meeting room'); ?> </a></li>
                        <?php if(Yii::app()->session['role'] == 'leader' || Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin'): ?>
                            <li><a href="http://<?php echo ROOT_URL ?>/index.php/wdcalendar " data-url='/seminar'><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Seminar'); ?> </a></li>
                        <?php endif; ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php if(Yii::app()->session['role'] != null): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id='menu-dropdown'> <?php echo Yii::t('app','Hello'); ?> <strong><?php echo Yii::app()->session['user'] ?></strong> <b class="caret"></b></a>
                                <ul class="dropdown-menu" style='width:200px;'>
                                    <li><a href="http://<?php echo ROOT_URL ?>"><span class='fa fa-home'></span> <?php echo Yii::t('app','Home'); ?></a></li>
                                    <li class="divider"></li>
                                    <li class='dropdown-header'> <?php echo Yii::t('app','Setting'); ?></li>
                                    <?php if(Yii::app()->session['role'] == 'admin' || Yii::app()->session['role'] == 'director'): ?>
                                        <li> <a href="http://<?php echo ROOT_URL ?>/chart" data-url='/chart'> <?php echo Yii::t('app','Chart'); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(Yii::app()->session['role'] == 'admin'): ?>
                                        <li> <a href="http://<?php echo ROOT_URL ?>/update"  data-url='/update'> <?php echo Yii::t('app','Update'); ?></a></li>
                                        <li> <a href="http://<?php echo ROOT_URL ?>/setting"  data-url='/setting'> <?php echo Yii::t('app','Set up'); ?></a></li>
                                    <?php endif; ?>
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
        <div class="d-main" style="padding-top: 70px;">
            <ol class="breadcrumb">
                <li><a href="/atmarkcafe"><?php echo Yii::t('app','Dashboard'); ?></a></li>
                <li class="active"><b><?php echo Yii::t('app','Seminar'); ?></b></li>
                <?php if(Yii::app()->session['role'] == 'leader' || Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin'): ?>
                <li style="float:right;  font-weight:bold;"><a style="color:red;" href="http://<?php echo ROOT_URL ?>/index.php/wdcalendar/default/lstsendmail" data-url='/wdcalendar'><i ></i><?php echo Yii::t('app','List Send Mail') ?></a></li>
                <?php endif; ?>
            </ol>
            <div class="d-content-wrapper">
                <div class="d-content container">

                    <div>
                            <div id="calhead" style="padding-left:1px;padding-right:1px;">          
                                <div class="cHead"><div class="ftitle"><?php echo CHtml::link(Yii::app()->name, Yii::app()->controller->createUrl( '/' ) ); ?></div>
                                <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
                                 <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
                                </div>          
                                
                                <div id="caltoolbar" class="ctoolbar">
                                  <div id="faddbtn" class="fbutton">
                                    <?php if( ! array_key_exists( 'readonly', $this->module->wd_options ) || $this->module->wd_options[ 'readonly' ] != 'JS:true' ) : // TODO make this prettier ?>
                                        <div>
                                            <span title='Click to Create New Event' class="addcal">
                                                <?php echo Yii::t('app','New Event'); ?>              
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="btnseparator"></div>
                                 <div id="showtodaybtn" class="fbutton">
                                    <div><span title='Click to back to today ' class="showtoday">
                                    <?php echo Yii::t('app','Today'); ?></span></div>
                                </div>
                                  <div class="btnseparator"></div>

                                <div id="showdaybtn" class="fbutton">
                                    <div><span title='Day' class="showdayview"><?php echo Yii::t('app','Day'); ?></span></div>
                                </div>
                                  <div  id="showweekbtn" class="fbutton">
                                    <div><span title='Week' class="showweekview"><?php echo Yii::t('app','Week'); ?></span></div>
                                </div>
                                  <div  id="showmonthbtn" class="fbutton fcurrent">
                                    <div><span title='Month' class="showmonthview"><?php echo Yii::t('app','Month'); ?></span></div>

                                </div>
                                <div class="btnseparator"></div>
                                  <div  id="showreflashbtn" class="fbutton">
                                    <div><span title='Refresh view' class="showdayflash"><?php echo Yii::t('app','Refresh'); ?></span></div>
                                    </div>
                                 <div class="btnseparator"></div>
                                <div id="sfprevbtn" title="Prev"  class="fbutton">
                                  <span class="fprev"></span>

                                </div>
                                <div id="sfnextbtn" title="Next" class="fbutton">
                                    <span class="fnext"></span>
                                </div>
                                <div class="fshowdatep fbutton">
                                        <div>
                                            <input type="hidden" name="txtshow" id="hdtxtshow" />
                                            <span id="txtdatetimeshow"><?php echo Yii::t('app','Loading'); ?></span>

                                        </div>
                                </div>
                                
                                <div class="clear"></div>
                                </div>
                            </div>
                            <div style="padding:1px;">

                            <div class="t1 chromeColor">
                                &nbsp;</div>
                            <div class="t2 chromeColor">
                                &nbsp;</div>
                            <div id="dvCalMain" class="calmain printborder">
                                <div id="gridcontainer" style="overflow-y: visible;">
                                </div>
                            </div>
                            <div class="t2 chromeColor">

                                &nbsp;</div>
                            <div class="t1 chromeColor">
                                &nbsp;
                            </div>   
                        </div>
                    </div>

                    <div class="clear"></div>

                </div><!-- page -->

            </div>
        </div>
    </div>
<!--    <footer style="background-color: #18191B;padding:20px;color:#ffffff">-->
<!--        <div class="container" style="max-width: 70%;font-size: 16px">-->
<!--            @ Copyright 2014 <a href="http://apl.vn">apl.vn</a>. All Rights Reserved-->
<!--        </div>-->
<!--    </footer>-->
    <footer>
        <div class='container'>
            Copyright &copy; <?php echo date('Y'); ?> All Rights Reserved
        </div>
    </footer>
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

        $('#mainmenu').find('li').each(function(index, item) {
            var path = window.location.pathname;
            if (path.substr(0, $(this).find('a').data('url').length) == $(this).find('a').data('url')) {
                $(this).addClass('active');
            }
        });
        if( parseInt($(window ).height()) >= parseInt($(document ).height()) )
            $('body').css({'height': $(window ).height()+'px'});
    })
</script>
</body>
</html>

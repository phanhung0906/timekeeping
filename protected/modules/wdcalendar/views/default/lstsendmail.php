<?php
$this->pageTitle='Remind';
Yii::app()->language= Yii::app()->session['language'];
$date = getdate();
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
<?php Yii::app()->language= Yii::app()->session['language']; ?>
<div class='allpage'>

    <div id='overlay-full' style='display:none'>
        <div style="z-index: 2000;position: fixed;top:200px;width:100%">
            <div style="margin: 0 auto;text-align: center">
                <div style='display:inline;padding:25px;background-color: #222222;opacity: 0.9;'>
                    <b style='font-size:18px;color:#ffffff;padding-right: 10px;'><?php echo Yii::t('app','Loading') ?> </b><img src="http://<?php echo ROOT_URL ?>/../assets/vendor/picture/ajax-loader.GIF" />
                </div>
            </div>
        </div>
    </div>

    <div class='d-wrapper'>
        <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://<?php echo ROOT_URL ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
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
                        <li><a href="http://<?php echo ROOT_URL ?>/property" data-url='/atmarkcafe/property'><i class="fa fa-users"></i> <?php echo Yii::t('app','Property Manager'); ?></a></li>
                        <?php endif; ?>
                        <li><a href="http://<?php echo ROOT_URL ?>/index.php/meeting" data-url='/meeting'><i class="fa fa-calendar"></i><?php echo Yii::t('app','Meeting room'); ?> </a></li>
                        <?php if(Yii::app()->session['role'] == 'leader' || Yii::app()->session['role'] == 'director' || Yii::app()->session['role'] == 'admin'): ?>
                        <li><a href="http://<?php echo ROOT_URL ?>/index.php/wdcalendar " data-url='/seminar'><i class="fa fa-calendar"></i><?php echo Yii::t('app','Seminar'); ?> </a></li>
                        <?php endif; ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <form class="navbar-form navbar-left" role="search" method="post" id='searchForm' style='display: none'>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo Yii::t('app','Search as username'); ?>" name="search">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit"><?php echo Yii::t('app','Submit'); ?></button>
                        </form>
                        <?php if(Yii::app()->session['role'] != null): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo Yii::t('app','Hello'); ?> <?php echo Yii::app()->session['user'] ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu" style='width:200px;'>
                                <li><a href="http://<?php echo ROOT_URL ?>"><span class='fa fa-home'></span> <?php echo Yii::t('app','Home'); ?></a></li>
                                <li class="divider"></li>
                                <li class='dropdown-header'> <?php echo Yii::t('app','Setting'); ?></li>
                                <li><a href="http://<?php echo ROOT_URL ?>/setting/changePassword"> <?php echo Yii::t('app','Change password'); ?></a></li>
                                <li><a href="http://<?php echo ROOT_URL ?>/setting/profile"> <?php echo Yii::t('app','Edit profile'); ?></a></li>
                                <?php if(Yii::app()->session['role'] == 'admin'): ?>
                                <li> <a href="http://<?php echo ROOT_URL ?>/chart" data-url='/chart'><span class="fa fa-bar-chart-o"></span> <?php echo Yii::t('app','Chart'); ?></a></li>
                                <?php endif; ?>
                                <?php if(Yii::app()->session['role'] == 'admin'): ?>
                                <li> <a href="http://<?php echo ROOT_URL ?>/update"  data-url='/update'><span class="fa fa-globe"></span> <?php echo Yii::t('app','Update'); ?></a></li>
                                <li> <a href="http://<?php echo ROOT_URL ?>/setting"  data-url='/setting'><span class="fa fa-cog"></span> <?php echo Yii::t('app','Setting'); ?></a></li>
                                <?php endif; ?>
                                <li class="divider"></li>
                                <li class='dropdown-header'> <?php echo Yii::t('app','Language'); ?></li>
                                <li><a href="#" class='lang' data-lang='en'> <?php echo Yii::t('app','En'); ?></a></li>
                                <li><a href="#" class='lang' data-lang='vi'> <?php echo Yii::t('app','Vi'); ?></a></li>
                                <li class="divider"></li>
                                <li><a href="http://<?php echo ROOT_URL ?>/site/logout"><span class="fa fa-power-off"></span> <?php echo Yii::t('app','Sign out'); ?></a></li>
                            </ul>
                        </li>
                        <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo Yii::t('app','Action'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu" style='width:200px;'>
                                <li class='dropdown-header'> <?php echo Yii::t('app','Language'); ?></li>
                                <li><a href="#" class='lang' data-lang='en'> <?php echo Yii::t('app','En'); ?></a></li>
                                <li><a href="#" class='lang' data-lang='vi'> <?php echo Yii::t('app','Vi'); ?></a></li>
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
                <li><a href="/atmarkcafe"><?php echo Yii::t('app','Dashboard') ?></a></li>
                <li class="active"><a href="http://<?php echo ROOT_URL ?>/index.php/wdcalendar"><?php echo Yii::t('app','Seminar') ?></a></li>
                <li class="active"><b><?php echo Yii::t('app','SendMail') ?></b></li>
            </ol>




            <div class="d-content-wrapper">

                <div class="d-content container">

                    <div id='notify'>

                    </div>
                    <div id='divSuccess' class='hide' >
                        <div class='alert alert-success'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Send mail successfully') ?>
                        </div>
                    </div>
                    <div id='divError' class='hide'>
                        <div class='alert alert-danger' id='error'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your email is not sended') ?>
                        </div>
                    </div>
                    <div id='divError2' class='hide'>
                        <div class='alert alert-danger' id='error'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your must choose at least 1 staff to send') ?>
                        </div>
                    </div>

                    <div class="page-header">
                        <h3><?php echo Yii::t('app','List Send Mail') ?></h3>
                    </div>
                    <div class="page-header">
                            <button type="button" class='btn btn-default'> <th><input id='checkAll' type="checkbox"></th> <i class="fa fa-caret-down"></i> </button>
                            <a class='btn btn-primary' id='sendMail'><i class="fa fa-inbox"></i> <?php echo Yii::t('app','Send email') ?></a>
                    </div>


                    <table  class='table table-hover' class="col-md-4" >
                        
                        <tr id="tb_title">
                            <th ><?php echo Yii::t('app','#') ?></th>
                            <th><?php echo Yii::t('app','Username') ?></th>
                            <th><?php echo Yii::t('app','Start') ?></th>
                            <th><?php echo Yii::t('app','Remind Time') ?></th> 
                        </tr>
                        <?php 
                        for($i = 0; $i < count($lst); $i++){
                            if (strlen($date['mon'])==1) {
                                $mon = '0'.$date['mon'];
                            }
                            if (strlen($date['mday'])==1) {
                                $day = '0'.$date['mday'];
                            }
                            $datenow = $date['year'].''.$mon.''.$day;

                            $t = explode(' ', $lst[$i]['StartTime']);
                            $datestart = explode('-', $t[0]);
                            $dt = $datestart[0].''.$datestart[1].''.$datestart[2];
                            
                            if ($dt ==  $datenow ) { 
                                $timestart = explode(':', $t[1]);
                                $time =  $timestart[0]*60 + $timestart[1];
                                $t=$date['hours']*60 +$date["minutes"]+300;
                                $a = $time-$t;
                                if ($a == 15) {
                            echo '
                                <tr>
                                    <td><input type="checkbox" class="checkbox" name="email" value="';?><?php echo $lst[$i]['user_id'].','.$lst[$i]['email'] ?><?php echo '"></td>
                                    <td >'.$lst[$i]['username'].'</td>
                                    <td >'.$lst[$i]['StartTime'] .' </td>
                                    <td >'.$a.' </td>
                                </tr>
                            ';
                                }
                            }
                        } 
                        ?>
                        </tbody>
                    </table>


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




<script type='text/javascript'>
    $(document).ready(function(){
        $('#checkAll').click(function(){
            if ($('#checkAll').is(":checked"))
            {
               $('.checkbox').prop('checked',true);
            } else{
                $('.checkbox').prop('checked',false);
            }
        });

        $('#sendMail').click(function(){
            $('#overlay-full').show();
            var values = new Array();
            $.each($("input[name='email']:checked"), function() {
                values.push($(this).val());
            });
            if(values.length == 0){
                $('#overlay-full').hide();
                $('#notify').html('');
                var notify = $('#divError2').html();
                $(notify).appendTo('#notify');
                return ;
            }
            //$month = $('#month').val();
            //$year  = $('#year').val();
            $.ajax({
                type: 'post',
                url: "http://<?php echo ROOT_URL ?>/property/sendmail",
                data:{
                    arrayUser : JSON.stringify(values),
                    //month     : $month,
                    //year      : $year
                }
            }).done(function(response){
                    $('#overlay-full').hide();
                    $('#notify').html('');
                    if(response == 1){
                        var notify = $('#divSuccess').html();
                        $(notify).appendTo('#notify');
                    } else {
                        var notify = $('#divError').html();
                        $(notify).appendTo('#notify');
                    }
                })
        })
    })
</script>
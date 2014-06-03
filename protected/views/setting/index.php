<?php
$this->pageTitle='Setting';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Setting') ?></b></li>
</ol>
<div id='notify'>

</div>
<div id='divNotNumber' style='display: none' >
    <div class='alert alert-danger' id='notNumber'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your input is not Number') ?>
    </div>
</div>
<div id='divBonusError' style='display: none' >
    <div class='alert alert-danger' id='bonusError'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your update bonus is error') ?>
    </div>
</div>

<div id='divNotEmail' style='display: none' >
    <div class='alert alert-danger' id='notEmail'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your input is not Email') ?>
    </div>
</div>
<div id='divEmailError' style='display: none' >
    <div class='alert alert-danger' id='emailError'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your update email is error') ?>
    </div>
</div>

<div id='divSuccess' style='display: none' >
    <div class='alert alert-success' id='success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Your set up is successfully') ?>
    </div>
</div>
<div id='divError' style='display: none' >
    <div class='alert alert-danger' id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your set up is error, Time in must be smaller than Time out') ?>
    </div>
</div>
<div id='div2' class='hide'>
    <div class='alert alert-danger' id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your set up is error, Time start break must be smaller than time end break') ?>
    </div>
</div>
<div id='div3' class='hide'>
    <div class='alert alert-danger' id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your set up is error, Time break is not larger than time in and smaller than time out') ?>
    </div>
</div>

<div class='page-header'>
    <h3 class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Setting') ?></h3>
</div>

<ul class="nav nav-tabs" id='listMenu' style='margin-bottom: 20px'>
    <li class="active" id='tk'><a href="#"><?php echo Yii::t('app','Timekeeping') ?></a></li>
    <li id='salary'><a href="#"><?php echo Yii::t('app','Salary') ?></a></li>
    <li id='company'><a href="#"><?php echo Yii::t('app','Company') ?></a></li>
</ul>

<div class="row show-grid" id='divES'>
    <div class="col-md-6" id='divSalary'>
        <div class="panel panel-primary">
            <div class="panel-heading"><h4><?php echo Yii::t('app','Bonus') ?></h4></div>
            <div class="panel-body">
                <h4 class='text-primary'><?php echo Yii::t('app','Current bonus') ?> : <span id='currentBonus'> <?php echo $currentBonus ?> .000 / <?php echo Yii::t('app','day') ?> </span></h4>
                <form role="form-inline" style="padding-left: 20px;" class="form-horizontal" id='bonusForm'>
                    <div class="form-group">
                        <a class='btn btn-primary' id='submitBonus' style='margin-bottom: 3px'><?php echo Yii::t('app','Submit') ?></a>
                        <input class="form-control" id='bonus' style='width:50%;display:inline;margin-bottom: 10px' placeholder='<?php echo Yii::t('app','bonus') ?>...'>
                        <h3 style='display: inline' class='text-primary'> .000 VND</h3>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6" id='divCompany'>
        <div class="panel panel-primary">
            <div class="panel-heading"><h4><?php echo Yii::t('app','Email') ?></h4></div>
            <div class="panel-body">
                <h4 class='text-primary'><?php echo Yii::t('app','Current company email') ?> : <span id='currentEmail'> <?php echo $currentMail ?> </span></h4>
                <form role="form-inline" style="padding-left: 20px;" class="form-horizontal" id='emailForm'>
                    <div class="form-group">
                        <a class='btn btn-primary' id='submitEmail' style='margin-bottom: 3px'><?php echo Yii::t('app','Update') ?></a>
                        <input class="form-control" id='email' style='width:40%;display:inline;margin-bottom: 10px' placeholder='<?php echo Yii::t('app','Email company') ?>...'>
                        <input class="form-control" id='password' style='width:40%;display:inline;margin-bottom: 10px' placeholder='<?php echo Yii::t('app','Password') ?>...'>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-primary" id='divTK' style='width:50%'>
    <div class="panel-heading"><h4><?php echo Yii::t('app','Time') ?></h4></div>
    <div class="panel-body">
            <h4 class='text-info'><?php echo Yii::t('app','Time in') ?> : <span id='timeIn'> <?php echo $timeIn ?></span></h4>
            <h4 class='text-info'><?php echo Yii::t('app','Time out') ?> : <span id='timeOut'><?php echo $timeOut ?></span></h4>
            <h4 class='text-info'><?php echo Yii::t('app','Break') ?> : <?php echo Yii::t('app','from') ?> <span id='breakFrom'><?php echo $breakFrom ?></span> <?php echo Yii::t('app','to') ?> <span id='breakTo'><?php echo $breakTo ?></span></h4>
            <form role="form" class="form-horizontal" id='form'>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Time in') ?></label>
                    <div class="col-sm-8">
                        <select class="form-control" id='hoursIn' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 24; $i++): ?>
                            <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <span> : </span>
                        <select class="form-control" id='minutesIn' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 60; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Time out') ?></label>
                    <div class="col-sm-8">
                        <select class="form-control" id='hoursOut' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 24; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <span> : </span>
                        <select class="form-control" id='minutesOut' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 60; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Break') ?></label>
                    <div class="col-sm-8">
                        <span><?php echo Yii::t('app','from') ?> </span>
                        <select class="form-control" id='hoursFrom' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 24; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <span> : </span>
                        <select class="form-control" id='minutesFrom' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 60; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-md-8">
                        <span><?php echo Yii::t('app','to') ?> </span>
                        <select class="form-control" id='hoursTo' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 24; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <span> : </span>
                        <select class="form-control" id='minutesTo' style='width:20%;display: inline'>
                            <?php for($i = 0; $i < 60; $i++): ?>
                                <option><?php if(strlen($i) ==1){ echo '0'.$i; } else echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-md-8">
                          <a class='btn btn-primary' id='submit'><?php echo Yii::t('app','Submit') ?></a>
                    </div>
                </div>
            </form>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(function() {
        $('#submitBonus').click(function(){
            $bonus = $('#bonus').val();
            var intRegex = /^\d+$/;
            if(intRegex.test($bonus)){
                $.ajax({
                    type: 'post',
                    url : "http://<?php echo ROOT_URL ?>/setting",
                    data: {
                      bonus : $bonus
                    }
                }).done(function(response){
                        $('#notify').html('');
                        if(response == 1) {
                            var notify = $('#divSuccess').html();
                            $(notify).appendTo('#notify');
                            $('#currentBonus').html('').html($bonus+'.000 / day');
                            $('#bonus').val('');
                        } else {
                            var notify = $('#divBonusError').html();
                            $(notify).appendTo('#notify');
                        }
                })
            } else {
                $('#notify').html('');
                var notify = $('#divNotNumber').html();
                $(notify).appendTo('#notify');
            }
        });

        $('#submitEmail').click(function(){
            $email = $('#email').val();
            $password = $('#password').val();
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if(testEmail.test($email)){
                $.ajax({
                    type: 'post',
                    url : "http://<?php echo ROOT_URL ?>/setting",
                    data: {
                        email : $email,
                        password : $password
                    }
                }).done(function(response){
                        $('#notify').html('');
                        if(response == 1) {
                            var notify = $('#divSuccess').html();
                            $(notify).appendTo('#notify');
                            $('#currentEmail').html('').html($email);
                            $('#email').val('');
                            $('#password').val('');
                        } else {
                            var notify = $('#divEmailError').html();
                            $(notify).appendTo('#notify');
                        }
                    })
            } else {
                $('#notify').html('');
                var notify = $('#divNotEmail').html();
                $(notify).appendTo('#notify');
            }
        })

        $('#submit').click(function(){
            $('#overlay-full').show();
            $hoursIn    = $('#hoursIn').val();
            $minutesIn  = $('#minutesIn').val();
            $hoursOut   = $('#hoursOut').val();
            $minutesOut = $('#minutesOut').val();
            $hoursFrom    = $('#hoursFrom').val();
            $minutesFrom  = $('#minutesFrom').val();
            $hoursTo    = $('#hoursTo').val();
            $minutesTo    = $('#minutesTo').val();
            $.ajax({
                type: 'post',
                url : "http://<?php echo ROOT_URL ?>/setting",
                data: {
                    hoursIn     : $hoursIn,
                    minutesIn   : $minutesIn,
                    hoursOut    : $hoursOut,
                    minutesOut  : $minutesOut,
                    hoursFrom   : $hoursFrom,
                    minutesFrom : $minutesFrom,
                    hoursTo     : $hoursTo,
                    minutesTo    : $minutesTo
                }
            }).done(function(response){
                $('#overlay-full').hide();
                $('#notify').html('');
                if(response == 1) {
                   var notify = $('#divSuccess').html();
                   $(notify).appendTo('#notify');
                    $('#timeIn').html('').html($hoursIn+' : '+$minutesIn);
                    $('#timeOut').html('').html($hoursOut+' : '+$minutesOut);
                    $('#breakFrom').html('').html($hoursFrom+' : '+$minutesFrom);
                    $('#breakTo').html('').html($hoursTo+' : '+$minutesTo);
                } else if(response == 0){
                    var notify = $('#divError').html();
                    $(notify).appendTo('#notify');
                } else if(response == 2){
                    var notify = $('#div2').html();
                    $(notify).appendTo('#notify');
                } else if(response == 3){
                    var notify = $('#div3').html();
                    $(notify).appendTo('#notify');
                }
            })
        });

        $('#divCompany').hide();
        $('#divSalary').hide();
        $('#divTK').hide();
        $('#divTK').fadeIn(1000);
        $('#tk').click(function(){
            $('#listMenu').find('li').removeClass('active');
            $('#tk').addClass('active');
            $('#divCompany').hide();
            $('#divSalary').hide();
            $('#divTK').fadeIn();
        });
        $('#salary').click(function(){
            $('#listMenu').find('li').removeClass('active');
            $('#salary').addClass('active');
            $('#divCompany').hide();
            $('#divTK').hide();
            $('#divSalary').fadeIn();
        });
        $('#company').click(function(){
            $('#listMenu').find('li').removeClass('active');
            $('#company').addClass('active');
            $('#divTK').hide();
            $('#divSalary').hide();
            $('#divCompany').fadeIn();
        });
    });
</script>
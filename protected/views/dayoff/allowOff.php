<?php
$this->pageTitle='Manage User';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/dayoff/list/ur/<?php echo Yii::app()->session['role'] ?>"><?php echo Yii::t('app','List User') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/dayoff"><?php echo Yii::t('app','List day off') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Allow') ?></b></li>
</ol>

    <div class='alert alert-danger animate-in'  data-anim-type="flip-in-top-front" data-anim-delay="500"  style='display: none' id='alert3'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Account have been confirmed to excused absence') ?>
    </div>

    <div class='alert alert-danger animate-in'  data-anim-type="flip-in-top-front" data-anim-delay="500"  id='alert1' style='display: none'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Regist time false') ?>
    </div>

<div class="container animate-in"  data-anim-type="bounce-in-up-large" data-anim-delay="500" >
    <div class="row">
        <section>
            <div class="col-lg-8 col-lg-offset-2">
                <div id="form" class="form-horizontal">
                    <fieldset>
                        <legend><?php echo $user['fullname'] ?></legend>

                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo Yii::t('app','Group') ?></label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="group" value="<?php echo $user['group_user'] ?>" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo Yii::t('app','Hour remain') ?></label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="hourRemain" value="<?php echo round((float)$user['hour_allow']/60,2) ?>" readonly />
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><?php echo Yii::t('app','Day off infomation') ?></legend>

                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo Yii::t('app','Day') ?></label>
                            <div class="col-lg-5">
                                <div id="datetimepicker1" class="input-append date">
                                    <input data-date-format="yyyy-mm-dd" type="text" class='form-control' id="newDate1" style='width:88%;display:inline;margin-bottom: 5px' name='day' value="<?php echo date('Y-m-d') ?>">
                                    <i class='glyphicon glyphicon-calendar' data-date-icon="icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo Yii::t('app','Hour off') ?></label>
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
                            <label class="col-lg-3 control-label"></label>
                            <div class="col-sm-8">
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
                            <label class="col-lg-3 control-label"><?php echo Yii::t('app','Reason') ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="3" id='reason'></textarea>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary" id='submit'><?php echo Yii::t('app','Submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });

        $('#submit').click(function(){
            $('#overlay-full').show();
            $hoursFrom    = $('#hoursFrom').val();
            $minutesFrom  = $('#minutesFrom').val();
            $hoursTo    = $('#hoursTo').val();
            $minutesTo    = $('#minutesTo').val();
            $reason = $('#reason').val();
            $id = <?php echo $_GET['id'] ?>;
            $day = $('#newDate1').val();
            console.log($hoursFrom+','+$hoursTo+','+$minutesFrom+','+$minutesTo+','+$reason+','+$id+','+$day);
            $.ajax({
                type: 'post',
                url : "http://<?php echo ROOT_URL ?>/dayoff/regist",
                data: {
                    hoursFrom   : $hoursFrom,
                    minutesFrom : $minutesFrom,
                    hoursTo     : $hoursTo,
                    minutesTo   : $minutesTo,
                    reason      : $reason,
                    id          : $id,
                    day         : $day
                }
            }).done(function(response){
                switch (response){
                    case '1':
                        $('#alert3').hide();
                        $('#alert1').show();
                        break;
                    case '2':
                        window.location.replace("http://<?php echo ROOT_URL ?>/dayoff");
                        break;
                    case '3':
                        $('#alert1').hide();
                        $('#alert3').show();
                        break;
                    default :
                        break;
                }
            })
        });
    })
</script>

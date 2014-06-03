<?php
$this->pageTitle = 'Update';
Yii::app()->language= Yii::app()->session['language'];
$date   = getdate();
$ts     = mktime(0,0,0,$date['mon'],1,$date['year']);
$numDayOfMonth = date('t', $ts);
?>
<ol class='breadcrumb'>
    <li><a href='http://<?php echo ROOT_URL ?>'><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Update') ?></b></li>
</ol>
<div id='notify'>

</div>
<div id='divSuccess' class='hide' >
    <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Update successfully') ?>
    </div>
</div>
<div id='divError' class='hide'>
    <div class='alert alert-danger' id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your max day update must be less than 2 month in a year') ?>
    </div>
</div>
<div id='divError2' class='hide'>
    <div class='alert alert-danger' id='error2'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app',"Not found server to update") ?>
    </div>
</div>
<div id='divError3' class='hide'>
    <div class='alert alert-danger' id='error3'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app',"'From' and 'to' must not null") ?>
    </div>
</div>

<div class="page-header">
    <h3><?php echo Yii::t('app','Update') ?></h3>
</div>

<h4 class='text-info' data-toggle="tooltip" title="<?php echo Yii::t('app','Choose date that you want to update from timekeeping machhine') ?>" style='display: inline'><?php echo Yii::t('app','Choose date you want update') ?> :</h4>
<form class="form-inline" role="form" style='padding: 30px 0' id='chooseDate'>
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='from' placeholder="<?php echo Yii::t('app','From') ?>" >
        </div>
    </div>
    <div class="form-group">
        <div id="datetimepicker2" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate2" style='width:80%;display:inline;margin-bottom: 5px' name='to' placeholder="<?php echo Yii::t('app','To') ?>" >
        </div>
    </div>
    <a id='submit' class="btn btn-primary" style='margin-bottom: 5px'><?php echo Yii::t('app','Update') ?></a>
</form>
<script type="text/javascript">
    $(function() {
        $('h4').tooltip();
        $('#datetimepicker1 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });
        $('#datetimepicker2 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });
    })

    $('#submit').click(function(){
        $('body').waitMe({
            effect: 'win8_linear',
            text: 'Please waiting...',
            bg: 'rgba(255,255,255,0.7)',
            color:'#000'
        });
        $('body').find('.waitMe_text').css('font-size','20px');
        $from    = $('#newDate1').val();
        $to    = $('#newDate2').val();
        $.ajax({
            type: 'post',
            url : "http://<?php echo ROOT_URL ?>/update/days",
            data: {
                from     : $from,
                to       : $to
            }
        }).done(function(response){
                $('body').waitMe('hide');
                $('#notify').html('');
                if(response == 1){
                    var notify = $('#divSuccess').html();
                    $(notify).appendTo('#notify');
                } else if(response == 2){
                    var notify = $('#divError2').html();
                    $(notify).appendTo('#notify');
                } else if(response == 3){
                    var notify = $('#divError3').html();
                    $(notify).appendTo('#notify');
                } else {
                    var notify = $('#divError').html();
                    $(notify).appendTo('#notify');
                }
            })
    });
</script>
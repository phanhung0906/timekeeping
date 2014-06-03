<?php
$this->pageTitle='Salary';
Yii::app()->language= Yii::app()->session['language'];
$date = getdate();
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Staff') ?></b></li>
</ol>
<div id='notify'>

</div>
<div id='divSuccess' class='hide' >
    <div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Send mail successfully') ?>
    </div>
</div>
<div id='divError' class='hide'>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500" id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your email is not sended') ?>
    </div>
</div>
<div id='divError2' class='hide'>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500" id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your must choose at least 1 staff to send') ?>
    </div>
</div>

<div class="page-header">
    <h3  class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Staff') ?></h3>
</div>
<div class="page-header animate-in" data-anim-type="bounce-in-right-large" data-anim-delay="500">
        <button type="button" class='btn btn-default'> <th><input id='checkAll' type="checkbox"></th> <i class="fa fa-caret-down"></i> </button>
        <a class='btn btn-primary' id='sendMail'><i class="fa fa-inbox"></i> <?php echo Yii::t('app','Send email') ?></a>
</div>
<h5 class='text-info animate-in' data-anim-type="bounce-in-right-large" data-anim-delay="500"><?php echo Yii::t('app','Choose month that you want to send Payslip') ?></h5>
<form class="form-inline animate-in" role="form" style='padding-bottom: 30px;' method="post" id='chooseDate' data-anim-type="bounce-in-right-large" data-anim-delay="500">
    <div class="form-group">
        <label class="control-label"><?php echo Yii::t('app','Month') ?></label>
        <select class="form-control" id='month'>
            <?php for($j = 1; $j < 13; $j++): ?>
                <option <?php if($j == $date['mon']) echo 'selected' ?>><?php if(strlen((string)$j) == 1){ echo '0'.$j; } else echo $j ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label"><?php echo Yii::t('app','Year') ?></label>
        <select class="form-control" id='year'>
            <?php for($i = $date['year']; $i > $date['year']-3; $i--): ?>
                <option><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</form>

<table class='table table-hover table-bordered animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="500" id='adminIndex' style='width:50%'>
    <thead>
    <tr class='active'>
        <th>#</th>
        <th><?php echo Yii::t('app','Full name') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0; $i<count($user); $i++): ?>
        <?php if($user[$i]['user_id'] == 3) continue; ?>
    <tr>
          <th><input type="checkbox" class='checkbox' name='email' value="<?php echo $user[$i]['user_id'].','.$user[$i]['email'] ?>"></th>
          <th><a href="http://<?php echo ROOT_URL ?>/salary/admin/id/<?php echo $user[$i]['user_id'] ?>"><?php echo $user[$i]['fullname'] ?></a></th>
    </tr>
    <?php endfor; ?>
    </tbody>
</table>


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
            $month = $('#month').val();
            $year  = $('#year').val();
            $.ajax({
                type: 'post',
                url: "http://<?php echo ROOT_URL ?>/admin/sendmail",
                data:{
                    arrayUser : JSON.stringify(values),
                    month     : $month,
                    year      : $year
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
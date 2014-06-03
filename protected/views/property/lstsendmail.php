<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
$date = getdate();
?>

<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><a href="http://<?php echo ROOT_URL?>/property"><?php echo Yii::t('app','Property') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','SendMail') ?></b></li>
</ol>
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
    <h3><?php echo Yii::t('app','Property') ?></h3>
</div>
<div class="page-header">
        <button type="button" class='btn btn-default'> <th><input id='checkAll' type="checkbox"></th> <i class="fa fa-caret-down"></i> </button>
        <a class='btn btn-primary' id='sendMail'><i class="fa fa-inbox"></i> <?php echo Yii::t('app','Send email') ?></a>
</div>


<table  class='table table-hover' class="col-md-4" >
	
    <tr id="tb_title">
        <th ><?php echo Yii::t('app','#') ?></th>
        <th><?php echo Yii::t('app','Username') ?></th>
        <th><?php echo Yii::t('app','Return Date') ?></th>
        <th><?php echo Yii::t('app','Return Time') ?></th>
        <th><?php echo Yii::t('app','Status')?></th>
    </tr>
    <?php 
    for($i = 0; $i < count($send); $i++){ 
        $r_t = $send[$i]['r_time'];
        $t= explode(':', $r_t);
        $a = $t[0]*60+$t[1];
        $h=$date['hours'];
        $m=$date["minutes"];
        $t=$h*60 +$m+300;
        if ($a == 15) {
    echo '
        <tr>
            <td><input type="checkbox" class="checkbox" name="email" value="';?><?php echo $send[$i]['user_id'].','.$send[$i]['email'] ?><?php echo '"></td>
            <td >'.$send[$i]['username'].'</td>
            <td >'.$send[$i]['r_date'] .' '.$send[$i]['r_time'] .' </td>
            <td>'.($a- $t).'</td>
            <td>'.$send[$i]['status'].'</td>
        </tr>
    ';
        }
    } 
    ?>
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
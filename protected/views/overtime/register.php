<?php
$this->pageTitle='Overtime';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/overtime"><?php echo Yii::t('app','Overtime') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Register') ?></b></li>
</ol>
<?php if(Yii::app()->admin->hasFlash('error')):?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','You must select at least 1 user') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error'); ?>
<?php endif; ?>
<form role="form" style="width:50%" method='post' class="form-horizontal animate-in" id='form' data-anim-type="zoom-in-right-large" data-anim-delay="0">
    <div class="page-header">
        <button type="button" class='btn btn-default'> <th><input id='checkAll' type="checkbox"></th> <i class="fa fa-caret-down"></i> </button>
        <button type='submit' class='btn btn-primary'><i class="fa fa-floppy-o"></i> <?php echo Yii::t('app','Save') ?></button>
    </div>
    <h5 class='text-info'><?php echo Yii::t('app','Choose date that you want to regist') ?></h5>
    <div class="form-group" style='margin-left: 1px'>
            <label class="control-label" style='float:left'><?php echo Yii::t('app','Date') ?></label>
            <div id="datetimepicker1" class="input-append date">
                <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" style='width:30%;display:inline;margin-bottom: 5px;margin-left: 5px' name='date'  value="<?php echo date('d-m-Y') ?>">
            </div>
    </div>

    <table class='table table-hover table-bordered' id='adminIndex' style='width:50%'>
        <thead>
        <tr class='active'>
            <th>#</th>
            <th><?php echo Yii::t('app','Full name') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php for($i = 0; $i < count($user); $i++): ?>
            <?php if($user[$i]['username'] == 'admin') continue; ?>
            <tr>
                <th><input class='checkbox' type="checkbox" name="check[]" value='<?php echo $user[$i]['user_id'] ?>'></th>
                <th>   <?php echo $user[$i]['fullname'] ?></th>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    $(function() {
        $('#datetimepicker1 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });

        $('#checkAll').click(function(){
            if ($('#checkAll').is(":checked"))
            {
                $('.checkbox').prop('checked',true);
            } else{
                $('.checkbox').prop('checked',false);
            }
        });

    })
</script>
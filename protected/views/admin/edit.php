<?php
$this->pageTitle='Edit admin';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/admin"><?php echo Yii::t('app','List User') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Edit user') ?></b></li>
</ol>

<?php if(Yii::app()->admin->hasFlash('success')): ?>
    <div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Account have been update successfully') ?>
    </div>
   <?php Yii::app()->admin->getFlash('success'); ?>
<?php elseif(Yii::app()->admin->hasFlash('error')): ?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app',"You haven't change infomation") ?>
    </div>
    <?php Yii::app()->admin->getFlash('error'); ?>
<?php endif; ?>

<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Edit user') ?></h3>
</div>
<div class="page animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="500">
    <div class="maintain">
        <div style="padding-left:5%; ">
            <form role="form" style="width:50%" method='post' class="form-horizontal" id='form'>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','User name') ?> <span class='text-danger'>*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" name='username' value='<?php echo $user['username'] ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Full name') ?> <span class='text-danger'>*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" name='fullname' value='<?php echo $user['fullname'] ?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Email') ?> <span class='text-danger'>*</span></label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value='<?php echo $user['email'] ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Basic salary') ?> <span class='text-danger'>*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="salary" value='<?php echo $user['basicSalary'] ?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Group') ?>  <span class='text-danger'>*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name='group'>
                            <option <?php if($user['group_user']== '1') echo"selected='selected'" ?>>1</option>
                            <option <?php if($user['group_user']== '2') echo"selected='selected'" ?>>2</option>
                            <option <?php if($user['group_user']== '3') echo"selected='selected'" ?>>3</option>
                            <option <?php if($user['group_user']== '4') echo"selected='selected'" ?>>4</option>
                            <option <?php if($user['group_user']== '5') echo"selected='selected'" ?>>5</option>
                            <option <?php if($user['group_user']== '6') echo"selected='selected'" ?>>6</option>
                            <option <?php if($user['group_user']== '7') echo"selected='selected'" ?>>7</option>
                            <option <?php if($user['group_user']== '8') echo"selected='selected'" ?>>8</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Address') ?></label>
                    <div class="col-md-8">
                        <input class="form-control" name="address" value='<?php echo $user['address'] ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Phone number') ?></label>
                    <div class="col-md-8">
                        <input class="form-control" name="phone" value='<?php echo $user['phone'] ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Position') ?></label>
                    <div class="col-md-8">
                        <input class="form-control" name="position" value='<?php echo $user['position'] ?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Birthday') ?></label>
                    <div class="col-md-8">
                        <div id="datetimepicker1" class="input-append date">
                            <input data-format="dd-MM-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='birthday' value='<?php echo $user['birthday'] ?>' readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Sex') ?></label>
                    <div class="col-md-8">
                        <input class="form-control" name="sex" value=' <?php echo $user['sex'] ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4"><?php echo Yii::t('app','Role') ?></label>
                    <div class="col-md-8">
                        <select class="form-control" name='role'>
                            <option <?php if($user['role']== 'user') echo"selected='selected'" ?>>user</option>
                            <option <?php if($user['role']== 'leader') echo"selected='selected'" ?>>leader</option>
                            <option <?php if($user['role']== 'director') echo"selected='selected'" ?>>director</option>
                            <option <?php if($user['role']== 'admin') echo"selected='selected'" ?>>admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-md-8">
                        <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-plus-square"></i>  <?php echo Yii::t('app','Update user') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#form').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                salary: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The salary is required and can\'t be empty') ?>"
                        },
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message: "<?php echo Yii::t('app','The salary can only consist of number, dot') ?>"
                        }
                    }
                },
                fullname: {
                    message: 'The fullname is not valid',
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The full name is required and can\'t be empty') ?>"
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: "<?php echo Yii::t('app','The full name must be more than 3 and less than 30 characters long') ?>"
                        }
                    }
                }
            }
        });
    });
</script>
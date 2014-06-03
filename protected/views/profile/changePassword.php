<?php
$this->pageTitle = 'Change password';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL.'/profile' ?>"><?php echo Yii::t('app','Profile') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Change password') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Change password') ?></h3>
</div>

<?php if(Yii::app()->admin->hasFlash('success')): ?>
    <div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>! </strong> <?php echo Yii::t('app','Change password successfully') ?>
    </div>
    <?php Yii::app()->admin->getFlash('success'); ?>
<?php elseif(Yii::app()->admin->hasFlash('error')): ?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Old password is wrong') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error'); ?>
<?php endif; ?>

<ul class="nav nav-tabs" style='margin-bottom: 20px'>
    <li><a href="http://<?php echo ROOT_URL ?>/profile"><?php echo Yii::t('app','Profile') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/profile/edit"><?php echo Yii::t('app','Edit profile') ?></a></li>
    <li class="active"><a href=''><?php echo Yii::t('app','Change password') ?></a></li>
</ul>

<div class="page animate-in" data-anim-type="bounce-in-up" data-anim-delay="500">
    <div class="maintain">
        <div  style="padding-left:5%; ">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="fa fa-lock text-primary"></i> </h4></div>
                <div class="panel-body">
                    <form role="form" style="width:40%" method='post' id="formpassword">
                        <div class="form-group">
                            <label class="control-label"><?php echo Yii::t('app','Current password') ?></label>
                            <input type="password" class="form-control" name="oldpass">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo Yii::t('app','New password') ?></label>
                            <input type="password" class="form-control" name="newpass">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo Yii::t('app','Retype new password') ?></label>
                            <input type="password" class="form-control" name="confirm">
                        </div>
                        <button type="submit" class="btn btn-primary" name="signin"><?php echo Yii::t('app','Save') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#formpassword').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                oldpass: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The password is required and can\'t be empty') ?>"
                        }
                    }
                },
                newpass: {
                    validators: {
                        notEmpty: {
                            message:  "<?php echo Yii::t('app','The password is required and can\'t be empty') ?>"
                        },
                        identical: {
                            field: 'confirm',
                            message: "<?php echo Yii::t('app','The password and its confirm are not the same') ?>"
                        },
                        stringLength: {
                            min: 3,
                            message: "<?php echo Yii::t('app','The password must be more than 3 long') ?>"
                        },
                        different: {
                            field: 'oldpass',
                            message: "<?php echo Yii::t('app','The new password can\'t be the same as old password') ?>"
                        }
                    }
                },
                confirm: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The password is required and can\'t be empty') ?>"
                        },
                        identical: {
                            field: 'newpass',
                            message: "<?php echo Yii::t('app','The password and its confirm are not the same') ?>"
                        },
                        stringLength: {
                            min: 3,
                            message: "<?php echo Yii::t('app','The password must be more than 3 long') ?>"
                        },
                        different: {
                            field: 'oldpass',
                            message: "<?php echo Yii::t('app','The new password can\'t be the same as old password') ?>"
                        }
                    }
                }
            }
        });
    })
</script>
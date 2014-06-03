<?php
$this->pageTitle = 'Edit profile';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL.'/profile' ?>"><?php echo Yii::t('app','Profile') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Edit') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Edit') ?></h3>
</div>
<?php if(Yii::app()->admin->hasFlash('error')): ?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Warning') ?>!</strong> <?php echo Yii::t('app','Username have been used') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error'); ?>
<?php elseif(Yii::app()->admin->hasFlash('success')): ?>
    <div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Account have been update successfully') ?>
    </div>
    <?php Yii::app()->admin->getFlash('success'); ?>
<?php endif; ?>

<ul class="nav nav-tabs" style='margin-bottom: 20px'>
    <li><a href="http://<?php echo ROOT_URL ?>/profile"><?php echo Yii::t('app','Profile') ?></a></li>
    <li class='active'><a href=""><?php echo Yii::t('app','Edit profile') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/profile/changePassword"><?php echo Yii::t('app','Change password') ?></a></li>
</ul>

<div class="page animate-in" data-anim-type="bounce-in-up" data-anim-delay="500">
    <div class="maintain">
        <div style="padding-left:5%; ">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="fa fa-wrench text-primary"></i></h4></div>
                <div class="panel-body">
                    <form role="form" method='post' class="form-horizontal" id='formProfile'>
                        <div class="row show-grid">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','User name') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-user"></i>
                                        <input class="form-control" name='username' value='<?php echo $user['username'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Full name') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-user"></i>
                                        <input class="form-control" name='fullname'  value='<?php echo $user['fullname'] ?>' readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Email') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-prepend fa fa-envelope-o"></i>
                                        <input type="email" class="form-control" name="email"  value='<?php echo $user['email'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Birthday') ?></label>
                                    <div class="col-sm-8">
                                            <i class="icon-append fa fa-calendar"></i>
                                            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" name='birthday' value='<?php echo $user['birthday'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-md-8">
                                        <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-plus-square"></i>  <?php echo Yii::t('app','Update') ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Address') ?></label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-building-o"></i>
                                        <input class="form-control" name="address" value='<?php echo $user['address'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Phone number') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-prepend fa fa-phone"></i>
                                        <input class="form-control" name="phone" value='<?php echo $user['phone'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Position') ?></label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-male"></i>
                                        <input class="form-control" name="position" value='<?php echo $user['position'] ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Sex') ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="sex">
                                            <?php if($user['sex'] == 'male'): ?>
                                                <option value='male'><?php echo Yii::t('app','Male') ?></option>
                                                <option value='famale'><?php echo Yii::t('app','Famale') ?></option>
                                            <?php else: ?>
                                                <option value='famale'><?php echo Yii::t('app','Famale') ?></option>
                                                <option value='male'><?php echo Yii::t('app','Male') ?></option>
                                           <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var date = new Date();
        $('#newDate1').datepicker({
            language: 'pt-BR',
            autoclose: true,
            endDate: date
        });
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formProfile').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                username: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 15,
                            message: 'The username must be more than 3 and less than 15 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'The username can only consist of alphabetical, number, dot and underscore'
                        }
                    }
                },
                fullname: {
                    message: 'The fullname is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'The username must be more than 3 and less than 30 characters long'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required and can\'t be empty'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },
                phone: {
                    message: 'The username is not valid',
                    validators: {
                        stringLength: {
                            max: 20,
                            message: 'The username must be less than 20 characters long'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'The username can only number'
                        }
                    }
                }
            }
        });
    });
</script>
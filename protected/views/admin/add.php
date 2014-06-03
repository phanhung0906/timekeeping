<?php
$this->pageTitle='Add admin';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/admin"><?php echo Yii::t('app','Admin') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Add new user') ?></b></li>
</ol>

<?php if(Yii::app()->admin->hasFlash('error1')): ?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Warning') ?>!</strong> <?php echo Yii::t('app','Username have not to like a key. Please register again') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error1'); ?>
<?php elseif(Yii::app()->admin->hasFlash('error2')): ?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Warning') ?>!</strong> <?php echo Yii::t('app','Username, email or ID have been used. Please register again') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error2'); ?>
<?php elseif(Yii::app()->admin->hasFlash('error3')): ?>
      <div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Username have been created successfully') ?>
      </div>
     <?php Yii::app()->admin->getFlash('error3'); ?>
<?php endif; ?>

<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Add user') ?></h3>
</div>
<div class="page animate-in" data-anim-type="flip-in-top-back" data-anim-delay="500">
    <div class="maintain">
        <div style="padding-left:5%; ">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><?php echo Yii::t('app','Form add user') ?></h4></div>
                <div class="panel-body">
                    <form role="form" method='post' class="form-horizontal" id='formAddUser'>
                        <div class="row show-grid">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','User name') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-user"></i>
                                        <input class="form-control" name='username' placeholder="<?php echo Yii::t('app','User name') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo Yii::t('app','Full name') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-user"></i>
                                        <input class="form-control" name='fullname' placeholder="<?php echo Yii::t('app','Full name') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Password') ?> <span class='text-danger'>*</span></label>
                                    <div class='col-sm-8'>
                                        <i class="icon-append fa fa-lock"></i>
                                        <input type="password" class="form-control" name="password" placeholder="<?php echo Yii::t('app','Password') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Confirm password') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-lock"></i>
                                        <input type="password" class="form-control" name="confirm" placeholder="<?php echo Yii::t('app','Password') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Email') ?>  <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-prepend fa fa-envelope-o"></i>
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo Yii::t('app','Email') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Basic salary') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-usd"></i>
                                        <input class="form-control" name="salary" placeholder="<?php echo Yii::t('app','Salary') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Group') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name='group'>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class='pull-right'>
                                        <button type="submit" class="btn btn-success" name="submit" style='margin-left: 10px'><span class="fa fa-plus-circle"></span> <?php echo Yii::t('app','Create new user') ?> </button>
                                        <a href='' class="btn btn-info" id='reset'> <?php echo Yii::t('app','Reset') ?> </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','ID number') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-flag"></i>
                                        <input class="form-control" name="id_number" placeholder="<?php echo Yii::t('app',"What's IP of user in timekeeping machine ?") ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Phone number') ?> <span class='text-danger'>*</span></label>
                                    <div class="col-sm-8">
                                        <i class="icon-prepend fa fa-phone"></i>
                                        <input class="form-control" name="phone" placeholder="<?php echo Yii::t('app',"Phone number") ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Birthday') ?></label>
                                    <div class="col-sm-8">
                                        <i class="icon-append fa fa-calendar"></i>
                                        <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" name='birthday' placeholder="<?php echo Yii::t('app','Birthday') ?>">
                                    </div>
                                    <small class="help-block col-sm-offset-4 col-sm-8"></small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Address') ?></label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-building-o"></i>
                                        <input class="form-control" name="address" placeholder="<?php echo Yii::t('app','Where is he/she from ?') ?>">
                                    </div>
                                    <small class="help-block col-sm-offset-4 col-sm-8"></small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Position') ?> </label>
                                    <div class="col-sm-8">
                                        <i class="fa fa-male"></i>
                                        <input class="form-control" name="position" placeholder="<?php echo Yii::t('app','What is his/her position in company ?') ?>">
                                    </div>
                                    <small class="help-block col-sm-offset-4 col-sm-8"></small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Sex') ?> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="sex">
                                            <option value="male"><?php echo Yii::t('app','Male') ?> </option>
                                            <option value="famale"><?php echo Yii::t('app','Famale') ?> </option>
                                        </select>
                                    </div>
                                    <small class="help-block col-sm-offset-4 col-sm-8"></small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo Yii::t('app','Role') ?> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name='role'>
                                            <option value="user">User</option>
                                            <option value="leader">Leader</option>
                                            <option value="director">Director</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <small class="help-block col-sm-offset-4 col-sm-8"></small>
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
            endDate: date,
            autoclose: true
        });
        $('#reset').click(function(){
            $('input').val('');
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formAddUser').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                username: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The username is required and can\'t be empty') ?>"
                        },
                        stringLength: {
                            min: 3,
                            max: 15,
                            message: "<?php echo Yii::t('app','The username must be more than 3 and less than 15 characters long') ?>"
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: "<?php echo Yii::t('app','The username can only consist of alphabetical, number, dot and underscore') ?>"
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
                            message:  "<?php echo Yii::t('app','The full name must be more than 3 and less than 30 characters long') ?>"
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message:  "<?php echo Yii::t('app','The password is required and can\'t be empty') ?>"
                        },
                        stringLength: {
                            min: 3,
                            message: "<?php echo Yii::t('app','The password must be more than 3 long') ?>"
                        }
                    }
                },
                confirm: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The password is required and can\'t be empty') ?>"
                        },
                        identical: {
                            field: 'password',
                            message: "<?php echo Yii::t('app','The password and its confirm are not the same') ?>"
                        },
                        stringLength: {
                            min: 3,
                            message: "<?php echo Yii::t('app','The password must be more than 3 long') ?>"
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The email address is required and can\'t be empty') ?>"
                        },
                        emailAddress: {
                            message: "<?php echo Yii::t('app','The input is not a valid email address') ?>"
                        }
                    }
                },
                salary: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The salary is required and can\'t be empty') ?>"
                        },
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message:  "<?php echo Yii::t('app','The salary can only consist of number, dot') ?>"
                        }
                    }
                },
                phone: {
                    validators: {
                        digits: {
                            message: "<?php echo Yii::t('app','The value can contain only digits') ?>"
                        }
                    }
                },
                id_number: {
                    validators: {
                        notEmpty: {
                            message: "<?php echo Yii::t('app','The ID in timekepping machine is required and can\'t be empty') ?>"
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: "<?php echo Yii::t('app','The ID in timekepping machine can only consist of number') ?>"
                        }
                    }
                }
            }
        });
    });
</script>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/jquery/jquery-2.0.3.min.js"></script>
        <!-- Bootstrap CSS framework -->
        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/css/bootstrapValidator.min.css" />

        <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/bootstrap/js/bootstrapValidator.min.js"></script>

        <!-- //Bootstrap CSS framework -->

        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/css/style.css" />
        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/font-awesome/css/font-awesome.min.css" />
        <!----Animation---->
        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL ?>/assets/vendor/animation/css/animations.min.css" />
        <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/animation/js/animations.min.js"></script>
        <script type="text/javascript" src="http://<?php echo ROOT_URL ?>/assets/vendor/animation/js/appear.min.js"></script>
        <!----//Animation---->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
    <?php Yii::app()->language= Yii::app()->session['language']; ?>
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" id='logo' href="http://<?php echo ROOT_URL ?>"><img src="http://<?php echo ROOT_URL.'/assets/vendor/picture/logo1.png' ?>" width='40px' > <?php echo CHtml::encode(Yii::app()->name); ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown" style='border-left: 1px solid #f1f1f1;'>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo Yii::t('app','Language'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu" style='width:200px;'>
                                <li><a href="#" class='lang' data-lang='en'> <?php echo Yii::t('app','English'); ?></a></li>
                                <li><a href="#" class='lang' data-lang='vi'> <?php echo Yii::t('app','Vietnamese'); ?></a></li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <?php if(Yii::app()->user->hasFlash('notify')): ?>
        <?php Yii::app()->user->getFlash('notify'); ?>
        <div class='alert alert-info' style='margin-top: 51px'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <strong><?php echo Yii::t('app','Reset password has been send to your email. PLease check your email'); ?></strong>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('emailfalse')): ?>
        <?php Yii::app()->user->getFlash('emailfalse'); ?>
        <div class='alert alert-danger' style='margin-top: 51px'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <strong><?php echo Yii::t('app',"Reset password hasn't been send to your email. PLease check send again"); ?></strong>
        </div>
    <?php endif; ?>

        <div class="col-md-4"></div>
        <div class="col-md-4" style="padding: 10% 4%;">

            <?php if(Yii::app()->admin->hasFlash('error')): ?>
                <div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <strong><?php echo Yii::t('app','Warning'); ?>!</strong> <?php echo Yii::t('app','Not found user'); ?>
                </div>
                <?php Yii::app()->admin->getFlash('error'); ?>
            <?php endif; ?>
            <div class="panel panel-default animate-in" data-anim-type="bounce-in-right-large" data-anim-delay="500">
                <div class="panel-heading">
                    <h4 class="text-center" style='padding:5px'> <a href="http://<?php echo ROOT_URL ?>" style="text-decoration: none;color:#5E5E5E" id='logo-text'>Timekeeping Solution</a></h4>
                </div>
                <form method='post' class="panel-body" id="formLogin">
                    <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input id='userInput' type="text" class="form-control" placeholder="<?php echo Yii::t('app','User'); ?>" name="user_name" style="height:40px;" <?php if(isset($user)) echo "value='".$user."'"; ?>>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" name="password" placeholder="<?php echo Yii::t('app','Password'); ?>" style="height:40px;" >
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="signin"> <?php echo Yii::t('app','Sign in'); ?></button>
                    </div>
                    <div class="form-group"><a href='' data-toggle="modal" data-target="#myModal"><?php echo Yii::t('app','Forgot Password?') ?></a></div>
                </form>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-primary" id="myModalLabel"><span class="fa fa-bolt"></span> <?php echo Yii::t('app','Recover password') ?></h4>
                        </div>
                        <form method='post' action="http://<?php echo ROOT_URL ?>/site/forgotpassword" id='recover'>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label text-info"><?php echo Yii::t('app','Email') ?></label>
                                    <input type="text" class="form-control recoverInput" name="email" style="height:40px;width:400px;" >
                                </div>
                                <div class="form-group">
                                    <label id="captchaOperation" class="control-label text-info"></label>
                                    <input type="text" class="form-control" name="captcha" style="height:40px;width:400px;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="signin" class="btn btn-primary recoverBtn"><?php echo Yii::t('app','Confirm') ?></button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.lang').click(function(){
                    $lang = $(this).data('lang');
                    $.ajax({
                        type:'post',
                        url:"http://<?php echo ROOT_URL ?>/site/language",
                        data:{
                            lang: $lang
                        }
                    }).done(function(response){
                            location.reload();
                        })
                });
                $('#userInput').focus();
                $('#formLogin').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        user_name: {
                            message: 'The username is not valid',
                            validators: {
                                notEmpty: {
                                    message: "<?php echo Yii::t('app','The username is required and can\'t be empty'); ?>"
                                },
                                stringLength: {
                                    min: 3,
                                    max: 15,
                                    message: "<?php echo Yii::t('app','The username must be more than 3 and less than 15 characters long'); ?>"
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\.]+$/,
                                    message: "<?php echo Yii::t('app','The username can only consist of alphabetical, number, dot and underscore'); ?>"
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "<?php echo Yii::t('app','The password is required and can\'t be empty'); ?>"
                                }
                            }
                        }
                    }
                });

                // Generate a simple captcha
                function randomNumber(min, max) {
                    return Math.floor(Math.random() * (max - min + 1) + min);
                };
                $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

                $('#recover').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
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
                        captcha: {
                            validators: {
                                callback: {
                                    message: 'Wrong answer',
                                    callback: function(value, validator) {
                                        var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                                        return value == sum;
                                    }
                                }
                            }
                        }
                    }
                });

            });
        </script>
    </body>
</html>
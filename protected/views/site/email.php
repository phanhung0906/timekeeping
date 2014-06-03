
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
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php Yii::app()->language= Yii::app()->session['language']; ?>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://<?php echo ROOT_URL ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
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

<div class="col-md-4"></div>
<div class="col-md-4">
    <h3 class="text-center" style="padding-top:40px;font-weight: bold;"> <a href="http://<?php echo ROOT_URL ?>" style="text-decoration: none">Timekeeping Solution</a></h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo Yii::t('app','Reset password'); ?>
        </div>
        <form method='post' id="resetPassword" class="panel-body" >
            <div class="form-group">
                <label class="control-label"><?php echo Yii::t('app','New password'); ?></label>
                <input type="password" class="form-control" name="newpass" style="height:40px;">
            </div>
            <div class="form-group">
                <label class="control-label"><?php echo Yii::t('app','Confirm password'); ?></label>
                <input type="password" class="form-control" name="confirm" style="height:40px;">
            </div>
            <div class="form-group">
                <label id="captchaOperation" class="control-label"></label>
                <input type="text" class="form-control" name="captcha" style="height:40px;">
            </div>
            <button type="submit" class="btn btn-primary" name="signin"><?php echo Yii::t('app','Save'); ?></button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
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

        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        };
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
        $('#resetPassword').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                newpass: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            message: 'The password must be more than 3 long'
                        },
                        identical: {
                            field: 'confirm',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
                confirm: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            message: 'The password must be more than 3 long'
                        },
                        identical: {
                            field: 'newpass',
                            message: 'The password and its confirm are not the same'
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
    })
</script>
</body>
</html>
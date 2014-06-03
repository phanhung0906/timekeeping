<?php
Yii::app()->language= Yii::app()->session['language'];
$this->pageTitle = 'Profile';
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Profile') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Profile') ?></h3>
</div>

<ul class="nav nav-tabs" style='margin-bottom: 20px'>
    <li class="active"><a href="#"><?php echo Yii::t('app','Profile') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/profile/edit"><?php echo Yii::t('app','Edit profile') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/profile/changePassword"><?php echo Yii::t('app','Change password') ?></a></li>
</ul>

<div class="page animate-in" data-anim-type="bounce-in-up"  data-anim-delay="500">
    <div class="maintain">
        <div style="padding-left:5%; ">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="fa fa-user text-primary"></i></h4></div>
                <div class="panel-body">
                    <table class='table table-hover table-striped'>
                        <tr>
                            <th><?php echo Yii::t('app','User name') ?></th>
                            <td><?php echo $user['username'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Full name') ?></th>
                            <td><?php echo $user['fullname'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Email') ?></th>
                            <td class='text-info'><?php echo $user['email'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Basic salary') ?></th>
                            <td><?php echo $user['basicSalary'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Group') ?></th>
                            <td><?php echo $user['group_user'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Hour remain') ?></th>
                            <td><?php echo $user['hour_allow'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Address') ?></th>
                            <td><?php echo $user['address'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Phone numer') ?></th>
                            <td><?php echo $user['phone'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Position') ?></th>
                            <td><?php echo $user['position'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Birthday') ?></th>
                            <td><?php echo $user['birthday'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Sex') ?></th>
                            <td><?php echo $user['sex'] ?></td>
                        </tr>
                        <tr>
                            <th><?php echo Yii::t('app','Role') ?></th>
                            <td>
                                <?php if($user['role'] =='admin'): ?>
                                    <span class='label label-success'> <?php echo $user['role'] ?></span>
                                <?php elseif($user['role'] =='leader'): ?>
                                    <span class='label label-warning'> <?php echo $user['role'] ?></span>
                                <?php elseif($user['role'] =='director'): ?>
                                    <span class='label label-info'> <?php echo $user['role'] ?></span>
                                <?php elseif($user['role'] =='user'): ?>
                                    <span class='label label-danger'> <?php echo $user['role'] ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
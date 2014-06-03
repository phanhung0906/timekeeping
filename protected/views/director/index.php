<?php
$this->pageTitle='Director Page';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','List User') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' class='animate-in' data-anim-type="bounce-in-left-large"> <?php echo Yii::t('app','All staff in Company') ?></h3>
</div>
<!--<form class="form-inline pull-right" style='padding-bottom: 10px' method="post" id='searchForm'>-->
<!--    <div class="form-group">-->
<!--        <input type="text" class="form-control" placeholder="--><?php //echo Yii::t('app','Search as username'); ?><!--" name="search">-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary" name="submit">--><?php //echo Yii::t('app','Submit'); ?><!--</button>-->
<!--</form>-->

<table class='table table-hover animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="500">
    <thread>
        <tr class='text-primary active'>
            <th><?php echo Yii::t('app','#') ?></th>
<!--            <th>--><?php //echo Yii::t('app','User name') ?><!--</th>-->
            <th><?php echo Yii::t('app','Full name') ?></th>
            <th><?php echo Yii::t('app','Email') ?></th>
            <th><?php echo Yii::t('app','Birth day') ?></th>
            <th><?php echo Yii::t('app','Phone number') ?></th>
            <th><?php echo Yii::t('app','Basic salary') ?></th>
            <th><?php echo Yii::t('app','Sex') ?></th>
            <th><?php echo Yii::t('app','Role') ?></th>
            <th><?php echo Yii::t('app','Address') ?></th>
        </tr>
    </thread>
    <tbody>
    <?php for($i = 0; $i < count($user); $i++): ?>
        <tr>
            <td><?php echo $i+1 ?></td>
<!--            <td class='username'>--><?php //echo $user[$i]['username'] ?><!--</td>-->
            <td><?php echo $user[$i]['fullname'] ?></td>
            <td class='text-info'><?php echo $user[$i]['email'] ?></td>
            <td><?php echo $user[$i]['birthday'] ?></td>
            <td><?php echo $user[$i]['phone'] ?></td>
            <td class='text-success'><?php echo $user[$i]['basicSalary'] ?> $</td>
            <td><?php echo $user[$i]['sex'] ?></td>
            <td>
                <?php if($user[$i]['role'] =='admin'): ?>
                    <span class='label label-success'> <?php echo $user[$i]['role'] ?></span>
                <?php elseif($user[$i]['role'] =='leader'): ?>
                    <span class='label label-warning'> <?php echo $user[$i]['role'] ?></span>
                <?php elseif($user[$i]['role'] =='director'): ?>
                    <span class='label label-info'> <?php echo $user[$i]['role'] ?></span>
                <?php elseif($user[$i]['role'] =='user'): ?>
                    <span class='label label-danger'> <?php echo $user[$i]['role'] ?></span>
                <?php endif; ?>
            </td>
            <td><?php echo $user[$i]['address'] ?></td>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>
<?php
$this->pageTitle='Leader Page';
Yii::app()->language= Yii::app()->session['language'];
$numUser =count($user);
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','List User') ?></b></li>
</ol>

<?php if($numUser != 0): ?>
<h1 class='text-center text-info'>Group <?php echo $user['0']['group_user'] ?></h1>
<?php endif; ?>
    <form class="form-inline pull-right" style='padding-bottom: 10px' method="post" id='searchForm'>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="<?php echo Yii::t('app','Search as username'); ?>" name="search">
        </div>
        <button type="submit" class="btn btn-primary" name="submit"><?php echo Yii::t('app','Submit'); ?></button>
    </form>

<table class='table table-hover'>
    <thread>
        <tr class='active text-primary'>
            <th><?php echo Yii::t('app','#') ?></th>
<!--            <th>--><?php //echo Yii::t('app','User name') ?><!--</th>-->
            <th><?php echo Yii::t('app','Full name') ?></th>
            <th><?php echo Yii::t('app','Email') ?></th>
            <th><?php echo Yii::t('app','Phone number') ?></th>
            <th><?php echo Yii::t('app','Address') ?></th>
            <th><?php echo Yii::t('app','Position') ?></th>
            <th><?php echo Yii::t('app','Sex') ?></th>
            <th><?php echo Yii::t('app','Role') ?></th>
        </tr>
    </thread>
    <tbody>
    <?php for($i = 0; $i < $numUser; $i++): ?>
        <tr>
            <td><?php echo $i+1 ?></td>
<!--            <td class='username'>--><?php //echo $user[$i]['username'] ?><!--</td>-->
            <td><?php echo $user[$i]['fullname'] ?></td>
            <td class='text-info'><?php echo $user[$i]['email'] ?></td>
            <td><?php echo $user[$i]['phone'] ?></td>
            <td><?php echo $user[$i]['address'] ?></td>
            <td><?php echo $user[$i]['position'] ?></td>
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
        </tr>
    <?php endfor; ?>
    </tbody>
</table>
<?php if($numUser == 0): ?>
    <h4 class='text-danger'><?php echo Yii::t('app','There is no result') ?><h4>
<?php endif; ?>
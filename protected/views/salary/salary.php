<?php
$this->pageTitle='Salary';
Yii::app()->language= Yii::app()->session['language'];
$date = getdate();
$ts     = mktime(0,0,0,$date['mon'],1,$date['year']);
$numDayOfMonth = date("t", $ts);
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <?php if($this->getSessionRole() == 'admin'): ?>
        <li><a href="http://<?php echo ROOT_URL ?>/salary"><?php echo Yii::t('app','Staff') ?></a></li>
    <?php endif; ?>
    <li class="active"><b><?php echo Yii::t('app','Salary') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Payslip') ?></h3>
</div>
<div class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="500">
    <h5 class='text-info'><?php echo Yii::t('app','Full name') ?>: <?php echo $user['fullname'] ?></h5>
    <h5 class='text-info'><?php echo Yii::t('app','Position') ?>: <?php echo $user['position'] ?></h5>
    <form class="form-inline pull-left" role="form" style='padding-bottom: 30px;' method="post" id='chooseDate'>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('app','Month') ?></label>
                   <select class="form-control" name='month'>
                       <?php for($j = 1; $j < 13; $j++): ?>
                           <option <?php if($j == $date['mon']) echo 'selected' ?>><?php if(strlen((string)$j) == 1){ echo '0'.$j; } else echo $j ?></option>
                       <?php endfor; ?>
                   </select>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('app','Year') ?></label>
            <select class="form-control" name='year'>
                <?php for($i = $date['year']; $i > $date['year']-3; $i--): ?>
                <option><?php echo $i ?></option>

                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-default"><?php echo Yii::t('app','Show') ?></button>
    </form>
    <form class="form-inline" role="form" style='padding-bottom: 30px;' method="post" >
        <button type='submit' name='download' class="btn btn-default btn-success" style='margin-left: 10px'><span class="fa fa-download"></span> <?php echo Yii::t('app','Down load') ?></button>
    </form>

    <?php if(isset($month) && isset($year)): ?>
        <h4 class='text-left'><?php echo Yii::t('app','Month').': '.$month.' - '.Yii::t('app','Year').': '.$year ?></h4>
    <?php endif; ?>

    <table class='table table-hover table-bordered'>
        <thread>
            <tr class='active text-primary'>
                <th class='text-center'><?php echo Yii::t('app','#') ?></th>
                <th class='text-center'><?php echo Yii::t('app','Content') ?></th>
                <th></th>
                <th><?php echo Yii::t('app','Note') ?></th>
            </tr>
        </thread>
        <tbody>
        <tr>
            <td class='text-center'>1</td>
            <td><?php echo Yii::t('app','Full working - day') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>2</td>
            <td><?php echo Yii::t('app','Working - day') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>3</td>
            <td><?php echo Yii::t('app','Leave of absence') ?></td>
            <td class='text-right'><?php echo $salary['leaveOfAbsence'] ?></td>
            <td><?php echo Yii::t('app','minutes') ?></td>
        </tr>
        <tr>
            <td class='text-center'>4</td>
            <td><?php echo Yii::t('app','Absent or late without leave') ?> </td>
            <td class='text-right'><?php echo $salary['late'] ?></td>
            <td><?php echo Yii::t('app','minutes') ?></td>
        </tr>
        <tr>
            <td class='text-center'>5</td>
            <td><?php echo Yii::t('app','Overtime') ?> </td>
            <td class='text-right'><?php echo $salary['overtime'] ?></td>
            <td><?php echo Yii::t('app','minutes') ?></td>
        </tr>
        <tr>
            <td class='text-center'>6</td>
            <td><?php echo Yii::t('app','Agreed salary') ?></td>
            <td class='text-right'><?php echo $user['basicSalary'] ?></td>
            <td>USD</td>
        </tr>
        <tr>
            <td class='text-center'>7</td>
            <td><?php echo Yii::t('app','USD Rate') ?></td>
            <td class='text-right'><?php echo USD ?></td>
            <td>VND</td>
        </tr>
        <tr>
            <td class='text-center'>8</td>
            <td><?php echo Yii::t('app','Total amount of time') ?></td>
            <td class='text-right'><?php echo $user['basicSalary'] * (int)USD ?>,000</td>
            <td>VND</td>
        </tr>
        <tr>
            <td class='text-center'>9</td>
            <td><?php echo Yii::t('app','Basic Salary') ?></td>
            <td class='text-right'></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>10</td>
            <td><?php echo Yii::t('app','Salary of Project') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>11</td>
            <td><?php echo Yii::t('app','Allowances') ?></td>
            <td class='text-right'><?php echo $salary['totalBonus'] ?>.000</td>
            <td>VND</td>
        </tr>
        <tr>
            <td class='text-center'>12</td>
            <td><?php echo Yii::t('app','Reward') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>13</td>
            <td><?php echo Yii::t('app','Work over time') ?></td>
            <td class='text-right'><?php echo $salary['salaryOver'] ?></td>
            <td>USD</td>
        </tr>
        <tr>
            <td class='text-center'>14</td>
            <td><?php echo Yii::t('app','Decrease salary') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>15</td>
            <td><?php echo Yii::t('app','Other deductions') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>16</td>
            <td><?php echo Yii::t('app','Receivable') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>17</td>
            <td><?php echo Yii::t('app','Insurance deduction(10.5% Basic salary)') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr>
            <td class='text-center'>18</td>
            <td><?php echo Yii::t('app','Tax deduction') ?></td>
            <td></td>
            <td>.....</td>
        </tr>
        <tr class='success'>
            <td class='text-center'>19</td>
            <td><?php echo Yii::t('app','Actual receive') ?></td>
            <td class='text-right'><?php echo round($salary['salary'] * (int)USD * (1 - $salary['late'] / ($numDayOfMonth * 8 * 60) ) + $salary['totalBonus']) ?>,000</td>
            <td>VND</td>
        </tr>
        </tbody>
    </table>
    <h4 class='text-right'> <?php echo $date['weekday'].', '.$date['mday'].'/'.$date['mon'].'/'.$date['year'] ?></h4>
</div>
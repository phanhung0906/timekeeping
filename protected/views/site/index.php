<?php
$this->pageTitle=CHtml::encode(Yii::app()->name);
Yii::app()->language= Yii::app()->session['language'];
$date = getdate();
$currentDay = $date['mday'];
if( strlen((string)$date['mday']) == 1) $currentDay = '0'.$date['mday'];
$currentMon = $date['mon'];
if( strlen((string)$date['mon']) == 1) $currentMon = '0'.$date['mon'];
$numUser = count($user);
$numArrayUser = count($arrayUser);
$time = $this->getSetting();
$timeIn    = (int)$time['hoursIn']*60 + (int)$time['minutesIn'];
$timeOut   = (int)$time['hoursOut']*60 + (int)$time['minutesOut'];
?>
<ol class="breadcrumb">
    <li class="active"><b><?php echo Yii::t('app','Dashboard') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Timekeeping') ?></h3>
</div>

<?php if(Yii::app()->user->hasFlash('error')):?>
<div class='alert alert-danger' id='error'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your max day choose is over 2 month in a year') ?>
</div>
    <?php Yii::app()->user->getFlash('error'); ?>
<?php endif; ?>
<form class="form-inline animate-in" role="form" method='post' style='padding-bottom: 30px;' data-anim-type="bounce-in-left-large" data-anim-delay="500">
    <span class='text-info'><?php echo Yii::t('app','Select date') ?></span>
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <i class="icon-append fa fa-calendar"></i>
            <input name='from'  data-date-format="dd-mm-yyyy" value="<?php echo $currentDay.'-'.$currentMon.'-'.$date['year'] ?>" class='form-control' style='width:80%;display:inline;margin-bottom: 5px' name='from' placeholder="From">
        </div>
    </div>
    <div class="form-group">
        <div id="datetimepicker2" class="input-append date">
            <i class="icon-append fa fa-calendar"></i>
            <input name='to'  data-date-format="dd-mm-yyyy" value="<?php echo $currentDay.'-'.$currentMon.'-'.$date['year'] ?>" class='form-control' style='width:80%;display:inline;margin-bottom: 5px' name='to' placeholder="To">
        </div>
    </div>
    <div class="form-group">
        <select class="form-control" name='user'>
            <option value='all'><?php echo Yii::t('app','All') ?></option>
            <?php for($i = 0; $i < $numUser; $i++): ?>
                <?php if( $user[$i]['username'] == 'admin') continue; ?>
                <option value="<?php echo $user[$i]['id_number'] ?>"><?php echo $user[$i]['fullname'] ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <button type='submit' class='btn btn-primary' id='search'><?php echo Yii::t('app','Search') ?></button>
</form>
<?php if($from != $to): ?>
    <h5 class='text-info animate-in'  data-anim-type="bounce-in-left-large" data-anim-delay="500"><?php echo Yii::t('app','From').' '. $from ?>  <?php echo Yii::t('app','To').' '.$to ?></h5>
<?php else: ?>
<h5 class='text-info animate-in'  data-anim-type="bounce-in-left-large" data-anim-delay="500"><?php echo Yii::t('app','Date').': '.$from ?></h5>
<?php endif; ?>
<?php for($i = 0; $i < $numArrayUser; $i++): ?>

<?php
    if(count($arrayUser[$i]) == 0){
        echo "<h4 class='text-danger animate-in' data-anim-type='bounce-in-left-large' data-anim-delay='500'>" .Yii::t('app','There is no result')."</h4>";
        break;
    }
      $arrayDate = explode('-',$arrayUser[$i][0]['date']);
      $month = $arrayDate[1];
      $year  = $arrayDate[0];
?>
<h2 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="1000"><?php echo Yii::t('app','Month') ?> : <?php echo $month.'/'.$year ?></h2>
<?php $num = count($arrayUser[$i]); ?>
<div style='overflow:scroll;height:600px;' class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="1000">
        <table class="table table-hover table-bordered" style='font-size: 12px;margin-top:10px;width:30%'>
            <thead>
            <tr class='active'>
                <th><?php echo Yii::t('app','Full name') ?></th>
                <th><?php echo Yii::t('app','Date') ?></th>
                <th><?php echo Yii::t('app','Time') ?></th>
            </tr>
            </thead>

            <tbody>
    <?php for($j = 0; $j < $num; $j++): ?>
        <?php $arraytemp1 = explode(':',$arrayUser[$i][$j]['time_in']);
              $time1 = (int)$arraytemp1[0]*60 + (int)$arraytemp1[1];
              $check1 = false; $check2 = false;
              if($time1 > $timeIn) $check1 = true;
            if($arrayUser[$i][$j]['time_in'] == $arrayUser[$i][$j]['time_out']){
                $arrayUser[$i][$j]['time_out'] = '...';
            } else {
                $arraytemp2 = explode(':',$arrayUser[$i][$j]['time_out']);
                $time2 = (int)$arraytemp2[0]*60 + (int)$arraytemp2[1];
                if($time2 < $timeOut) $check2 = true;
            }

        ?>
            <tr>
                <td><?php echo $arrayUser[$i][$j]['fullname'] ?></td>
                <td><?php echo $this->monday($arrayUser[$i][$j]['date']) ?></td>
                <td class='text-center'><?php if($check1) { echo "<b class='text-danger'>".$arrayUser[$i][$j]['time_in']." </b>";}else echo "<b>".$arrayUser[$i][$j]['time_in']." </b>" ?> <hr style='margin: 4px'>
                    <?php if($check2) { echo "<b class='text-success'>".$arrayUser[$i][$j]['time_out']." </b>";}else echo "<b>".$arrayUser[$i][$j]['time_out']." </b>" ?>
                </td>
            </tr>
    <?php endfor; ?>
            </tbody>
        </table>
</div>
<?php endfor; ?>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });
        $('#datetimepicker2 input').datepicker({
            language: 'pt-BR',
            autoclose: true
        });
    })
</script>

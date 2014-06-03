<?php
$this->pageTitle = 'Time keeping';
Yii::app()->language= Yii::app()->session['language'];
$time3 = $this->getSetting();
$timeIn    = (int)$time3['hoursIn']*60 + (int)$time3['minutesIn'];
$timeOut   = (int)$time3['hoursOut']*60 + (int)$time3['minutesOut'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Timekeeping') ?></b></li>
</ol>
<?php if(Yii::app()->admin->hasFlash('error')):?>
    <div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app','Your max day choose is over 2 month in a year') ?>
    </div>
    <?php Yii::app()->admin->getFlash('error'); ?>
<?php endif; ?>

<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Timekeeping table') ?></h3>
</div>

<!--<form class="form-inline pull-right" role="search" method="post" id='searchForm' style='display: none;margin-bottom: 10px'>-->
<!--    <div class="form-group">-->
<!--        <input type="text" class="form-control" placeholder="--><?php //echo Yii::t('app','Search as username'); ?><!--" name="search">-->
<!--        <i class="fa fa-search" id='searchIcon'></i>-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary" name="submit">--><?php //echo Yii::t('app','Submit'); ?><!--</button>-->
<!--</form>-->
<form class="form-inline animate-in" role="form" style='padding-bottom: 30px' method="post" id='chooseDate' data-anim-type="bounce-in-right-large" data-anim-delay="500">
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <i class="icon-append fa fa-calendar"></i>
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='from' placeholder="<?php echo Yii::t('app','From') ?>">
        </div>
    </div>
    <div class="form-group">
        <div id="datetimepicker2" class="input-append date">
            <i class="icon-append fa fa-calendar"></i>
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate2" style='width:80%;display:inline;margin-bottom: 5px' name='to' placeholder="<?php echo Yii::t('app','To') ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-default" style='margin-bottom: 5px'><?php echo Yii::t('app','Show') ?></button>
</form>

<?php if(isset($from) && isset($to)): ?>
    <?php if($from != $to): ?>
        <h5 class='text-info animate-in' data-anim-type="bounce-in-right-large" data-anim-delay="500"><?php echo Yii::t('app','From').' '. $from ?>  <?php echo Yii::t('app','To').' '.$to ?></h5>
    <?php else: ?>
        <h5 class='text-info animate-in' data-anim-type="bounce-in-right-large" data-anim-delay="500"><?php echo Yii::t('app','Date').': '.$from ?></h5>
    <?php endif; ?>
<?php endif; ?>

<div class="panel panel-default animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="500">
    <div class="panel-heading" style='padding: 15px'><strong class='text-primary'><i class="fa fa-user fa-lg fa-fw"></i> <?php echo Yii::t('app','List User') ?></strong></div>
    <div id='timekeepingDiv'>
        <table class="table table-hover" id="timekeeping">
            <thead class='text-primary'>
                <tr>
                    <th><?php echo Yii::t('app','Position') ?></th>
                    <th style='padding-right: 30px'><?php echo Yii::t('app','ID number') ?></th>
                    <th><?php echo Yii::t('app','Full name') ?></th>
                    <th><?php echo Yii::t('app','Date') ?></th>
                    <th><?php echo Yii::t('app','Day') ?></th>
                    <th><?php echo Yii::t('app','In') ?></th>
                    <th><?php echo Yii::t('app','Out') ?></th>
                    <th class="sortable" style='background: #fff'><?php echo Yii::t('app','Late (minutes)') ?></th>
                    <th class="sortable" style='background: #fff'><?php echo Yii::t('app','Early (minutes)') ?></th>
                    <th><?php echo Yii::t('app','Total hours') ?></th>
                    <th><?php echo Yii::t('app','Percent a day') ?></th>
                    <th class="sortable" style='background: #fff'><?php echo Yii::t('app','Overtime (hours)') ?></th>
                    <th class="sortable" style='background: #fff'><?php echo Yii::t('app','Total time') ?></th>
                </tr>
            </thead>

            <tbody>
                <?php for($i = 0; $i < count($user); $i++): ?>
                    <?php
                    $arraytemp1 = explode(':',$user[$i]['time_in']);
                    $time1 = (int)$arraytemp1[0]*60 + (int)$arraytemp1[1];
                    $check1 = false;
                    if($time1 > $timeIn) $check1 = true;

                    if($user[$i]['time_in'] == $user[$i]['time_out']){
                        $user[$i]['time_out'] = '...';
                        $check2 = false;
                    } else {
                        $arraytemp2 = explode(':',$user[$i]['time_out']);
                        $time2 = (int)$arraytemp2[0]*60 + (int)$arraytemp2[1];
                        $check2 = false;
                        if($time2 < $timeOut) $check2 = true;
                    }
                    ?>
                    <tr>
                        <td><?php echo $user[$i]['position'] ?></td>
                        <td><?php echo $user[$i]['id_number'] ?></td>
                        <td><a href="http://<?php echo ROOT_URL ?>/timekeeping/admin/user/<?php echo $user[$i]['username'] ?>"><?php echo $user[$i]['fullname'] ?></a></td>
                        <td><?php echo str_replace('-', '/', $this->convertDate($user[$i]['date'])) ?></td>
                        <td><?php echo $user[$i]['day'] ?></td>
                        <td class='text-center'><?php if($check1) { echo "<span class='text-danger'>".$user[$i]['time_in']." </span>";}else echo "<span>".$user[$i]['time_in']." </span>" ?> </td>
                        <td class='text-center'><?php if($check2) { echo "<span class='text-success'>".$user[$i]['time_out']." </span>";}else echo "<span>".$user[$i]['time_out']." </span>" ?></td>
                        <td class='text-center'><?php echo $time[$i]['timeLate'] ?></td>
                        <td class='text-center'><?php echo $time[$i]['timeEarly'] ?></td>
                        <td class='text-center'><?php echo $time[$i]['totalTime'] ?></td>
                        <td class='text-center'><?php echo $time[$i]['percentOfDay'] ?></td>
                        <td class='text-center'><?php echo round($user[$i]['hour']/60,2) ?></td>
                        <td class='text-center'>
                            <?php if($time[$i]['total'] >= 8): ?>
                                <strong class='text-primary'><?php echo $time[$i]['total'] ?></strong>
                            <?php else: ?>
                               <strong class='text-warning'><?php echo $time[$i]['total'] ?></strong>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>

            <tfoot>

            <tr>
                <th colspan="13" class="ts-pager form-horizontal">
                    <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
                    <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                    <button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
                    <button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
                    <select class="pagesize input-mini form-control" title="Select page size" style='width:100px;display: inline'>
                        <option selected="selected" value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="9999"><?php echo Yii::t('app','All') ?></option>
                    </select>
                    <select class="pagenum input-mini form-control" title="Select page number" style='width:70px;display: inline'></select>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php if(count($user) == 0): ?>
    <h5>There is no Result</h5>
<?php endif; ?>
<script type="text/javascript">
    $(function() {
        $('#searchForm').show();
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

<script>
    $(document).ready(function(){
        $.extend($.tablesorter.themes.bootstrap, {
            // these classes are added to the table. To see other table classes available,
            // look here: http://twitter.github.com/bootstrap/base-css.html#tables
            table      : 'table',
            caption    : 'caption',
            header     : 'bootstrap-header', // give the header a gradient background
            footerRow  : '',
            footerCells: '',
            icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
            sortNone   : 'bootstrap-icon-unsorted',
            sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
            sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
            active     : '', // applied when column is sorted
            hover      : '', // use custom css here - bootstrap class may not override it
            filterRow  : '', // filter row class
            even       : '', // odd row zebra striping
            odd        : ''  // even row zebra striping
        });

        // call the tablesorter plugin and apply the uitheme widget
        $("#timekeeping").tablesorter({
            selectorHeaders: 'thead th.sortable',
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme : "bootstrap",

            widthFixed: true,

            headerTemplate : '{content}{icon}', // new in v2.7. Needed to add the bootstrap icon!

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets : [ "uitheme","filter", "zebra" ],

            widgetOptions : {
                // using the default zebra striping class name, so it actually isn't included in the theme variable above
                // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                zebra : ["even", "odd"],

                // reset filters button
                filter_reset : ".reset"

                // set the uitheme widget to use the bootstrap theme class names
                // this is no longer required, if theme is set
                // ,uitheme : "bootstrap"

            }
        })
            .tablesorterPager({

                // target the pager markup - see the HTML block below
                container: $(".ts-pager"),

                // target the pager page select dropdown - choose a page
                cssGoto  : ".pagenum",

                // remove rows from the table to speed up the sort of large tables.
                // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                removeRows: false,

                // output string - default is '{page}/{totalPages}';
                // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

            });

        $('#timekeeping').find('thead').find('.sortable').css('font-size','12px');
        $('#timekeeping').find('input').addClass('form-control');
    });
</script>
<?php
$this->pageTitle = 'Chart';
Yii::app()->language= Yii::app()->session['language'];
$date   = getdate();
$ts     = mktime(0,0,0,$date['mon'],1,$date['year']);
$numDayOfMonth = date("t", $ts);
$numUser = count($statistic);
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Chart') ?></b></li>
</ol>

<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large"><?php echo Yii::t('app','Chart') ?></h3>
</div>

<ul class="nav nav-tabs">
    <li><a href="http://<?php echo ROOT_URL ?>/chart/month"><?php echo Yii::t('app','Month') ?></a></li>
    <li class="active"><a href="#"><?php echo Yii::t('app','Year') ?></a></li>
</ul>

<form class="form-inline animate-in" role="form" style='padding: 30px 0;' method='post' id='year' data-anim-type="bounce-in-right-large" data-anim-delay="500">
    <div class="form-group">
        <label class="control-label"><?php echo Yii::t('app','Year') ?></label>
        <select class="form-control" name='year'>
            <?php for($i = $date['year']; $i > $date['year']-3;$i--): ?>
                <option><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <button class="btn btn-default" id='submitYear'><?php echo Yii::t('app','Show') ?></button>
</form>
<div id='chartYear' style='display: none'>
    <?php if(isset($year)): ?>
        <h4 class='text-left text-primary animate-in' data-anim-type="bounce-in-right-large" data-anim-delay="500"><?php echo Yii::t('app','Year').': '.$year ?></h4>
    <?php endif; ?>
    <div class="panel panel-success animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="0">
        <div class="panel-heading text-center"><h4><?php echo Yii::t('app','Number of time late, early, overtime per year') ?></h4></div>
        <div class="panel-body">
            <table class="highchart" data-graph-container-before="1" data-graph-type="line" data-graph-xaxis-end-on-tick="1" data-graph-height="300" style='display: none'>
                <thead>
                <tr>
                    <th><?php echo Yii::t('app','Date') ?></th>
                    <th><?php echo Yii::t('app','Late') ?></th>
                    <th><?php echo Yii::t('app','Early') ?></th>
                    <th><?php echo Yii::t('app','Overtime') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php for($i = 0; $i < count($chart); $i++): ?>
                    <tr>
                        <td><?php echo ($i+1) ?></td>
                        <td><?php echo $chart[$i]['numLate'] ?></td>
                        <td><?php echo $chart[$i]['numEarly'] ?></td>
                        <td><?php echo $chart[$i]['numOvertime'] ?></td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-warning animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="0">
        <div class="panel-heading text-center"><h4><?php echo Yii::t('app','Hour late, early, overtime per year') ?></h4></div>
        <div class="panel-body">
            <table class="highchart" data-graph-container-before="1" data-graph-type="column" data-graph-height="300" style='display: none'>
                <thead>
                <tr>
                    <th><?php echo Yii::t('app','Date') ?></th>
                    <th><?php echo Yii::t('app','Late') ?></th>
                    <th><?php echo Yii::t('app','Early') ?></th>
                    <th><?php echo Yii::t('app','Overtime') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php   $totalOT = 0;
                $totalLate = 0;
                $totalEarly = 0;
                ?>
                <?php for($i = 0; $i < count($chart); $i++): ?>
                    <tr>
                        <td><?php echo ($i+1) ?></td>
                        <td><?php echo round((int)$chart[$i]['totalTimeLate']/60,2) ?></td>
                        <td><?php echo round((int)$chart[$i]['totalTimeEarly']/60,2) ?></td>
                        <td><?php echo round((int)$chart[$i]['totalTimeOver']/60,2) ?></td>
                    </tr>
                    <?php  $totalOT += (int)$chart[$i]['totalTimeOver'];
                    $totalLate += (int)$chart[$i]['totalTimeLate'];
                    $totalEarly += (int)$chart[$i]['totalTimeEarly'];
                    ?>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row show-grid animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="0">
        <div class="col-md-6">
            <div class="panel panel-primary ">
                <div class="panel-heading text-center"><h4><?php echo Yii::t('app','Result') ?></h4></div>
                <div class="panel-body">
                    <table class="highchart table" data-graph-container-before="1" data-graph-type="pie" data-graph-height="300" data-graph-datalabels-enabled="1">
                        <thead>
                        <tr>
                            <th><?php echo Yii::t('app','total') ?></th>
                            <th><?php echo Yii::t('app','hours') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('app','Total hour late') ?></td>
                            <td data-graph-name="<?php echo Yii::t('app','Total hour late') ?>" data-graph-item-highlight="1"><label class="label label-primary"><?php echo round($totalLate/60,2); ?></label></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('app','Total hour early') ?></td>
                            <td data-graph-name="<?php echo Yii::t('app','Total hour early') ?>"><label class="label label-danger"><?php echo round($totalEarly/60,2); ?></label></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('app','Total hour overtime') ?></td>
                            <td data-graph-name="<?php echo Yii::t('app','Total hour overtime') ?>"><label class="label label-success"><?php echo round($totalOT/60,2); ?></label></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="0">
        <div class="panel-heading" style='padding: 15px'><strong class='text-primary'><i class="fa fa-user fa-lg fa-fw"></i> <?php echo Yii::t('app','Manager table') ?></strong></div>
        <table class='table' id='chartTable'>
            <thead>
            <tr>
                <th><?php echo Yii::t('app','Full name') ?></th>
                <th class='sortable' style='background: #fff'><?php echo Yii::t('app','Number of late') ?></th>
                <th class='sortable' style='background: #fff'><?php echo Yii::t('app','Number of early') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < $numUser; $i++): ?>
                <tr>
                    <td><?php echo $statistic[$i]['fullname'] ?></td>
                    <td>
                        <?php if ($statistic[$i]['countLate'] >= 48) {
                            echo "<span class='label label-danger'>".$statistic[$i]['countLate']."</span>";
                        } else if ($statistic[$i]['countLate'] < 48 && $statistic[$i]['countLate'] > 12) {
                            echo "<span class='label label-warning'>". $statistic[$i]['countLate']."</span>";
                        } else {
                            echo "<span class='label label-info'>".$statistic[$i]['countLate']."</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($statistic[$i]['countEarly'] >= 48) {
                            echo "<span class='label label-danger'>".$statistic[$i]['countEarly']."</span>";
                        } else if ($statistic[$i]['countLate'] < 48 && $statistic[$i]['countEarly'] > 12) {
                            echo "<span class='label label-warning'>". $statistic[$i]['countEarly']."</span>";
                        } else {
                            echo "<span class='label label-info'>".$statistic[$i]['countEarly']."</span>";
                        }
                        ?>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6" class="ts-pager form-horizontal">
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
<script type='text/javascript'>
    $(document).ready(function() {
        $('#chartYear').fadeIn(800);
        $('table.highchart').highchartTable();
        $('.highcharts-container').css({'margin' : '50px 0'});

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
        $("#chartTable").tablesorter({
            selectorHeaders: 'thead th.sortable',
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme : "bootstrap",

            widthFixed: true,

            headerTemplate : '{content}{icon}', // new in v2.7. Needed to add the bootstrap icon!

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets : [ "uitheme","filter", "zebra"  ],

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

        $('#chartTable').find('thead').find('.sortable').css('font-size','14px');
        $('#chartTable').find('input').addClass('form-control');
    });
</script>
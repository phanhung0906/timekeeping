<?php
$this->pageTitle = CHtml::encode(Yii::app()->name);
Yii::app()->language= Yii::app()->session['language'];
$numUser = count($user);
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

<ul class="nav nav-tabs">
    <li class="active"><a href="#"><?php echo Yii::t('app','You') ?></a></li>
    <li>
        <a href="http://<?php echo ROOT_URL ?>/timekeeping/<?php echo Yii::app()->session['role'] ?>/staff">
            <?php if(Yii::app()->session['role'] == 'leader'): ?>
                <?php echo Yii::t('app','Group') ?>
            <?php endif; ?>
            <?php if(Yii::app()->session['role'] == 'director'): ?>
                <?php echo Yii::t('app','Company') ?>
            <?php endif; ?>
        </a>
    </li>
</ul>

<form class="form-inline animate-in" data-anim-type="bounce-in-right-large" data-anim-delay="500" role="form" style='padding: 20px 0' method="post" id='chooseDate'>
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='from' placeholder="<?php echo Yii::t('app','From') ?>" >
            <i class="icon-append fa fa-calendar"></i>
        </div>
    </div>
    <div class="form-group">
        <div id="datetimepicker2" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate2" style='width:80%;display:inline;margin-bottom: 5px' name='to' placeholder="<?php echo Yii::t('app','To') ?>" >
            <i class="icon-append fa fa-calendar"></i>
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

<?php if($numUser != 0): ?>
    <div class='text-center text-info animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="500" id="userInfo" style='padding-bottom:20px'><strong><?php echo Yii::t('app','ID') ?>:</strong> <?php echo $user[0]['id_number'] ?> <strong><?php echo Yii::t('app','Full name') ?>:</strong> <?php echo $user[0]['fullname'] ?> <strong><?php echo Yii::t('app','Position') ?>:</strong> <?php echo $user[0]['position'] ?></div>

    <table class="table table-hover table-bordered animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="500">
        <tr class='success'>
            <th><?php echo Yii::t('app','Weekdays') ?></th>
            <td>...</td>
            <td>...</td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Some time later') ?></th>
            <td><?php echo $num['numLate'] ?></td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Some minutes later') ?></th>
            <td><?php echo $num['minuteLate'] ?></td>
            <td style="padding-left: 50px;"></td>
        </tr>
        <tr class='success'>
            <th><?php echo Yii::t('app','Sunday') ?></th>
            <td>...</td>
            <td>...</td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Some time soon') ?></th>
            <td><?php echo $num['numEarly'] ?></td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Some minutes soon') ?></th>
            <td><?php echo $num['minuteEarly'] ?></td>
            <td style="padding-left: 50px;"></td>
        </tr>
        <tr class='success'>
            <th><?php echo Yii::t('app','Vacation') ?></th>
            <td>...</td>
            <td>...</td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Unexcused absences') ?></th>
            <td>...</td>
            <td style="padding-left: 50px;"></td>
            <th><?php echo Yii::t('app','Excused absences') ?></th>
            <td><?php echo $num['excused'] ?></td>
            <td style="padding-left: 50px;"></td>
        </tr>
    </table>
    <table class="table table-hover table-bordered animate-in" data-anim-type="bounce-in-left-large" data-anim-delay="500" id='timekeepingUser'>
            <thead class='text-primary'>
                <tr class='active'>
                    <th><?php echo Yii::t('app','Date') ?></th>
                    <th><?php echo Yii::t('app','Day') ?></th>
                    <th><?php echo Yii::t('app','In') ?></th>
                    <th><?php echo Yii::t('app','Out') ?></th>
                    <th class='sortable'><?php echo Yii::t('app','Late (minutes)') ?></th>
                    <th class='sortable'><?php echo Yii::t('app','Early (minutes)') ?></th>
                    <th><?php echo Yii::t('app','Total hours') ?></th>
                    <th><?php echo Yii::t('app','Percent a day') ?></th>
                    <th><?php echo Yii::t('app','Overtime') ?></th>
                    <th class='sortable'><?php echo Yii::t('app','Total time') ?></th>
                </tr>
            </thead>

            <tbody>
                <?php for($i = 0; $i < $numUser; $i++): ?>
                    <tr>
                        <td><?php echo str_replace('-', '/', $this->convertDate($user[$i]['date'])) ?></td>
                        <td><?php echo $user[$i]['day'] ?></td>
                        <td><?php echo $user[$i]['time_in'] ?></td>
                        <td><?php echo $user[$i]['time_out'] ?></td>
                        <td><?php echo $time[$i]['timeLate'] ?></td>
                        <td><?php echo $time[$i]['timeEarly'] ?></td>
                        <td><?php echo $time[$i]['totalTime'] ?></td>
                        <td><?php echo $time[$i]['percentOfDay'] ?></td>
                        <td><?php echo $user[$i]['hour'] ?></td>
                        <td>
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
<?php else: ?>
    <h5><?php echo Yii::t('app','There is no Result') ?></h5>
<?php endif; ?>
<div style='margin: 40px 200px;'>
    <hr />
</div>

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

<script>
    $(document).ready(function(){
        $.extend($.tablesorter.themes.bootstrap, {
            // these classes are added to the table. To see other table classes available,
            // look here: http://twitter.github.com/bootstrap/base-css.html#tables
            table      : 'table table-bordered',
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
        $("#tableStaff").tablesorter({
            selectorHeaders: 'thead th.sortable',
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme : "bootstrap",

            widthFixed: true,

            headerTemplate : '{content}{icon}', // new in v2.7. Needed to add the bootstrap icon!

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets : [ "uitheme" ],

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

        $("#timekeepingUser").tablesorter({
            selectorHeaders: 'thead th.sortable',
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme : "bootstrap",

            widthFixed: true,

            headerTemplate : '{content}{icon}', // new in v2.7. Needed to add the bootstrap icon!

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets : [ "uitheme" ],

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
        $('#timekeepingUser').find('thead').find('.sortable').css('font-size','12px');
    });
</script>
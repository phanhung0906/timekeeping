<?php
$this->pageTitle='Day off';
Yii::app()->language= Yii::app()->session['language'];
$numUser = count($user);
?>

<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/dayoff/list/ur/<?php echo Yii::app()->session['role'] ?>"><?php echo Yii::t('app','List User') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','List day off') ?></b></li>
</ol>
<div class="page-header">
    <h3 class='animate-in' data-anim-type="bounce-in-left-large" data-anim-delay="0"><?php echo Yii::t('app','Day off table') ?></h3>
</div>
<div class='alert alert-success animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500" style='display: none'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Delete day off successfully') ?>
</div>
<div class='alert alert-danger animate-in' data-anim-type="flip-in-top-front" data-anim-delay="500" style='display: none'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app',"Account's day off haven't been delete") ?>
</div>
<!--<form class="form-inline" role="search" method="post" id='searchForm' style='display: none;margin-bottom: 10px'>-->
<!--    <div class="form-group">-->
<!--        <input type="text" class="form-control" placeholder="--><?php //echo Yii::t('app','Search as username'); ?><!--" name="search">-->
<!--        <i class="fa fa-search" id='searchIcon'></i>-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary" name="submit">--><?php //echo Yii::t('app','Submit'); ?><!--</button>-->
<!--</form>-->
<form class="form-inline animate-in" role="form" style='padding-bottom: 30px' method="post" id='chooseDate' data-anim-type="bounce-in-right-large" data-anim-delay="500">
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='from' placeholder="<?php echo Yii::t('app','From') ?>" >
        </div>
    </div>
    <div class="form-group">
        <div id="datetimepicker2" class="input-append date">
            <input data-date-format="dd-mm-yyyy" type="text" class='form-control' id="newDate2" style='width:80%;display:inline;margin-bottom: 5px' name='to' placeholder="<?php echo Yii::t('app','To') ?>" >
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
    <div class="panel-heading" style='padding: 15px'><strong class='text-primary'><i class="fa fa-user fa-lg fa-fw"></i> <?php echo Yii::t('app','Manager table') ?></strong></div>
    <div style=' overflow-x: scroll; overflow-y: hidden;'>
        <table class='table table-hover' id='dayoff' style='min-width: 1200px; font-size: 12px;'>
            <thead class='text-primary'>
                <tr>
                    <th><?php echo Yii::t('app','#') ?></th>
                    <th><?php echo Yii::t('app','Full name') ?></th>
                    <th><?php echo Yii::t('app','Email') ?></th>
                    <th class='sortable' style='background: #fff'><?php echo Yii::t('app','Group') ?></th>
                    <th><?php echo Yii::t('app','Role') ?></th>
                    <th><?php echo Yii::t('app','Date off') ?></th>
                    <th><?php echo Yii::t('app','Day') ?></th>
                    <th class='sortable' style='background: #fff'><?php echo Yii::t('app','Hour off') ?></th>
                    <th><?php echo Yii::t('app','Hour remain') ?></th>
                    <th><?php echo Yii::t('app','By') ?></th>
                    <th><?php echo Yii::t('app','Reason') ?></th>
                    <th><?php echo Yii::t('app','Action') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php for($i = 0; $i < $numUser; $i++): ?>
                <tr>
                    <td><?php echo $i+1 ?></td>
                    <td class='username'><?php echo $user[$i]['fullname'] ?></td>
                    <td class='text-info'><?php echo $user[$i]['email'] ?></td>
                    <td><?php echo $user[$i]['group_user'] ?></td>
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
                    <td><?php echo str_replace('-', '/', $this->convertDate($user[$i]['dateOff'])) ?></td>
                    <td><?php echo $user[$i]['dayOff'] ?></td>
<!--                    <td>--><?php //echo round((int)$user[$i]['hour_off']/60,2) ?><!--</td>-->
                    <td><?php echo $user[$i]['fromOff'].' - '.$user[$i]['toOff'] ?></td>
                    <td><?php echo round((int)$user[$i]['hour_allow']/60,2) ?></td>
                    <td>
                        <span class='label label-default'> <?php echo $user[$i]['by'] ?></span>
                    </td>
                    <td class='text-info'><?php echo $user[$i]['reason'] ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="http://<?php echo ROOT_URL ?>/dayoff/<?php echo Yii::app()->session['role'] ?>/id/<?php echo $user[$i]['user_id'] ?>" class='btn btn-success' data-toggle="tooltip" title="<?php echo Yii::t('app','Register day off') ?>"><i class="fa fa-wheelchair"></i></a>
                            <button class='btn btn-danger deleteUser' data-id='<?php echo $user[$i]['id'] ?>' data-toggle="modal" data-target="#modalDeleteUser" data-toggle="tooltip" title="<?php echo Yii::t('app','Delete') ?>"><i class="fa fa-trash-o"></i></button>
                        </div>
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
<!-- Delete user -->
<!-- Modal -->
<div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-trash-o"></span> <?php echo Yii::t('app','Delete day off') ?></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer confirm">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /Delete user -->

<div class="confirm1 hide">
    <button type="button" class="btn btn-danger delete" data-dismiss="modal" data-id="#id#"><?php echo Yii::t('app','Delete') ?></button>
    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('app','Close') ?></button>
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

<script type='text/javascript'>
    $(document).ready(function(){
        $('a').tooltip();
        $('button').tooltip();
        $('.deleteUser').click(function(){
            $self    = $(this);
            $user_id = $self.data('id');
            $name    = $self.parents('tr').find('.username').html();
            $('#modalDeleteUser').find('.modal-body').html('').append('<p><?php echo Yii::t('app','Are you sure want to delete') ?> <b>' + $name +'</b></p>');
            var template = $('.confirm1').html().replace(/#id#/g,$user_id);
            $('#modalDeleteUser').find('.confirm').html('');
            $(template).appendTo('.confirm');

            $('.delete').click(function() {
                $('body').waitMe({
                    effect: 'win8_linear',
                    text: 'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color:'#000'
                });
                $('body').find('.waitMe_text').css('font-size','20px');
                $self1 = $(this);
                $id    = $self1.data("id");
                $.ajax({
                    type: 'post',
                    url : "http://<?php echo ROOT_URL ?>/dayoff/deleteOff",
                    data: {
                        id : $id
                    }
                }).done(function(response){
                        $('body').waitMe('hide');
                        if(response !=0 ){
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $self.parents('tr').hide();
                        } else {
                            $('.alert-success').hide();
                            $('.alert-danger').show();
                        }
                    })
            })
        })
        $('#dayoff').find('input').addClass('form-control');
    });
</script>
<script type='text/javascript'>
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
    $("#dayoff").tablesorter({
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
</script>
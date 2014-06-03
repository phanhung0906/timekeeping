<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Property') ?></b></li>
</ol>
<div class="page-header">
    <h3><?php echo Yii::t('app','Property Manager') ?></h3>
</div>
<div class='alert alert-success' style='display: none'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong><?php echo Yii::t('app','Success') ?>!</strong> <?php echo Yii::t('app','Property have been remove') ?>
</div>
<div class='alert alert-danger' style='display: none'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong><?php echo Yii::t('app','Error') ?>!</strong> <?php echo Yii::t('app',"Property haven't been remove") ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading" style='padding: 15px'><strong class='text-primary'><i class="fa fa-desktop fa-lg fa-fw"></i> <?php echo Yii::t('app','Property Manager') ?></strong></div>
    <table class='table table-hover' id='adminIndex'>
        <thead>
        <tr class='text-primary'>
            <th class='text-center'><?php echo Yii::t('app','STT') ?></th>
            <th class='sortable'><?php echo Yii::t('app','Property') ?></th>
            <th><?php echo Yii::t('app','IMEI_serial') ?></th>
            <th><?php echo Yii::t('app','Status') ?></th>
            <th class='text-center'><?php echo Yii::t('app','Action') ?></th>
        </tr>
        </thead>

        <tbody>
        <?php for($i = 0; $i < count($pro); $i++): ?>
            <tr>
                <td class='text-center'><?php echo $i+1 ?></td>
                <td class='username'><strong><?php echo $pro[$i]['pro_name'] ?></strong></td>
                <td class='text-info'><?php echo $pro[$i]['IMEI_serial'] ?></td>
                <td class='text-info'><?php echo $pro[$i]['status'] ?></td>

                <td class='text-center'>
                    <div class="btn-group">
                        <a href="http://<?php echo ROOT_URL?>/property/detail?id=<?php echo $pro[$i]['pro_id'] ?>" class='btn btn-info' title="<?php echo Yii::t('app','Detail') ?>"><i class="fa fa-eye"></i> </a>
                        <a href="http://<?php echo ROOT_URL?>/property/borrow?id=<?php echo $pro[$i]['pro_id'] ?>" class='btn btn-success' title="<?php echo Yii::t('app','Borrow') ?>"><i class="fa fa-shopping-cart"></i></a>
                        <?php if(Yii::app()->session['role'] == 'manager' || Yii::app()->session['role'] == 'admin'): ?>
                            <a href="http://<?php echo ROOT_URL?>/property/returnpro?id=<?php echo $pro[$i]['pro_id'] ?>" class='btn btn-info' title="<?php echo Yii::t('app','Return') ?>"><i class="fa fa-reply"></i> </a>
                            <a href="http://<?php echo ROOT_URL?>/property/edit?id=<?php echo $pro[$i]['pro_id'] ?>" class='btn btn-info' data-toggle="tooltip" title="<?php echo Yii::t('app','Edit') ?>"><i class="fa fa-wrench"></i></a>
                            <button class='btn btn-danger deletePro' data-id='<?php echo  $pro[$i]['pro_id'] ?>' data-toggle="modal" data-target="#modalDeletePro" title="<?php echo Yii::t('app','Delete') ?>"><i class="fa fa-trash-o"></i></button>
                        <?php endif ?>
                    </div>
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

<!--del Property -->
<!-- Modal -->
<div class="modal fade" id="modalDeletePro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-trash-o"></span><?php echo Yii::t('app','Delete') ?> </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer confirm"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="confirm1 hide">
    <button type="button" class="btn btn-danger delete" data-dismiss="modal" data-id="#id#"><?php echo Yii::t('app','Delete') ?></button>
    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('app','Close') ?></button>
</div>
<!--//del property-->


<script type='text/javascript'>
    $(document).ready(function(){
        $('a').tooltip();
        $('button').tooltip();
        $('.deletePro').click(function(){
            $self = $(this);
            $pro_id = $self.data('id');
            $name = $self.parents('tr').find('.pro_name').html();
            $('#modalDeletePro').find('.modal-body').html('').append('<p><?php echo Yii::t('app','Are you sure want to delete Property') ?> <b>' + $name +'</b></p>');
            var template = $('.confirm1').html().replace(/#id#/g,$pro_id);
            $('#modalDeletePro').find('.confirm').html('');
            $(template).appendTo('.confirm');

            $('.delete').click(function() {
                $('body').waitMe({
                    effect: 'win8_linear',
                    text: 'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color:'#000'
                });
                $('body').find('.waitMe_text').css('font-size','20px');
                $('#overlay-full').show();

                $self1 = $(this);
                $id = $self1.data("id");
                $.ajax({
                    type: 'post',
                    url : '/atmarkcafe/property/delete',
                    data: {
                        pro_id : $id
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
    });
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
        $("#adminIndex").tablesorter({
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

        $('#adminIndex').find('thead').find('.sortable').css('font-size','12px');
        $('#adminIndex').find('input').addClass('form-control');
    });
</script>
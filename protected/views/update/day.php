<?php
$this->pageTitle = CHtml::encode(Yii::app()->name);
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>">Dasbboard</a></li>
    <li class="active"><b>Update</b></li>
</ol>
<div id='notify'>

</div>
<div id='divSuccess' class='hide' >
    <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong>Success!</strong> Update successfully
    </div>
</div>
<div id='divError' class='hide'>
    <div class='alert alert-danger' id='error'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong>Error!</strong> Your Update error
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#">Day</a></li>
    <li><a href="/update/days">Days</a></li>
</ul>

<form class="form-inline" role="form" style='padding: 30px 0' id='chooseDate'>
    <div class="form-group">
        <div id="datetimepicker1" class="input-append date">
            <input data-format="dd-MM-yyyy" type="text" class='form-control' id="newDate1" style='width:80%;display:inline;margin-bottom: 5px' name='date' value="<?php echo date('d-m-Y') ?>" readonly>
            <span class="add-on">
                <i class='glyphicon glyphicon-calendar' data-date-icon="icon-calendar"></i>
            </span>
        </div>
    </div>
    <a id="submit" class="btn btn-default" style='margin-bottom: 5px'>Update</a>
</form>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1').datetimepicker({
            language: 'pt-BR'
        });

        $('.allpage').waitMe({
            effect: effect,
            text: 'Please waiting...',
            bg: 'rgba(255,255,255,0.7)',
            color:'#000'
        });

        $('#submit').click(function(){
//            $('#overlay-full').show();
                $('.allpage').waitMe({
                    effect: effect,
                    text: 'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color:'#000'
                });

            $date    = $('#newDate1').val();
            $.ajax({
                type: 'post',
                url : '/update',
                data: {
                    date     : $date
                }
            }).done(function(response){
//                    $('#overlay-full').hide();
                    $('.allpage').waitMe('hide');
                    $('#notify').html('');
                    if(response == 1){
                        var notify = $('#divSuccess').html();
                        $(notify).appendTo('#notify');
                    } else {
                        var notify = $('#divError').html();
                        $(notify).appendTo('#notify');
                    }
                })
        });

    })
</script>
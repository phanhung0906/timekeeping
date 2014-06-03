<?php
$this->pageTitle='Manage User';
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL ?>">Dasbboard</a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/admin">User</a></li>
    <li><a href="http://<?php echo ROOT_URL ?>/overtime">Overtime</a></li>
    <li class="active"><b>Add user</b></li>
</ol>
<?php echo $error ?>
<div class="container">
    <div class="row">
        <section>
            <div class="col-lg-8 col-lg-offset-2">
                <form id="form" method="post" class="form-horizontal">
                    <fieldset>
                        <legend><?php echo $user['fullname'] ?></legend>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Group</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="group" value="<?php echo $user['group_user'] ?>" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Hour remain</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="hourRemain" value="<?php echo $user['hour_allow'] ?>" readonly />
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Overtime hour information</legend>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Day</label>
                            <div class="col-lg-5">
                                <div id="datetimepicker1" class="input-append date">
                                    <input data-format="yyyy-MM-dd" type="text" class='form-control' id="newDate1" style='width:88%;display:inline;margin-bottom: 5px' name='date' value="<?php echo date('Y-m-d') ?>" readonly>
                                    <span class="add-on">
                                        <i class='glyphicon glyphicon-calendar' data-date-icon="icon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Overtime hour</label>
                            <div class="col-lg-5">
                                <select class="form-control" name='hour'>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1').datetimepicker({
            language: 'pt-BR'
        });

        $('#searchForm').remove();
    })
</script>

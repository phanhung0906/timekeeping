<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
//$date = getdate();
?>

<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><a href="http://<?php echo ROOT_URL?>/property"><?php echo Yii::t('app','Property') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Create') ?></b></li>
</ol>
<?php echo $error;?>
<h4><?php echo Yii::t('app','Property Create') ?> </h4>
<form action="" method="post" role="form">
  <table width="60%" border="0" cellspacing="0" class="table">
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Property name') ?>: <span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="text" name="pro_name" size="25" /> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','IMEI_Serial') ?>: <span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="text" name="IMEI_serial" /> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Parameter') ?>:</th>
	    <td><textarea name="parameter" rows="5" class="ckeditor"></textarea></td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Total') ?>: <span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="text" name="total" /></td>
    </tr>
    <tr>
    	<td colspan="2" style="padding-left:200px" ><input style="width:120px; border-radius:5px; " type="submit" name="ok" value="<?php echo Yii::t('app','CREATE') ?>" /></td>
    </tr>
  </table>
</form>
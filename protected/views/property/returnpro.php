<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
//$date = getdate();
?>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><a href="http://<?php echo ROOT_URL?>/property"><?php echo Yii::t('app','Property') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Return') ?></b></li>
</ol>
<?php //echo $error;?>
<h4>Property Borrow</h4>
<form action="" method="post" role="form">
  <table width="60%" border="0" cellspacing="0" class="table">
  	<tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Property name') ?>:</th>
	    <td><input class="form-control" style="width:35%" name="property" size="25" value="<?php echo $rb['property']; ?>" readonly="" /></td>
    </tr>
	 <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrowers') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="text" name="borrowers" size="25" value="<?php echo $rb['borrowers']; ?>" readonly=""/> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrow total') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="text" name="brtotal" value="<?php echo $rb['b_total']; ?>" readonly=""/> </td>
    </tr>
    <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Rest') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="text" name="rest" readonly="" value="<?php echo $pro['rest']?>" readonly=""/></td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrow date') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="date" name="b_date" rows="5" value="<?php echo $rb['b_date']; ?>" readonly=""/> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Return date') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="date" name="r_date" value="<?php echo $rb['r_date']; ?>" readonly=""/></td>
    </tr>
    <tr>
    	<td colspan="2" style="padding-left:200px" ><input style="width:120px; border-radius:5px; " type="submit" name="ok" value="<?php echo Yii::t('app','Return') ?>" /></td>
    </tr>
  </table>
</form>
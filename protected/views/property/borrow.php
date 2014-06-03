<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
//$date = getdate();
?>

<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li class="active"><a href="http://<?php echo ROOT_URL?>/property"><?php echo Yii::t('app','Property') ?></a></li>
    <li class="active"><b><?php echo Yii::t('app','Borrow') ?></b></li>
</ol>
<?php echo $error;?>
<h4><?php echo Yii::t('app','Property Borrow') ?></h4>
<form action="" method="post" role="form">
  <table width="50%" border="0" cellspacing="0" class="table" >
  	<tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Property name') ?>:</th>
	    <td><input class="form-control" style="width:35%" name="property" size="25" value="<?php echo $pro['pro_name']; ?>" readonly="" /></td>
    </tr>
	 <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrowers') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="text" name="borrowers" size="30" value="<?php echo Yii::app()->session['user']; ?>" readonly=""  /></td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrow total') ?>:<span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" placeholder="Borrow total" type="text" name="brtotal" /> </td>
    </tr>
    <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Rest') ?>:</th>
	    <td><input class="form-control" style="width:35%" type="text" name="rest" readonly="" value="<?php echo $pro['total'] - $sum[0]['tong']?>" /></td>
    </tr>
    <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrow time') ?> :<span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="time" name="b_time" class="col-md-2"  /> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Borrow date') ?> :<span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="date" name="b_date" class="col-md-2" /> </td>
    </tr>
    <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Return time') ?> :<span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="time" name="r_time" class="col-md-2" /> </td>
    </tr>
	  <tr>
	    <th class="col-md-2"><?php echo Yii::t('app','Return date') ?> :<span class='text-danger'>*</span></th>
	    <td><input class="form-control" style="width:35%" type="date" name="r_date" class="col-md-2" /></td>
    </tr>
    <tr>
    	<td colspan="2" style="padding-left:200px" ><input style="width:120px; border-radius:5px; " type="submit" name="ok" value="<?php echo Yii::t('app','Borrow') ?>" /></td>
    </tr>
  </table>
</form>
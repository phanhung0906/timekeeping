<?php
$this->pageTitle='Property';
Yii::app()->language= Yii::app()->session['language'];
//$date = getdate();
?>

<style type="text/css">
.table #tb_title th {
	text-align: center;
}
</style>
<ol class="breadcrumb">
    <li><a href="http://<?php echo ROOT_URL?>"><?php echo Yii::t('app','Dashboard') ?></a></li>
    <li><a href="http://<?php echo ROOT_URL?>/property"><?php echo Yii::t('app','Property') ?></a></li>
    <li class="active"><b><?php echo $name['property']; ?></b></li>
</ol>

<h4><?php echo Yii::t('app','Detail') ?> </h4>


<table  class='table table-hover'>
    <tr id="tb_title">
        <th class="col-md-1"><?php echo Yii::t('app','STT') ?></th>
        <th class="col-md-2"><?php echo Yii::t('app','Property') ?></th>
        <th class="col-md-2"><?php echo Yii::t('app','Borrowers') ?></th>
        <th class="col-md-2"><?php echo Yii::t('app','Borrow total') ?> </th>
        <th class="col-md-2"><?php echo Yii::t('app','Borrow date') ?> </th>
        <th class="col-md-2"><?php echo Yii::t('app','Return date') ?> </th>
        <th class="col-md-2"><?php echo Yii::t('app','Send mail') ?> </th>
        <th class="col-md-2"><?php echo Yii::t('app','Status') ?></th>
        <th class="col-md-2"><?php echo Yii::t('app','Return') ?></th>
    </tr>
    <?php 
    for($i = 0; $i < count($detail); $i++){ 
        echo '
        <tr>
            <td>'.($i+1).'</td>
            <td class="property">'.$name['property'].'</td>
            <td>'.$detail[$i]['borrowers'].'</td>
            <td>'.$detail[$i]['b_total'].'</td>
            <td>'.$detail[$i]['b_date'] .''.$detail[$i]['b_time'] .'</td>
            <td>'.$detail[$i]['r_date'] .''.$detail[$i]['r_time'] .'</td>
            <td>'.$detail[$i]['send_mail'].'</td>
            <td>'.$detail[$i]['status'] .'</td>
            <td>
                <div class="btn-group">';?>
                    <a href="http://<?php echo ROOT_URL ?>/property/returnpro?id=<?php echo $detail[$i]['b_id'] ?>" class='btn btn-info'>
                    <?php echo Yii::t("app","Return") ;
        echo "
            </a>    
                </div> 
            </td>
        </tr> 
        "; 
    }
        
    ?>
</table>


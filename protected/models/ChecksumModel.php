<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/19/14
 * Time: 4:17 PM
 * To change this template use File | Settings | File Templates.
 */

class ChecksumModel {

    public function checksumTimekeeping($checksum)
    {
        $check = Yii::app()->db->createCommand()
            ->select('checksum')
            ->from('checksumtimekeeping')
            ->where('checksum=:checksum', array(':checksum' => $checksum))
            ->queryAll();
        return $check;
    }
}
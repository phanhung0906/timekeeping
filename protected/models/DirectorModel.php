<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/7/14
 * Time: 10:54 AM
 * To change this template use File | Settings | File Templates.
 */

class DirectorModel {

    public function listUser()
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->queryAll();
        return $user;
    }
}
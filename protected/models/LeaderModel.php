<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/7/14
 * Time: 9:33 AM
 * To change this template use File | Settings | File Templates.
 */

class LeaderModel {

    public function listUser($sessionUser)
    {
        $group = Yii::app()->db->createCommand()
            ->select('group_user')
            ->from('user')
            ->where('username=:username', array(':username'=>$sessionUser))
            ->queryRow();
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('group_user=:group_user', array(':group_user'=>$group['group_user']))
            ->queryAll();
        return $user;
    }

    public function searchUser($session,$search)
    {
        $group = Yii::app()->db->createCommand()
            ->select('group_user')
            ->from('user')
            ->where('username=:username', array(':username' => $session))
            ->queryRow();
        $command = Yii::app()->db->createCommand();
        return $command->select()
            ->from('user')
            ->where('group_user=:group',array(':group'=>$group['group_user']))
            ->andWhere(array('like', 'fullname', '%'.$search.'%'))
            ->queryAll();
    }

}
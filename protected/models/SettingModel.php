<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/24/14
 * Time: 2:08 PM
 * To change this template use File | Settings | File Templates.
 */

class SettingModel {

    public function settingTime($hoursIn,$minutesIn,$hoursOut,$minutesOut,$hoursFrom,$minutesFrom,$hoursTo,$minutesTo)
    {
        $command = Yii::app()->db->createCommand();
        $command->update('setting', array(
            'hoursIn' => $hoursIn,
            'minutesIn' => $minutesIn,
            'hoursOut' => $hoursOut,
            'minutesOut' => $minutesOut,
            'hoursFrom' => $hoursFrom,
            'minutesFrom' => $minutesFrom,
            'hoursTo' => $hoursTo,
            'minutesTo' => $minutesTo
        ), 'id=:id', array(':id'=>1));
        return 1;
    }

    public function getTime()
    {
        $time = Yii::app()->db->createCommand()
            ->select()
            ->from('setting')
            ->where('id=:id', array(':id'=>1))
            ->queryRow();
        return $time;
    }

    public function getBonus()
    {
        $bonus = Yii::app()->db->createCommand()
            ->select()
            ->from('bonus')
            ->where('id=:id', array(':id'=>1))
            ->queryRow();
        return $bonus;
    }

    public function updateBonus($bonus)
    {
        $command = Yii::app()->db->createCommand();
        $command->update('bonus', array(
          'bonus' => $bonus
        ), 'id=:id', array(':id'=>1));
        return 1;
    }

    public function updateMailCompany($email, $password)
    {
        $command = Yii::app()->db->createCommand();
        $command->update('email_company', array(
            'email' => $email,
            'password' => $password
        ), 'id=:id', array(':id'=>1));
        return 1;
    }

    public function getMailCompany()
    {
        $command = Yii::app()->db->createCommand();
        return $command->select()
            ->from('email_company')
            ->queryRow();
    }

}
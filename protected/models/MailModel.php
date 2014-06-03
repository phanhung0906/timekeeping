<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 4/2/14
 * Time: 9:13 AM
 * To change this template use File | Settings | File Templates.
 */

class MailModel {

    public function sendMail($arrayUser,$month,$year)
    {
        $arrayTemp  = explode(",", $arrayUser);
        $id    = $arrayTemp[0];
        $email = $arrayTemp[1];
        $command = Yii::app()->db->createCommand();
        $command->insert('email', array(
            'user_id'=>$id,
            'email' => $email,
            'month' => $month,
            'year'  => $year,
            'status'=> 'sending'
        ));
    }

    public function getUser()
    {
        $result = Yii::app()->db->createCommand()
            ->select()
            ->from('email')
            ->where("status='sending'")
            ->limit(10)
            ->queryAll();
        return $result;
    }

    public function update($id)
    {
        $command =  Yii::app()->db->createCommand();
        $command->update('email', array(
         'status' => 'sent'
        ), 'id=:id', array(':id'=>$id));
    }
}
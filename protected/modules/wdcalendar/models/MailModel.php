<?php

class MailModel {

    public function sendMail($arrayUser)
    {
        //$sql ="INSERT INTO mailremind( 'email', 'timesend', 'status') VALUES ('".$email."', ".NOW().", 'sending')"
        $arrayTemp  = explode(",", $arrayUser);
       // $id    = $arrayTemp[0];
        $email = $arrayTemp[1];
        $command = Yii::app()->db->createCommand();
        $command->insert('mailremind', array(
            //'id'=>$id,
            'email' => $email,
            //'timesend' => NOW() ,
            'status'=> 'sending'
        ));
        //var_dump($command); die();
    }

    public function getUser()
    {
        $result = Yii::app()->db->createCommand()
            ->select()
            ->from('mailremind')
            ->where("status='sending'")
            ->limit(10)
            ->queryAll();
        return $result;
    }

    public function update($id)
    {
        $command =  Yii::app()->db->createCommand();
        $command->update('mailremind', array(
         'status' => 'sent'
        ), 'id=:id', array(':id'=>$id));
    }

    public function lstsendmail(){
    	$sql = "SELECT * FROM meeting as m, user as u WHERE m.responsible=u.username ";
        //var_dump($sql); die();
        $command = Yii::app()->db->createCommand($sql);
        $res = $command->queryAll();
        return $res;

    }
} 
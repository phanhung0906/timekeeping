<?php

class Property
{
    const ERROR_PRO = -1;
    const SUCCESS = -2;
    public $pro_id;

    public function findProId($pro_id){
        $command = Yii::app()->db->createCommand()
            ->SELECT()
            ->FROM('property')
            ->WHERE('pro_id=:pro_id', array(':pro_id'=>$pro_id))
            ->queryRow();
        return $command;
    }

    public function pro(){
        $command = Yii::app()->db->createCommand()
            ->SELECT()
            ->FROM('property')
            ->queryAll();
        return $command;
    }

    public function searchPro($search)
    {
        $command = Yii::app()->db->createCommand();
        return $command->select()
                ->from('property')
                ->where(array('like', 'pro_name', '%'.$search.'%'))
                ->queryAll();
    }

    public function pro_create($pro_name, $IMEI_serial, $parameter){
        $sql = "SELECT IMEI_serial FROM property WHERE IMEI_serial='".$IMEI_serial."'";
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();
        if ($result == null) {
            $command->insert('property', array(
                'pro_name'      =>  $pro_name,
                'IMEI_serial'   =>  $IMEI_serial,
                'parameter'     =>  $parameter,
                'status'        =>'returned',
            ));
            return Property::SUCCESS;
        }
        
        else
            return Property::ERROR_PRO;
    }

    public function editPro($pro_id, $pro_name, $IMEI_serial, $parameter){
        $sql="UPDATE property SET pro_name='".$pro_name."', IMEI_serial='".$IMEI_serial."', parameter='".$parameter."' WHERE pro_id=".$pro_id;
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function deletePro($pro_id){   
        $sql = "DELETE FROM property WHERE pro_id=".$pro_id;
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function returnPro( $pro_id){
        //$sql = "DELETE FROM borrow WHERE property=".$property;
        $sql = "UPDATE property  SET status='returned'  WHERE pro_id=".$pro_id;
        //var_dump($sql); die();
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }    

    public function borrow($pro_id, $borrowers, $b_time, $b_date, $r_time, $r_date)
    {
        $sql = "UPDATE property SET borrowers='".$borrowers."', b_time='".$b_time."', b_date='".$b_date."', r_date='".$r_date."', r_time='".$r_time."', status='Borrowing' WHERE  status='returned' AND pro_id=".$pro_id ;
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    


    /******mail******/
    /*public function sendMail($property)
    {
        $sql = "UPDATE borrow SET send_mail='send' WHERE property= ".$property;
        //var_dump($sql);
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
       
    }
    /******mail******/

    function hms2sec($hms) {
        list($h, $m, $s) = explode (":", $hms);
        $seconds = 0;
        $seconds += (intval($h) * 3600);
        $seconds += (intval($m) * 60);
        $seconds += (intval($s));
        return $seconds;
    }

    

    public function lstSend()
    {
        $sql = "SELECT * FROM property as p, user as u WHERE p.borrowers=u.username AND r_date=CURDATE() ";
        //var_dump($sql); die();
        $command = Yii::app()->db->createCommand($sql);
        $res = $command->queryAll();
        return $res;
    }
}
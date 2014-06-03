<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/13/14
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */

class OvertimeModel {

    public function checkUserGroup($session, $user_id)
    {
        $command = Yii::app()->db->createCommand();
        $sql = "SELECT * FROM user WHERE username='".$session."'";
        $group = Yii::app()->db->createCommand($sql)->queryRow();
        $user = $command->select()
            ->from('user')
            ->where('user_id=:user_id', array(':user_id' => $user_id))
            ->queryRow();
        return ($group['group_user'] == $user['group_user'] ? true : false);
    }

    public function dayOver($session, $arrayUserId, $date)
    {
        // find day in weak
        $arrayDay = explode('-', $date);
        $ts = mktime(0,0,0, $arrayDay[1], $arrayDay[0], $arrayDay[2]);
        $numUser = count($arrayUserId);
        $response = false;
        for($i=0; $i < $numUser; $i++){
            $check = Yii::app()->db->createCommand()->select()
                ->from('overtime')
                ->where('user_id=:user_id',array(':user_id'=>$arrayUserId[$i]))
                ->andWhere('dateOver=:dateOver',array(':dateOver'=>$arrayDay[2].'-'.$arrayDay[1].'-'.$arrayDay[0]))
                ->queryAll();
            if(count($check) != 0) continue;
            $response = Yii::app()->db->createCommand()->insert('overtime', array(
                'user_id'        => $arrayUserId[$i],
                'dateOver'       => $arrayDay[2].'-'.$arrayDay[1].'-'.$arrayDay[0],
                'dayOver'        => date("l", $ts),
                'by'             => $session
            ));
        }
        return ($response != 0) ? true : false;
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM overtime where id='".$id."'";
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function searchUser($search)
    {
        $command = Yii::app()->db->createCommand();
        $user    = $command->select()
            ->from('overtime o')
            ->join('user u', 'u.user_id=o.user_id')
            ->where(array('like', 'fullname', '%'.$search.'%'))
            ->order('id desc')
            ->queryAll();
        return $user;
    }

    public function leaderSearch($session, $search,$from, $to)
    {
        $group = Yii::app()->db->createCommand()
            ->select('group_user')
            ->from('user')
            ->where('username=:username', array(':username' => $session))
            ->queryRow();
        $command = Yii::app()->db->createCommand();
        $user    = $command->select()
            ->from('overtime o')
            ->join('user u', 'u.user_id=o.user_id')
            ->order('id desc')
            ->where('group_user=:group_user', array(':group_user' => $group['group_user']))
            ->andWhere('o.dateOver>=:from and o.dateOver<=:to',array(':from'=>$from, ':to'=>$to))
            ->andWhere(array('like', 'fullname', '%'.$search.'%'))
            ->queryAll();
        return $user;

    }

    public function chooseDate($from, $to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('overtime o')
            ->join('user u', 'u.user_id=o.user_id')
            ->where('o.dateOver>=:from and o.dateOver<=:to',array(':from'=>$from, ':to'=>$to))
            ->order('id desc')
            ->queryAll();
        return $user;
    }

    public function chooseDateLeader($session, $from, $to)
    {
        $command = Yii::app()->db->createCommand();
        $sql = "SELECT * FROM user WHERE username='".$session."'";
        $group = Yii::app()->db->createCommand($sql)->queryRow();

        $user    = $command->select()
            ->from('overtime o')
            ->join('user u', 'u.user_id=o.user_id')
            ->order('id desc')
            ->where('group_user=:group_user', array(':group_user' => $group['group_user']))
            ->andWhere('o.dateOver>=:from and o.dateOver<=:to',array(':from'=>$from, ':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function chooseDateUser($username, $from, $to)
    {
        $command = Yii::app()->db->createCommand();
        $user    = $command->select()
            ->from('overtime o')
            ->join('user u', 'u.user_id=o.user_id')
            ->order('id desc')
            ->where('username=:username', array(':username' => $username))
            ->andWhere('o.dateOver>=:from and o.dateOver<=:to',array(':from'=>$from, ':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function checkAddToOvertime($arrayUser)
    {
        $command = Yii::app()->db->createCommand();
        $numArrayUser = count($arrayUser);
        for($i = 0;  $i < $numArrayUser; $i++){
            $time_in  = explode(' ', $arrayUser[$i][0][2]);
            $time_out = explode(' ', $arrayUser[$i][1][2]);
            //Check Overtime DB have the same day or not
            $sql = "SELECT * FROM overtime WHERE dateOver='".$time_in[0]."'";
            $arrayOvetime = Yii::app()->db->createCommand($sql)->queryAll();
            if(count($arrayOvetime) == 0) break;
            $sqlUser = "SELECT * FROM user WHERE id_number='".$arrayUser[$i][0][0]."'";
            $user =  Yii::app()->db->createCommand($sqlUser)->queryRow();
            //Check there is user in overtim table or not
            $overtime = $command->select()
                ->from('overtime')
                ->where('user_id=:id and dateOver=:dateOver', array(':id'=>$user['user_id'], ':dateOver'=> $time_in[0]))
                ->queryAll();
            if(count($overtime) == 0) continue;
            $array_timeIn  = explode(':', $time_in[1]);
            $array_timeOut = explode(':', $time_out[1]);
            $timeIn  = (int)$array_timeIn[0] * 60 + (int)$array_timeIn[1];
            $timeOut = (int)$array_timeOut[0] * 60 + (int)$array_timeOut[1];
            //Check day in week
            if($overtime[0]['dayOver'] == 'Sunday' || $overtime[0]['dayOver'] == 'Saturday'){
                $hour = $timeOut - $timeIn;
            } else if($timeOut > 18*60){
                $hour = $timeOut - 18*60;
            } else {
                $hour = 0;
            }
            $sqlUpdate = "UPDATE overtime SET hour='".$hour."' WHERE user_id='".$user['user_id']."' AND dateOver='".$time_in[0]."'";
            Yii::app()->db->createCommand($sqlUpdate)->execute();
//            $command->update('overtime', array(
//                'hour'      => $hour
//            ),'user_id=:id', array(':id' => $user['user_id']));
        }
    }
}
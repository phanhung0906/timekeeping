<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/12/14
 * Time: 5:13 PM
 * To change this template use File | Settings | File Templates.
 */

class AllowOffModel {

    public function checkDayOff($hoursFrom, $minutesFrom, $hoursTo, $minutesTo)
    {
        $settingModel = new SettingModel();
        $result = $settingModel->getTime();
        $fromTime =  $hoursFrom*60 + $minutesFrom;
        $toTime   = $hoursTo*60 + $minutesTo;
        $fromDefault = $result['hoursIn']*60 + $result['minutesIn'];
        $toDefault    = $result['hoursOut']*60 + $result['minutesOut'];
        $breakFrom = $result['hoursFrom']*60 + $result['minutesFrom'];
        $breakTo = $result['hoursTo']*60 + $result['minutesTo'];
        if( (($fromTime >= $fromDefault && $fromTime <= $breakFrom) || ($fromTime >= $breakTo && $fromTime <= $toDefault))
            && (($toTime >= $fromDefault && $toTime <= $breakFrom) || ($toTime >= $breakTo && $toTime <= $toDefault))
            &&($fromTime < $toTime)
        ) {
            return true;
        } else return false;
    }

    public function dayOff($session, $user_id, $day, $minuteOff, $fromOff, $toOff, $reason)
    {
        $command = Yii::app()->db->createCommand();
        $arrayDay = explode('-', $day);
        $ts = mktime(0,0,0,$arrayDay[1],(int)$arrayDay[2],(int)$arrayDay[0]);
        $check = $command->select()
            ->from('dayoff')
            ->where('user_id=:user_id', array(':user_id'=>$user_id))
            ->andWhere('dateOff=:dateOff',array(':dateOff'=>$day))
            ->queryAll();

        $hourRemain = Yii::app()->db->createCommand()->select()
                ->from('user')
                ->where('user_id=:user_id', array(':user_id'=>$user_id))
                ->queryRow();

        if(count($check) != 0){
            $h = (int)$hourRemain['hour_allow'] + (int)$check[0]['hour_off'];
            Yii::app()->db->createCommand()->update('user', array(
                'hour_allow' => $h
            ), 'user_id=:user_id', array(':user_id'=>$user_id));
            $hourRemain = Yii::app()->db->createCommand()->select()
                ->from('user')
                ->where('user_id=:user_id', array(':user_id'=>$user_id))
                ->queryRow();
        }

        $hourAllow = (int)$hourRemain['hour_allow'] - (float)$minuteOff;
        // Update hour_allow in user table
        Yii::app()->db->createCommand()->update('user', array(
            'hour_allow' => $hourAllow
        ), 'user_id=:user_id', array(':user_id'=>$user_id));
        // Delete old DB
        Yii::app()->db->createCommand()->delete('dayoff', 'user_id=:user_id and dateOff=:dateOff', array(':user_id'=>$user_id, ':dateOff'=>$day));
        if($hourAllow < 0){
            $response = $command->insert('dayoff', array(
                'user_id'    => $user_id,
                'dateOff'    => $day,
                'dayOff'     => date('l',$ts),
                'hour_off'   => $minuteOff,
                'by'         => $session,
                'hourAllow'  => 0
            ));
        } else {
            $response = $command->insert('dayoff', array(
                'user_id'    => $user_id,
                'dateOff'    => $day,
                'dayOff'     => date('l',$ts),
                'hour_off'   => $minuteOff,
                'by'         => $session,
                'hourAllow'  => 1,
                'fromOff'    => $fromOff,
                'toOff'      => $toOff,
                'reason'     => $reason
            ));
        }

        return ($response != 0) ? true : false;
    }

    public function deleteUser($id)
    {
        $command = Yii::app()->db->createCommand();
        $sql1 = "SELECT * FROM dayoff WHERE id='".$id."'";
        $user = Yii::app()->db->createCommand($sql1)->queryRow();
        $hourRemain = $command->select('hour_allow')
            ->from('user')
            ->where('user_id=:user_id', array(':user_id' => $user['user_id']))
            ->queryRow();
        $command->update('user', array(
            'hour_allow' => (int)$hourRemain['hour_allow'] + (int)$user['hour_off']
        ), 'user_id=:user_id', array(':user_id'=>$user['user_id']));
        //delete info user in dayoff
        $sql = "DELETE FROM dayoff where id='".$id."'";
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function searchUser($search)
    {
        $command = Yii::app()->db->createCommand();
        return $command->select()
            ->from('user u')
            ->join('dayoff d', 'u.user_id=d.user_id')
            ->where(array('like', 'fullname', '%'.$search.'%'))
            ->order('dateOff desc')
            ->queryAll();
    }

    public function searchById($user_id, $month, $year)
    {
        $ts     = mktime(0,0,0,$month,1,$year);
        $numday = date("t", $ts);
        $from   = '01-'.$month.'-'.$year;
        $to     = $numday.'-'.$month.'-'.$year;
        $command = Yii::app()->db->createCommand();
        return $command->select()
            ->from('user u')
            ->join('dayoff d', 'u.user_id=d.user_id')
            ->where('d.user_id=:user_id', array(':user_id' => $user_id))
            ->andWhere('d.dateOff>=:from and d.dateOff<=:to',array(':from'=>$from, ':to'=>$to))
            ->order('dateOff desc')
            ->queryAll();
    }

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

    public function chooseDate($from, $to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('dayoff d')
            ->join('user u', 'u.user_id=d.user_id')
            ->where('d.dateOff>=:from and d.dateOff<=:to',array(':from'=>$from, ':to'=>$to))
            ->order('id desc')
            ->queryAll();
        return $user;
    }

    public function chooseDateLeader($session, $from, $to)
    {
        $command = Yii::app()->db->createCommand();
        $sql = "SELECT * FROM user WHERE username=:sessionUser";
        $group = Yii::app()->db->createCommand($sql);
        $group->bindParam(":sessionUser",$session,PDO::PARAM_STR);
        $result = $group->queryRow();
        $user    = $command->select()
            ->from('dayoff d')
            ->join('user u', 'u.user_id=d.user_id')
            ->order('id desc')
            ->where('group_user=:group_user', array(':group_user' => $result['group_user']))
            ->andWhere('d.dateOff>=:from and d.dateOff<=:to',array(':from'=>$from, ':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function chooseDateUser($session, $from, $to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('dayoff d', 'u.user_id=d.user_id AND t.date=d.dateOff')
            ->order('t.date desc')
            ->where('username=:username', array(':username' => $session))
            ->andWhere('t.date>=:from and t.date<=:to', array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function checkUser($username, $from, $to)
    {
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('username=:username', array(':username' => $username))
            ->queryRow();
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('dayoff')
            ->where('user_id=:user_id', array(':user_id' => $command['user_id']))
            ->andWhere('dateOff>=:from and dateOff<=:to', array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

}
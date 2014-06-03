<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/7/14
 * Time: 1:25 PM
 * To change this template use File | Settings | File Templates.
 */

class TimeKeepingModel {

    public function addUser($arrayUser)
    {
        $command = Yii::app()->db->createCommand();
        $numArrayUser = count($arrayUser);
        for($i = 0;  $i < $numArrayUser; $i++){
            $time_in  = explode(' ', $arrayUser[$i][0][2]);
            $time_out = explode(' ', $arrayUser[$i][1][2]);
            // find day in weak
            $arrayDay = explode('-', $time_in[0]);
            $ts = mktime(0,0,0,$arrayDay[1],$arrayDay[2],$arrayDay[0]);
            $command->insert('timekeeping', array(
//                'user_machine'=>$arrayUser[$i][0][1],
                'date'      => $time_in[0],
                'day'       => date("l", $ts),
                'time_in'   => $time_in[1],
                'time_out'  => $time_out[1],
                'id_number' => $arrayUser[$i][0][0]
            ));
        }
    }

    public function deleteDay($arraydate)
    {
        $time = explode(' ', $arraydate);
        $date = $time[0];
        $sql = "DELETE FROM timekeeping where date='".$date."'";
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function deleteDays($from, $to)
    {
        $command = Yii::app()->db->createCommand();
        $command->delete('timekeeping', 'date>=:from and date<=:to', array(':from'=>$from, ':to'=> $to));
    }

    public function timeUser($session)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.date desc')
            ->where('username=:username', array(':username' => $session))
            ->queryAll();
        return $user;
    }

    public function timeSearchUser($post)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.id_number,t.date asc')
            ->where(array('like','fullname','%'.$post.'%'))
            ->queryAll();
        return $user;
    }

    public function leaderSearch($session,$post,$from,$to)
    {
        $group = Yii::app()->db->createCommand()
            ->select('group_user')
            ->from('user')
            ->where('username=:username', array(':username' => $session))
            ->queryRow();
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.id_number,t.date asc')
            ->where(array('like','fullname','%'.$post.'%'))
            ->andWhere('u.group_user=:group_user', array(':group_user' => $group['group_user']))
            ->andWhere('t.date>=:from and t.date<=:to',array(':from'=> $from,':to'=> $to))
            ->queryAll();
         return $user;
    }

    public function directorSearch($post,$from,$to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.id_number,t.date asc')
            ->where(array('like','fullname','%'.$post.'%'))
            ->andWhere('t.date>=:from and t.date<=:to',array(':from'=> $from,':to'=> $to))
            ->queryAll();
        return $user;
    }

    public function chooseDate($from, $to)
    {
        $sql="SELECT * FROM user INNER JOIN timekeeping ON user.id_number=timekeeping.id_number
                LEFT JOIN overtime ON user.user_id=overtime.user_id AND timekeeping.date=overtime.dateOver
                WHERE timekeeping.date>='".$from."' AND timekeeping.date<='".$to."' ORDER BY timekeeping.id_number,timekeeping.date ASC";
        $command = Yii::app()->db->createCommand($sql)->queryAll();
        return $command;
    }

    public function chooseDateUser($session, $from, $to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.date asc')
            ->where('username=:username', array(':username' => $session))
            ->andWhere('t.date>=:from and t.date<=:to', array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function chooseDateLeader($session, $from, $to)
    {
        $group = Yii::app()->db->createCommand()
            ->select('group_user')
            ->from('user')
            ->where('username=:username', array(':username' => $session))
            ->queryRow();

        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->leftJoin('overtime o', 'u.user_id=o.user_id AND t.date=o.dateOver')
            ->order('t.id_number, t.date asc')
            ->where('group_user=:group_user', array(':group_user' => $group['group_user']))
            ->andWhere('t.date>=:from and t.date<=:to',array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function timeKepping($id_number,$from,$to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('timekeeping t')
            ->where('id_number=:id_number', array(':id_number' => $id_number))
            ->andWhere('t.date>=:from and t.date<=:to',array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function showIndex($from, $to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->order('t.id_number, t.date asc')
            ->where('t.date>=:from and t.date<=:to', array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function showIndexId($id_number,$from,$to)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->order('t.date asc')
            ->where('u.id_number=:id_number', array(':id_number' => $id_number))
            ->andWhere('t.date>=:from and t.date<=:to',array(':from'=>$from,':to'=>$to))
            ->queryAll();
        return $user;
    }

    public function showDate($date)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user u')
            ->join('timekeeping t', 'u.id_number=t.id_number')
            ->where('t.date=:date', array(':date'=>$date))
            ->queryAll();
        return array($user);
    }
}
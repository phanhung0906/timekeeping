<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function checkSession()
    {
        if(!Yii::app()->session['user'] || !Yii::app()->session['role'])
            $this->redirect('http://'.ROOT_URL.'/login',array('error' => ''));
    }

    public function getSessionUser()
    {
        return Yii::app()->session['user'];
    }

    public function getSessionRole()
    {
        return Yii::app()->session['role'];
    }

    public function getSetting()
    {
        $model = new SettingModel();
        $time = $model->getTime();
        return $time;
    }

    public function convertDate($date)
    {
        $arrayDate = explode('-', $date);
        return $arrayDate[2].'-'.$arrayDate[1].'-'.$arrayDate[0];
    }

    public function getDate()
    {
        $date   = getdate();
        $month = $date['mon'];
        if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
        $ts     = mktime(0,0,0,$date['mon'],1,$date['year']);
        $numday = date("t", $ts);
        return  array('from' => '01-'.$month.'-'.$date['year'], 'to' =>  $numday.'-'.$month.'-'.$date['year']);
    }

    public function chooseDate($dateFrom, $dateTo)
    {
        $from = $this->convertDate($dateFrom);
        $to   = $this->convertDate($dateTo);
        $f = str_replace('-', '/', $this->convertDate($from));
        $t = str_replace('-', '/', $this->convertDate($to));
        return array('from' => $from, 'to' => $to, 'f' => $f, 't' => $t);
    }

    public function fromto($month, $year)
    {
        $ts     = mktime(0,0,0,$month,1,$year);
        $numday = date("t", $ts);
        $from   = '01-'.$month.'-'.$year;
        $to     = $numday.'-'.$month.'-'.$year;
        return array('from' => $this->convertDate($from),'to' => $this->convertDate($to));
    }

    // Same year and max is 2 month
    public function getNumDayFromTo($from, $to)
    {
        $arrayFrom = explode('-', $from);
        $arrayTo = explode('-', $to);
        if((int)$arrayFrom[2] == (int)$arrayTo[2]){
            if((int)$arrayTo[1] - (int)$arrayFrom[1] <= 2){
                return true;
            } else return false;
        } else {
            return false;
        }
    }

    public function getArrayTime($user)
    {
        $time = $this->getSetting();
        $hoursIn    = (int)$time['hoursIn'];
        $minutesIn  = (int)$time['minutesIn'];
        $hoursOut   = (int)$time['hoursOut'];
        $minutesOut = (int)$time['minutesOut'];
        $hoursFrom  = (int)$time['hoursFrom'];
        $minutesFrom= (int)$time['minutesFrom'];
        $hoursTo    = (int)$time['hoursTo'];
        $minutesTo  = (int)$time['minutesTo'];
        //set time to minutes
        $minutesTimeIn      = $hoursIn*60 + $minutesIn;
        $minutesTimeOut     = $hoursOut*60 + $minutesOut;
        $minutesTimeFrom    = $hoursFrom*60 + $minutesFrom;
        $minutesTimeTo      = $hoursTo*60 + $minutesTo;
        $minutesBreak       = $minutesTimeTo - $minutesTimeFrom;
        $totalTimeWork      = $minutesTimeOut - $minutesTimeIn - $minutesBreak;

        $array_time = array();
        for($i = 0; $i < count($user); $i++){
            $array_timeIn  = explode(':',$user[$i]['time_in']);
            $array_timeOut = explode(':',$user[$i]['time_out']);
            $timeIn  = (int)$array_timeIn[0] * 60 + (int)$array_timeIn[1];
            $timeOut = (int)$array_timeOut[0] * 60 + (int)$array_timeOut[1];
            if( $timeIn >= $minutesTimeIn && $timeIn <= $minutesTimeFrom ){
                $timeLate  = $timeIn - $minutesTimeIn;
            } else if( $timeIn >= $minutesTimeTo){
                $timeLate  = $timeIn - $minutesTimeIn - $minutesBreak;
            } else if($timeIn > $minutesTimeFrom && $timeIn < $minutesTimeTo){
                $timeLate  = $minutesTimeFrom - $minutesTimeIn;
            } else if( $timeIn > $minutesTimeOut){
                $timeLate  = $totalTimeWork;
            } else {
                $timeLate  = 0;
            }
            if($timeOut <= $minutesTimeOut && $timeOut >= $minutesTimeTo){
                $timeEarly = $minutesTimeOut - $timeOut;
            } else if($timeOut < $minutesTimeFrom){
                $timeEarly = $minutesTimeOut - $timeOut - $minutesBreak;
            } else if($timeOut > $minutesTimeFrom && $timeOut < $minutesTimeTo){
                $timeEarly  = $minutesTimeOut - $minutesTimeTo;
            } else if($timeOut < $minutesTimeIn ){
                $timeEarly  = $totalTimeWork;
            } else {
                $timeEarly = 0;
            }
            $totalTime    = round(($totalTimeWork - $timeLate - $timeEarly)/60, 2);
            if($totalTime < 0 ) $totalTime = 0;
            $percentOfDay = round($totalTime/8, 2);
            if($user[$i]['hour'] != null){
                $total = $totalTime + round($user[$i]['hour']/60,2);
            } else $total = $totalTime;
            array_push($array_time, array('timeLate' => $timeLate,'timeEarly' => $timeEarly,'totalTime' => $totalTime,'percentOfDay' => $percentOfDay, 'total'=>$total));
        }
        return $array_time;
    }



    public function numTime($array_time, $user, $from, $to)
    {
        $numLate = 0;
        $numEarly = 0;
        $minuteLate = 0;
        $minuteEarly =0;
        for($i = 0; $i < count($array_time); $i++){
            if($array_time[$i]['timeLate'] >0) ++$numLate;
            if($array_time[$i]['timeEarly'] >0) ++$numEarly;
            $minuteLate += $array_time[$i]['timeLate'];
            $minuteEarly += $array_time[$i]['timeEarly'];
        }
        if(count($user) == 0){
            $unexcused = '...';
            $excused = '...';
        } else {
            $modelDayOff = new AllowOffModel();
            $result = $modelDayOff->checkUser($user[0]['username'], $from, $to);
            $excused = count($result);

        }
        return $array_num = array('numLate' => $numLate,'numEarly' => $numEarly,'minuteLate'=>$minuteLate,'minuteEarly'=>$minuteEarly,'excused'=>$excused);
    }

    public function salary($user, $month, $year)
    {
        $modelTimeKeeping = new TimeKeepingModel();
        $modelDayOff = new AllowOffModel();
        $modelOvertime = new OvertimeModel();
        $modelSetting = new SettingModel();
        $timeOff = $modelDayOff->searchById($user['user_id'], $month, $year);
        $allow = 0;
        $unAllow = 0;
        //DayOff
        for($i = 0; $i < count($timeOff); $i++){
            if($timeOff[$i]['hourAllow'] == 1){
                $allow   += $timeOff[$i]['hour_off'];
            } else {
                $unAllow += $timeOff[$i]['hour_off'];
            }
        }
        //Late
        $fromto  = $this->fromto($month, $year);
        $userChoose = $modelTimeKeeping->chooseDateUser($user['username'], $fromto['from'], $fromto['to']);
        $array_time = $this->getArrayTime($userChoose);
        $numArrayTime = count($array_time);
        $timeLate = 0;
        $timeEarly = 0;
        $leaveOfAbsence = 0;
        if($userChoose != null){
            $salaryOneDay = $userChoose[0]['basicSalary'] / 30;
        } else $salaryOneDay = 0;
        $salary = 0;
        $timeOver = 0;
        for($i = 0; $i < $numArrayTime; $i++){
            //absent or late without leave or not
            $userChoose1 = $modelDayOff->chooseDateUser($user['username'], $userChoose[$i]['date'], $userChoose[$i]['date']);
            if($userChoose1[0]['hour_off'] == null)
            {
                if($array_time[$i]['timeLate'] >= 5)
                $timeLate  += $array_time[$i]['timeLate'];
                $timeEarly += $array_time[$i]['timeEarly'];
            } else {
                    if($userChoose1[0]['hour_off'] - $array_time[$i]['timeLate'] >= 0) {
                        $timeLate += 0;
                    } else {
                        $timeLate += $array_time[$i]['timeLate'] - $userChoose1[0]['hour_off'];
                    }
                    if($userChoose1[0]['hour_off'] - $array_time[$i]['timeLate'] - $array_time[$i]['timeEarly'] >= 0){
                        $timeEarly += 0;
                    } else {
                        $timeEarly += $array_time[$i]['timeEarly'];
                    }
            }
            $leaveOfAbsence += $userChoose1[0]['hour_off'];
            $salary += $salaryOneDay * $array_time[$i]['percentOfDay'];
        }
        //Overtime
        $userChoose2 = $modelOvertime->chooseDateUser($user['username'], $fromto['from'], $fromto['to']);
        if(count($userChoose2) != 0) {
            $numUserChoose2 = count($userChoose2);
            for($j=0;$j<$numUserChoose2;$j++){
                if($userChoose2[$j]['dayOver'] == 'Sunday' || $userChoose2[$j]['dayOver'] == 'Saturday'){
                    $time = $userChoose2[$j]['hour'] * 2;
                } else {
                    $time = $userChoose2[$j]['hour'] * 1.5;
                }
                $timeOver += $time;
            }
        }
        $salaryOver = ($salaryOneDay/8) * $timeOver;
        $salary += $salaryOver;
        // Bonus
        $arrayBonus = $modelSetting->getBonus();
        $bonus = $arrayBonus['bonus'];
        $arrayTimekeeping = $this->fromto($month, $year);
        $arrayTP = $modelTimeKeeping->timeKepping($user['id_number'], $arrayTimekeeping['from'], $arrayTimekeeping['to']);
        $numDayBonus = count($arrayTP);
        $totalBonus = (int)$bonus * (int)$numDayBonus;
        return array('late' => $timeLate,'early' => $timeEarly,'leaveOfAbsence' => $leaveOfAbsence,'overtime' => $timeOver*60,'salaryOver'=>$salaryOver, 'salary' => $salary,'totalBonus'=>$totalBonus);
    }

    public function downAttlog($startDate, $endDate)
    {
        //192.168.3.202
        $url = "http://".IP;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false)
        {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 404)
            {
                return 1;
            }
        } else {
            return 1;
          }

        $data = array(
            'username' => 'administrator',
            'userpwd' => '123456',
        );

        $cookieFile = Yii::getPathOfAlias('application.runtime') . '/cookie.txt';

        // set URL and other appropriate options
        $defaults = array(
            CURLOPT_COOKIESESSION => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            //CURLOPT_HTTPHEADER => array("Content-type: application/x-www-form-urlencoded\r\nAuthorization: Basic YWRtaW46bG92ZTE5ODM="),
            CURLOPT_URL => 'http://'.IP.'/csl/login',
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_FORBID_REUSE => 1,
            //CURLOPT_TIMEOUT => 4,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POSTFIELDS => http_build_query($data)
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        // grab URL and pass it to the browser
        curl_exec($ch);
        curl_setopt($ch, CURLOPT_URL, 'http://'.IP.'/csl/check');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);
        curl_setopt($ch, CURLOPT_URL, 'http://'.IP.'/form/Download');
        curl_setopt($ch, CURLOPT_POST, 1);
//        $startDate = date("Y-m-d");
//        $endDate = date("Y-m-d");
        $period =1;
        $downloadVars = array(
            'sdate' => $startDate,
            'edate' => $endDate,
            'period' => $period,
        );

        $strVars = 'aaaa=1';
        foreach ($downloadVars as $key => $val) {
            $strVars .= '&' . $key . '=' . $val;
        }

        for ($i = 1; $i < 50; $i++) {
            $strVars .= '&uid=' . $i;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $strVars);

        $result3 = curl_exec($ch);
        $file = fopen("download/today/attlog.dat","w+");
        fwrite($file, $result3);
    }

    public function updateDays($from, $to)
    {
        $urlFile =  "download/today/attlog.dat";
        if(file_exists($urlFile)){
            $fp = fopen($urlFile, "r");
            $arrayAttlog = array(); //All data in attlog.dat
            $arrayId    = array(); //Number of staff
            $array = array( 'num' => array(), 'a' => array());
            $checksum = '';
            while(!feof($fp))
            {
                $string = fgets($fp);
                array_push($arrayAttlog, explode("\t",$string));
            }

            fclose($fp);
            if(count($arrayAttlog) == 0) return;
            array_pop ($arrayAttlog); // delete element in last array
            $numArrayAttlog    = count($arrayAttlog);
            $check = true;
            //Get all ID of user from timekeeping machine
            for($i = 1; $i < $numArrayAttlog; $i++){
                if(count($arrayId) == 0){
                    array_push($arrayId, $arrayAttlog[$i][0]);
                }
                $countArrayId = count($arrayId);
                for($j = 0; $j < $countArrayId; $j++){
                    if($arrayId[$j] == $arrayAttlog[$i][0]) {
                        $check = false; // same value => not save to array
                        break;
                    } else  {
                        $check = true; //save to array
                    }
                }
                if($check){
                    array_push($arrayId, $arrayAttlog[$i][0]);
                }
            }

            $arrayNumOfId = array();
            $countArrayId = count($arrayId);
            for($q = 0; $q < $countArrayId; $q++){
                $numOfId = 0;
                for($k = 0; $k < $numArrayAttlog; $k++){
                    if($arrayAttlog[$k][0] == $arrayId[$q]){
                        ++$numOfId;
                    }
                }
                array_push($arrayNumOfId, $numOfId);
            }

            $arrayDay = array();
            for($m = 0; $m < $countArrayId; $m++){
                for($i = 0; $i < $numArrayAttlog; $i++){
                    if($arrayId[$m] == $arrayAttlog[$i][0]){ // Fillter ID
//                        $numDay = 0;
                        $arrayDate = explode(' ', $arrayAttlog[$i][2]);
                        if(count($arrayDay) == 0){
                            array_push($arrayDay,array($arrayId[$m], $arrayDate[0]));
                        }
                        $countArrayDay = count($arrayDay);
                        for($p = 0; $p < $countArrayDay; $p++){ // list day of arrayDay
                            if($arrayDay[$p][1] == $arrayDate[0] && $arrayDay[$p][0] == $arrayId[$m]) {
                                $check = false; // same value => not save to array
//                                ++$numDay;
                                break;
                            } else {
//                                $numDay = 0;
                                $check = true; //save to array
                            }
                        }
                        if($check){
                            array_push($arrayDay, array($arrayId[$m], $arrayDate[0]));
                        }
                    }
                }
            }
            $arrayNumOfDay = array();
            $countArrayDay = count($arrayDay);
            for($h = 0; $h < $countArrayDay; $h++){
                $numDay = 0;
                for($i = 0; $i < $numArrayAttlog; $i++){
                    $arrayDate = explode(' ', $arrayAttlog[$i][2]);
                    if($arrayDay[$h][1] == $arrayDate[0] && $arrayDay[$h][0] == $arrayAttlog[$i][0]) {
                        ++$numDay;
                   }
                }
                array_push($arrayNumOfDay, array($arrayDay[$h][0],$arrayDay[$h][1],$numDay));
            }

            $arrayUser = array();
            $countArrayNumOfDay = count($arrayNumOfDay);
            for($m = 0; $m < $countArrayNumOfDay; $m++){
                for($i = 0; $i < $numArrayAttlog; $i++){
                    $arrayDate = explode(' ', $arrayAttlog[$i][2]);
                    if($arrayAttlog[$i][0] == $arrayNumOfDay[$m][0] && $arrayDate[0] == $arrayNumOfDay[$m][1]){ // find user in attlog by ID
                        array_push($arrayUser, array($arrayAttlog[$i], $arrayAttlog[$i + $arrayNumOfDay[$m][2]-1]));
                        break;
                    }
                }
            }

            if(count($arrayUser) == 0) return;
            $model = new TimeKeepingModel();
            $modelOvertime = new OvertimeModel();
            $modelOvertime->checkAddToOvertime($arrayUser); // Check overtime
            $model->deleteDays($from, $to);
            $model->addUser($arrayUser); //Save to Timekeeping DB
        }
    }

//    public function updateDay()
//    {
//        $urlFile =  "download/today/attlog.dat";
//        if(file_exists($urlFile)){
//            $fp = fopen($urlFile, "r");
//            $arrayAttlog = []; //All data in attlog.dat
//            $arrayNum    = []; //Number of staff
////            $array = array( 'num' => array(), 'a' => array());
////            $checksum = '';
//            while(!feof($fp))
//            {
//                $string = fgets($fp);
//                array_push($arrayAttlog, explode("\t",$string));
//            }
//
//            fclose($fp);
//            if(count($arrayAttlog) == 0) return;
//            array_pop ($arrayAttlog); // delete element in last array
//            $numArrayAttlog    = count($arrayAttlog);
//            $check = true;
//            for($i = 1; $i < $numArrayAttlog; $i++){
//                if(count($arrayNum) == 0){
//                    array_push($arrayNum, $arrayAttlog[$i][0]);
//                }
//                for($j = 0; $j < count($arrayNum); $j++){
//                    if($arrayNum[$j] == $arrayAttlog[$i][0]) {
//                        $check = false; // same value => not save to array
//                        break;
//                    } else  {
//                        $check = true; //save to array
//                    }
//                }
//                if($check){
//                    array_push($arrayNum, $arrayAttlog[$i][0]);
//                }
//            }
//            $arrayNumOfNum = [];
//            for($q = 0; $q < count($arrayNum); $q++){
//                $numOfnum = 0;
//                for($k = 0; $k < $numArrayAttlog; $k++){
//                    if($arrayAttlog[$k][0] == $arrayNum[$q]){
//                        ++$numOfnum;
//                    }
//                }
//                array_push($arrayNumOfNum, $numOfnum);
//            }
//            $arrayUser = [];
//            for($m = 0; $m < count($arrayNum); $m++){
//                for($i = 0; $i < $numArrayAttlog; $i++){
//                    if($arrayAttlog[$i][0] == $arrayNum[$m]){ // find the first user in attlog
//                        array_push($arrayUser, array($arrayAttlog[$i],$arrayAttlog[$i+$arrayNumOfNum[$m]-1]));
//                        break;
//                    }
//                }
//            }
//            if(count($arrayUser) == 0) return;
//            $model = new TimeKeepingModel();
//            $modelOvertime = new OvertimeModel();
//            $modelOvertime->checkAddToOvertime($arrayUser); // Check overtime
//            $model->deleteDay($arrayUser[0][0][2]);
//            $model->addUser($arrayUser); //Save to Timekeeping DB
//        }
//    }

    public function chartYear($year)
    {
        $arrayChart = array();
        $chart      = array();
        for($i = 1; $i <= 12; $i++){
            $month = $i;
            if( strlen((string)$month) == 1) $month = '0'.$i;
            $reaponse = $this->chart($i, $year);
            array_push($arrayChart,$reaponse);
        }
       for($j = 0; $j < 12; $j++){                                    // array in Month
           $numUserLateAday = 0;
           $numUserEarlyeAday = 0;
           $numUserOvertimeAday = 0;
           $totalTimeLate = 0;
           $totalTimeEarly = 0;
           $totalTimeOver = 0;
           $numDayOfMonth = count($arrayChart[$j]);
          for($m = 0; $m < $numDayOfMonth; $m++){                      //array in Day
              $numUserLateAday += $arrayChart[$j][$m]['numLate'];
              $numUserEarlyeAday += $arrayChart[$j][$m]['numEarly'];
              $numUserOvertimeAday += $arrayChart[$j][$m]['numOvertime'];
              $totalTimeLate += $arrayChart[$j][$m]['totalTimeLate'];
              $totalTimeEarly += $arrayChart[$j][$m]['totalTimeEarly'];
              $totalTimeOver += $arrayChart[$j][$m]['totalTimeOver'];
          }
           array_push($chart,array('numLate' => $numUserLateAday, 'numEarly' => $numUserEarlyeAday, 'numOvertime' => $numUserOvertimeAday, 'totalTimeLate' =>$totalTimeLate,'totalTimeEarly' =>$totalTimeEarly,'totalTimeOver' =>$totalTimeOver ));
       }
        return $chart;
    }

    public function chart($month, $year)
    {
        // Get Time in setting table
        $time = $this->getSetting();
        $hoursIn    = (int)$time['hoursIn'];
        $minutesIn  = (int)$time['minutesIn'];
        $hoursOut   = (int)$time['hoursOut'];
        $minutesOut = (int)$time['minutesOut'];
        //set time to minutes
        $minutesTimeIn      = $hoursIn*60 + $minutesIn;
        $minutesTimeOut     = $hoursOut*60 + $minutesOut;
        //set day
        $fromTo = $this->fromto($month, $year);
        $modelUser = new TimeKeepingModel();
        $user = $modelUser->chooseDate($fromTo['from'], $fromTo['to']);
        $ts     = mktime(0,0,0,$month,1,$year);
        $numday = date("t", $ts);
        $chart = array();
        $numUser = count($user);
        //Late , Early ,Overtime
        for ($i = 1; $i <= $numday; $i++) {
            $numUserLateAday = 0;
            $numUserEarlyeAday = 0;
            $numUserOvertimeAday = 0;
            $totalTimeLate = 0;
            $totalTimeEarly = 0;
            $totalTimeOver = 0;
            for($j = 0; $j < $numUser; $j++){
                $arrayDay = explode('-', $user[$j]['date']);
                $day = (int)$arrayDay[2];
                if($day != $i) continue; // Check user in that day or not
                $array_timeIn  = explode(':',$user[$j]['time_in']);
                $array_timeOut = explode(':',$user[$j]['time_out']);
                $timeIn  = (int)$array_timeIn[0] * 60 + (int)$array_timeIn[1];
                $timeOut = (int)$array_timeOut[0] * 60 + (int)$array_timeOut[1];
                if($timeIn > $minutesTimeIn){
                    ++$numUserLateAday;
                    $totalTimeLate += $timeIn - $minutesTimeIn;
                }

                if($timeOut < $minutesTimeOut){
                    ++$numUserEarlyeAday;
                    $totalTimeEarly += $minutesTimeOut - $timeOut;
                }

                if($user[$j]['dateOver'] != null) {
                    ++$numUserOvertimeAday;
                    $totalTimeOver += $user[$j]['hour'];
                }
            }
            array_push($chart,array('numLate' => $numUserLateAday, 'numEarly' => $numUserEarlyeAday, 'numOvertime' => $numUserOvertimeAday, 'totalTimeLate' =>$totalTimeLate,'totalTimeEarly' =>$totalTimeEarly,'totalTimeOver' =>$totalTimeOver ));
        }
        return $chart;
    }

    public function statisticYear($year)
    {
        $arrayChart         = array();
        $statisticYear      = array();
        for($i = 1; $i <= 12; $i++){
            $month = $i;
            if( strlen((string)$month) == 1) $month = '0'.$i;
            $reaponse = $this->statistic($i, $year);
            array_push($arrayChart,$reaponse);
        }
        $numUser = count($reaponse);
            for($m = 0; $m < $numUser; $m++){    // STT cua user
                $countLate = 0;
                $countEarly = 0;
                for($j = 0; $j < 12; $j++){
                  $countLate += $arrayChart[$j][$m]['countLate'];
                  $countEarly += $arrayChart[$j][$m]['countEarly'];
                }
                array_push($statisticYear,array('countLate' => $countLate,'countEarly'=> $countEarly, 'fullname' => $arrayChart[0][$m]['fullname'] ));
            }
        return $statisticYear;
    }

    public function statistic($month, $year) {
        $modelUser   = new UserModel();
        $listUser    = $modelUser->listUser();
        // Get Time in setting table
        $time = $this->getSetting();
        $hoursIn    = (int)$time['hoursIn'];
        $minutesIn  = (int)$time['minutesIn'];
        $hoursOut   = (int)$time['hoursOut'];
        $minutesOut = (int)$time['minutesOut'];
        //set time to minutes
        $minutesTimeIn      = $hoursIn*60 + $minutesIn;
        $minutesTimeOut     = $hoursOut*60 + $minutesOut;
        //set day
        $fromTo = $this->fromto($month, $year);
        $modelUser = new TimeKeepingModel();
        $user = $modelUser->chooseDate($fromTo['from'], $fromTo['to']);
        $ts     = mktime(0,0,0,$month,1,$year);
        $numday = date("t", $ts);
        $statistic = array();
        $numUser = count($user);
        //Late , Early ,
        $numListUser = count($listUser);
        for($i = 0; $i < $numListUser; $i++){ // each user in user table
            $countLate = 0;
            $countEarly = 0;
            for ($j = 0; $j < $numUser; $j++) { // each element in user array
                if ($listUser[$i]['id_number'] == $user[$j]['id_number'] && $listUser[$i]['username'] != 'admin') {
                    $array_timeIn  = explode(':',$user[$j]['time_in']);
                    $array_timeOut = explode(':',$user[$j]['time_out']);
                    $timeIn  = (int)$array_timeIn[0] * 60 + (int)$array_timeIn[1];
                    $timeOut = (int)$array_timeOut[0] * 60 + (int)$array_timeOut[1];
                    if($timeIn > $minutesTimeIn){
                        ++$countLate;
                    }

                    if($timeOut < $minutesTimeOut){
                        ++$countEarly;
                    }
                }
            }
            if ($listUser[$i]['username'] != 'admin') {
                array_push($statistic, array('countLate' => $countLate,'countEarly'=>$countEarly,'fullname' => $listUser[$i]['fullname']));
            }
        }

        return $statistic;
    }

    public function exportExcel($user, $salary, $month, $year, $pathSave)
    {
        Yii::app()->language= Yii::app()->session['language'];
        $date = getdate();
        $ts     = mktime(0,0,0,$date['mon'],1,$date['year']);
        $numDayOfMonth = date("t", $ts);
        Yii::import('ext.phpexcel.XPHPExcel');
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '')
            ->setCellValue('A2',  Yii::t('app','Payslip'). '('.$month.'/'.$year.')')
            ->setCellValue('A3', Yii::t('app','Full name').': '. $user['fullname'])
            ->setCellValue('A4', Yii::t('app','Position').': '.$user['position'])
            ->setCellValue('A5', Yii::t('app','#'));

// Set align, font and size
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(13);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(16)->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B28:D28')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //Set width , height cell
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(6);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(35);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(25);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(8);

        // Border
        $style = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOTTED,
                    'color' => array('argb' => '000'),
                ),
            ),
        );
        for($i = 6; $i < 24 ;$i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($style);
        }

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A24')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B24')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C24')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D24')->applyFromArray($styleArray);

        // Date
        $objPHPExcel->getActiveSheet()->mergeCells('B28:D28');
        $objPHPExcel->getActiveSheet()
            ->getStyle('B28:D28')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()
            ->getStyle('B28:D28')->getFont()->setItalic(true);

        $objPHPExcel->getActiveSheet()->mergeCells('B31:D31');
        $objPHPExcel->getActiveSheet()
            ->getStyle('B31:D31')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // STT
        for($i = 6; $i < 25; $i++){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $i-5);
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B5', Yii::t('app','Content'))
            ->setCellValue('B6', Yii::t('app','Full working - day'))
            ->setCellValue('B7',  Yii::t('app','Working - day'))
            ->setCellValue('B8', Yii::t('app','Leave of absence'))
            ->setCellValue('B9',  Yii::t('app','Absent or late without leave'))
            ->setCellValue('B10', Yii::t('app','Overtime'))
            ->setCellValue('B11', Yii::t('app','Agreed salary') )
            ->setCellValue('B12', Yii::t('app','USD Rate'))
            ->setCellValue('B13', Yii::t('app','Total amount of time'))
            ->setCellValue('B14',  Yii::t('app','Basic Salary') )
            ->setCellValue('B15', Yii::t('app','Salary of Project'))
            ->setCellValue('B16', Yii::t('app','Allowances'))
            ->setCellValue('B17', Yii::t('app','Reward') )
            ->setCellValue('B18', Yii::t('app','Work over time'))
            ->setCellValue('B19', Yii::t('app','Decrease salary'))
            ->setCellValue('B20', Yii::t('app','Other deductions') )
            ->setCellValue('B21', Yii::t('app','Receivable'))
            ->setCellValue('B22',  Yii::t('app','Insurance deduction(10.5% Basic salary)') )
            ->setCellValue('B23',  Yii::t('app','Tax deduction'))
            ->setCellValue('B24',  Yii::t('app','Actual receive') )
            ->setCellValue('B28', 'Hanoi, '.$date['mday'].'/'.$date['mon'].'/'.$date['year'])
            ->setCellValue('B31', Yii::t('app','Director').'                                        '.Yii::t('app','Accountant').'                                        '.Yii::t('app','Recipient'));

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C5', '')
            ->setCellValue('C6', '')
            ->setCellValue('C7', '')
            ->setCellValue('C8', $salary['leaveOfAbsence'])
            ->setCellValue('C9', $salary['late'])
            ->setCellValue('C10', $salary['overtime'])
            ->setCellValue('C11', $user['basicSalary'])
            ->setCellValue('C12', USD)
            ->setCellValue('C13',  $user['basicSalary'] * (int)USD .',000')
            ->setCellValue('C14', '')
            ->setCellValue('C15', '')
            ->setCellValue('C16', $salary['totalBonus'].',000')
            ->setCellValue('C17', '')
            ->setCellValue('C18', $salary['salaryOver'] )
            ->setCellValue('C19', '')
            ->setCellValue('C20', '')
            ->setCellValue('C21', '')
            ->setCellValue('C22', '')
            ->setCellValue('C23', '')
            ->setCellValue('C24', round($salary['salary'] * (int)USD * (1 - $salary['late'] / ($numDayOfMonth * 8 * 60) ) + $salary['totalBonus']).',000');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D5', Yii::t('app','Note'))
            ->setCellValue('D6', '')
            ->setCellValue('D7', '')
            ->setCellValue('D8', Yii::t('app','minutes') )
            ->setCellValue('D9', Yii::t('app','minutes'))
            ->setCellValue('D10', Yii::t('app','minutes'))
            ->setCellValue('D11', 'USD')
            ->setCellValue('D12', 'VND')
            ->setCellValue('D13', 'VND')
            ->setCellValue('D14', '')
            ->setCellValue('D15', '')
            ->setCellValue('D16', 'VND')
            ->setCellValue('D17', '')
            ->setCellValue('D18', 'USD')
            ->setCellValue('D19', '')
            ->setCellValue('D20', '')
            ->setCellValue('D21', '')
            ->setCellValue('D22', '')
            ->setCellValue('D23', '')
            ->setCellValue('D24', 'VND');

// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Salary');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='".$month.'_'.$year.'_'.$user['fullname'].".xls'");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($pathSave);
//        Yii::app()->end();
    }

    public function sendMail($email, $user, $month, $year)
    {
        $modelMail = new MailCompanyModel();
        $emailModel = $modelMail->getMail();
        if($emailModel != false){
            $emailCompany = $emailModel['email'];
            $passCompany = $emailModel['password'];
        } else {
            $emailCompany = Yii::app()->params['adminEmail'];
            $passCompany = Yii::app()->params['password'];
        }
        $mail = new YiiMailer();
        $mail->setFrom($emailCompany, CHtml::encode(Yii::app()->name));
        $mail->setTo($email);
        $mail->setSubject('Mail subject');
        $mail->setBody('Simple message');
        $mail->setAttachment("download/salary/".$month.'_'.$year.'_'.$user['fullname'].".xls");
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $emailCompany;
        $mail->Password = $passCompany;
//        $mail->send();
        if ($mail->send()) {
          return 1;
        } else {
          return 0;
        }
    }

    public function showIndex($arrayUser, $from , $to)
    {
        $arrayFrom = explode('-',$from);
        $arrayTo   = explode('-',$to);
        $numArrayUser = count($arrayUser);
        $array2 = array();
        for($i = $arrayFrom[1];$i <= $arrayTo[1]; $i++){
            $array1 = array();
            for($j = 0;$j < $numArrayUser; $j++){
                $arrayTemp = explode('-',$arrayUser[$j]['date']);
                $montemp = $arrayTemp[1];
                if((int)$montemp == (int)$i){
                   array_push($array1,$arrayUser[$j]);
                }
            }
            array_push($array2,$array1);
        }
        return $array2;
    }

    //Only show month and day .Ex: 3/1, 25/2
    public function monday($date)
    {
        $array = explode('-',$date);
        $mon = $array[1];
        $day = $array[2];
        return $day.'/'.$mon;
    }

    /*----------------------------------------------- Thom --------  */

}
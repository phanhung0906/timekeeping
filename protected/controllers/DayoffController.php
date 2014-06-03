<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/13/14
 * Time: 11:25 AM
 * To change this template use File | Settings | File Templates.
 */

class DayoffController extends Controller
{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'leader' || $this->getSessionRole() == 'admin' || $this->getSessionRole() == 'director') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        return $this->redirect('http://'.ROOT_URL.'/dayoff/'.$this->getSessionRole());
    }

    public function actionList()
    {
        if(isset($_GET['ur'])){
            switch($_GET['ur']){
                case 'admin':
                    if($this->getSessionRole() == 'admin'){
                        $userModel = new UserModel();
                        if(isset($_POST['submit'])){
                            $search = $_POST['search'];
                            $user   = $userModel->searchUser($search);
                            return $this->render('list',array('user' => $user));
                        }
                        $user = $userModel->listUser();
                        return $this->render('list', array('user' => $user));
                    } else return $this->redirect('http://'.ROOT_URL);
                case 'leader':
                    if($this->getSessionRole() == 'leader'){
                        $session = Yii::app()->session['user'];
                        $leaderModel = new LeaderModel();
                        $sessionUse  = $this->getSessionUser();
                        if(isset($_POST['submit'])){
                            $search = $_POST['search'];
                            $user   = $leaderModel->searchUser($session,$search);
                            return $this->render('index',array('user' => $user));
                        }
                        $user        = $leaderModel->listUser($sessionUse);
                        return $this->render('list',array('user' => $user));
                    } else return $this->redirect('http://'.ROOT_URL);
                case 'director':
                    if($this->getSessionRole() == 'director'){
                        $userModel = new UserModel();
                        if(isset($_POST['submit'])){
                            $search = $_POST['search'];
                            $user   = $userModel->searchUser($search);
                            return $this->render('index',array('user' => $user));
                        }
                        $user        = $userModel->listUser();
                        return $this->render('list',array('user' => $user));
                    } else return $this->redirect('http://'.ROOT_URL);
            }
        }
    }

    public function actionRegist()
    {
        $modelOff = new AllowOffModel();
        $session = $this->getSessionUser();
        if(isset($_POST['id'])){
            $day         = $_POST['day'];
            $id          = $_POST['id'];
            $hoursFrom   = $_POST['hoursFrom'];
            $minutesFrom = $_POST['minutesFrom'];
            $hoursTo     = $_POST['hoursTo'];
            $minutesTo   = $_POST['minutesTo'];
            $reason      = $_POST['reason'];
            $check = $modelOff->checkDayOff($hoursFrom, $minutesFrom, $hoursTo, $minutesTo);
            if($check){
                //save DB
                $fromOff = $hoursFrom.':'.$minutesFrom;
                $toOff   = $hoursTo.':'.$minutesTo;
                // return minutes
                $settingModel = new SettingModel();
                $result = $settingModel->getTime();
                $fromTime =  $hoursFrom*60 + $minutesFrom;
                $toTime   = $hoursTo*60 + $minutesTo;
                $breakFrom = $result['hoursFrom']*60 + $result['minutesFrom'];
                $breakTo = $result['hoursTo']*60 + $result['minutesTo'];
                if($fromTime <= $breakFrom && $toTime >= $breakTo){
                    $minuteOff  = (int)$hoursTo*60 + (int)$minutesTo - (int)$hoursFrom*60 - (int)$minutesFrom - ($breakTo - $breakFrom);
                } else {
                    $minuteOff  = (int)$hoursTo*60 + (int)$minutesTo - (int)$hoursFrom*60 - (int)$minutesFrom;
                }
                $response   = $modelOff->dayOff($session, $id, $day, $minuteOff , $fromOff, $toOff, $reason); //save to DB
                if($response){
                    // save DB success
                    echo 2;
                    return;
                } else {
                    // have value same
                    echo 3;
                    return;
                }
            } else {
                // time post false
                echo 1;
                return;
            }
        }
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionAdmin()
    {
        $model = new UserModel();
        $modelOff = new AllowOffModel();
        $session = $this->getSessionUser();
        // Set up day off for staff
        if (isset($_GET['id'])) {
//            if (isset($_POST['submit'])) {
//                $user_id    = $_GET['id'];
//                $day        = $_POST['day'];
//                $minuteOff   = (int)$_POST['hourOff']*60 + (int)$_POST['minuteOff'];
//                $response   = $modelOff->dayOff($session, $user_id, $day, $minuteOff); //save to DB
//                $user = $model->findUserId($user_id);
//                if($response){
//                    return $this->redirect('http://'.ROOT_URL.'/dayoff');
//                }
//                Yii::app()->admin->setFlash('success', 'error');
//                return $this->render('allowOff', array('user' => $user));
//            }
            $user_id  = $_GET['id'];
            $user = $model->findUserId($user_id);
            if($user['username'] == 'admin')  return $this->redirect('http://'.ROOT_URL);
            return $this->render('allowOff', array('user' => $user));
        }
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOff->searchUser($search);
            return $this->render('index', array('user' => $user));
        }
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                $data = $this->chooseDate($_POST['from'], $_POST['to']);
            }
        } else {
                $data = $this->chooseDate($day['from'], $day['to']);
        }
        $user = $modelOff->chooseDate($data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionLeader()
    {
        $model = new UserModel();
        $modelOff = new AllowOffModel();
        // Set up day off for staff
        if(isset($_GET['id'])){
            //Check user is in group or not
            $session = $this->getSessionUser();
            if($modelOff->checkUserGroup($session, $_GET['id']) == false){
                return $this->redirect('http://'.ROOT_URL);
            }
//            if(isset($_POST['submit'])){
//                $user_id    = $_GET['id'];
//                $day        = $_POST['day'];
//                $minuteOff   = (int)$_POST['hourOff']*60 + (int)$_POST['minuteOff'];
//                $response   = $modelOff->dayOff($session, $user_id, $day, $minuteOff); //save to DB
//                $user = $model->findUserId($user_id);
//                if($response){
//                    return $this->redirect('http://'.ROOT_URL.'/dayoff');
//                }
//                Yii::app()->admin->setFlash('success', "error");
//                return $this->render('allowOff', array('user' => $user));
//            }
            $user_id  = $_GET['id'];
            $user = $model->findUserId($user_id);
            return $this->render('allowOff', array('user' => $user));
        }
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOff->searchUser($search);
            return $this->render('index', array('user' => $user));
        }
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                $data = $this->chooseDate($_POST['from'], $_POST['to']);
            }
        } else {
            $data = $this->chooseDate($day['from'], $day['to']);
        }
        $session = $this->getSessionUser();
        $user = $modelOff->chooseDateLeader($session, $data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionDirector()
    {
        $model = new UserModel();
        $modelOff = new AllowOffModel();
        $session = $this->getSessionUser();
        // Set up day off for staff
        if(isset($_GET['id'])){
//            if(isset($_POST['submit'])){
//                $user_id    = $_GET['id'];
//                $day        = $_POST['day'];
//                $minuteOff   = (int)$_POST['hourOff']*60 + (int)$_POST['minuteOff'];
//                $response   = $modelOff->dayOff($session, $user_id, $day, $minuteOff); //save to DB
//                $user = $model->findUserId($user_id);
//                if($response){
//                    return $this->redirect('http://'.ROOT_URL.'/dayoff');
//                }
//                Yii::app()->admin->setFlash('success', 'error');
//                return $this->render('allowOff', array('user' => $user));
//            }
            $user_id  = $_GET['id'];
            $user = $model->findUserId($user_id);
            return $this->render('allowOff', array('user' => $user));
        }
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOff->searchUser($search);
            return $this->render('index', array('user' => $user));
        }
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                $data = $this->chooseDate($_POST['from'], $_POST['to']);
            }
        } else {
            $data = $this->chooseDate($day['from'], $day['to']);
        }
        $user = $modelOff->chooseDate($data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionDeleteOff()
    {
        $model = new AllowOffModel();
        if(isset($_POST['id'])){
            $id         = $_POST['id'];
            $response   = $model->deleteUser($id);
            echo $response;
            return;
        }
        return $this->redirect('http://'.ROOT_URL);
    }
}
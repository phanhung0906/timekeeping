<?php

class TimekeepingController extends Controller
{
    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'leader' || $this->getSessionRole() == 'admin' || $this->getSessionRole() == 'director'|| $this->getSessionRole() == 'user') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        $this->redirect('http://'.ROOT_URL.'/timekeeping/'.Yii::app()->session['role']);
    }

    public function actionUser()
    {
        if(Yii::app()->session['role'] != 'user') return $this->redirect('http://'.ROOT_URL."/timekeeping");
        $session = Yii::app()->session['user'];
        $model = new TimeKeepingModel();
        $modelUser = new UserModel();
        $profile = $modelUser->findUserSession($session);
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
        $user = $model->chooseDateUser($session, $data['from'], $data['to']);

        $array_time = $this->getArrayTime($user);
        $array_num = $this->numTime($array_time , $user, $data['from'], $data['to']);
        return $this->render('user', array('profile'=>$profile,'user' => $user, 'time' => $array_time, 'num' => $array_num, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionLeader()
    {
        if(Yii::app()->session['role'] != 'leader') return $this->redirect('http://'.ROOT_URL."/timekeeping");
        $session = Yii::app()->session['user'];
        $model = new TimeKeepingModel();
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                if($this->getNumDayFromTo($_POST['from'], $_POST['to'])){
                    $data = $this->chooseDate($_POST['from'], $_POST['to']);
                } else {
                    if(isset($_GET['staff'])){
                        Yii::app()->admin->setFlash('error', "false");
                        return $this->render('groupStaff', array('user' => array(), 'time' => '', 'leader' => array(), 'time2' => '','num'=>''));
                    } else {
                        Yii::app()->admin->setFlash('error', "false");
                        return $this->render('leader', array('user' => array(), 'time' => '', 'num'=>''));
                    }
                }

            }
        } else {
            $data = $this->chooseDate($day['from'], $day['to']);
        }
        // For leader
        $user = $model->chooseDateUser($session, $data['from'], $data['to']);
        $array_time = $this->getArrayTime($user);
        $array_num = $this->numTime($array_time, $user,$data['from'], $data['to'] );
        // For staff in group of leader
        if(isset($_GET['staff'])){
            $leader = $model->chooseDateLeader($session, $data['from'], $data['to']);
            $array_time2 = $this->getArrayTime($leader);
            //Search
            if(isset($_POST['search'])){
                $post = $_POST['search'];
                $leader = $model->leaderSearch($session,$post,$data['from'],$data['to']);
                $array_time = $this->getArrayTime($leader);
                return $this->render('groupStaff', array('user' => $user, 'time' => $array_time,'leader' => $leader, 'time2' => $array_time2, 'from' => $data['f'], 'to'=>$data['t'],'num'=>$array_num));
            }
            return $this->render('groupStaff', array('user' => $user, 'time' => $array_time, 'leader' => $leader, 'time2' => $array_time2, 'from' => $data['f'], 'to' => $data['t'], 'num'=>$array_num));
        }
        return $this->render('leader', array('user' => $user, 'time' => $array_time, 'from' => $data['f'], 'to' => $data['t'],'num'=>$array_num));
    }

    public function actionDirector()
    {
        if(Yii::app()->session['role'] != 'director') return $this->redirect('http://'.ROOT_URL.'/timekeeping');
        $session = Yii::app()->session['user'];
        $model = new TimeKeepingModel();
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                //Check max day from to is 2 month
                if($this->getNumDayFromTo($_POST['from'], $_POST['to'])){
                    $data = $this->chooseDate($_POST['from'], $_POST['to']);
                } else {
                    if(isset($_GET['staff'])){
                        Yii::app()->admin->setFlash('error', "false");
                        return $this->render('groupStaff', array('user' => array(), 'time' => '', 'leader' => array(), 'time2' => '', 'num'=>''));
                    } else {
                        Yii::app()->admin->setFlash('error', "false");
                        return $this->render('leader', array('user' => array(), 'time' => '', 'num'=>''));
                    }
                }
            }
        } else {
            $data = $this->chooseDate($day['from'], $day['to']);
        }
        // For leader
        $user = $model->chooseDateUser($session, $data['from'], $data['to']);
        $array_time = $this->getArrayTime($user);
        $array_num = $this->numTime($array_time, $user, $data['from'], $data['to']);
        // For staff in group of leader
        if(isset($_GET['staff'])){
            $leader = $model->chooseDate($data['from'], $data['to']);
            $array_time2 = $this->getArrayTime($leader);
            //Search
            if(isset($_POST['search'])){
                $post = $_POST['search'];
                $leader = $model->directorSearch($post,$data['from'],$data['to']);
                $array_time = $this->getArrayTime($leader);
                return $this->render('groupStaff', array('user' => $user, 'time' => $array_time,'leader' => $leader, 'time2' => $array_time2, 'from' => $data['f'], 'to'=>$data['t'],'num'=>$array_num));
            }
            return $this->render('groupStaff', array('user' => $user, 'time' => $array_time, 'leader' => $leader, 'time2' => $array_time2, 'from' => $data['f'], 'to'=>$data['t'],'num'=>$array_num));
        }
        return $this->render('leader', array('user' => $user, 'time' => $array_time, 'from' => $data['f'], 'to'=>$data['t'],'num'=>$array_num));
    }

    public function actionAdmin()
    {
        if(Yii::app()->session['role'] != 'admin') return $this->redirect('http://'.ROOT_URL.'/timekeeping');
        $model = new TimeKeepingModel();
        $modelUser = new UserModel();
        //Show detail User
        if(isset($_GET['user'])){
            $profile = $modelUser->findUserSession($_GET['user']);
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
            $user = $model->chooseDateUser($_GET['user'], $data['from'], $data['to']);
            $array_time = $this->getArrayTime($user);
            $array_num = $this->numTime($array_time , $user, $data['from'], $data['to']);
            return $this->render('user', array('profile'=>$profile,'user' => $user, 'time' => $array_time, 'num' => $array_num, 'from' => $data['f'], 'to' => $data['t']));
        }
        //Search
        if(isset($_POST['search'])){
            $post = $_POST['search'];
            $user = $model->timeSearchUser($post);
            $array_time = $this->getArrayTime($user);
            return $this->render('admin', array('user' => $user, 'time' => $array_time));
        }
        //Choose Date
        $day = $this->getDate();
        if(isset($_POST['from'])){
            if(($_POST['from'] == null) or ($_POST['to'] == null)){
                $data = $this->chooseDate($day['from'], $day['to']);
            } else {
                if($this->getNumDayFromTo($_POST['from'], $_POST['to'])){
                    $data = $this->chooseDate($_POST['from'], $_POST['to']);
                } else {
                    Yii::app()->admin->setFlash('error', "false");
                    return $this->render('admin', array('user' => array(), 'time' => ''));
                }
            }
        } else {
            $data = $this->chooseDate($day['from'], $day['to']);
        }
        $user = $model->chooseDate($data['from'], $data['to']);
        $array_time = $this->getArrayTime($user);
        return $this->render('admin', array('user' => $user, 'time' => $array_time, 'from' => $data['f'], 'to' => $data['t']));
    }
}
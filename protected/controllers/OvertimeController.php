<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/13/14
 * Time: 2:37 PM
 * To change this template use File | Settings | File Templates.
 */

class OvertimeController extends Controller{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'leader' || $this->getSessionRole() == 'admin' || $this->getSessionRole() == 'director') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        return $this->redirect('http://'.ROOT_URL.'/overtime/'.$this->getSessionRole());
    }

    public function actionAdmin()
    {
        $model = new UserModel();
        $modelOver = new OvertimeModel();
        $user = $model->listUser();
        $session =  $this->getSessionUser();
        // Set up day off for staff
        if(isset($_GET['register'])){
            if(isset($_POST['date']) && !isset($_POST['check'])){ // Check have to choose at least 1 user
                Yii::app()->admin->setFlash('error', "false");
                return $this->render('register', array('user' => $user));
            } else if(isset($_POST['date']) && isset($_POST['check'])) { //OK
                $date = $_POST['date'];
                $arrayUserId = $_POST['check'];
                $response   = $modelOver->dayOver($session, $arrayUserId, $date);
//                if($response){
                    return $this->redirect('http://'.ROOT_URL.'/overtime');
//                }
                return $this->render('register', array('user' => $user));
            }
            return $this->render('register',array('user' => $user));
        }
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOver->searchUser($search);
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
        $user = $modelOver->chooseDate($data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionLeader()
    {
        $model = new UserModel();
        $modelOver = new OvertimeModel();
        $session =  $this->getSessionUser();
        // Set up day off for staff
        if(isset($_GET['register'])){
            $leaderModel = new LeaderModel();
            $sessionUse  = $this->getSessionUser();
            $user        = $leaderModel->listUser($sessionUse);
            if(isset($_POST['date']) && !isset($_POST['check'])){
                Yii::app()->admin->setFlash('error', "false");
                return $this->render('register', array('user' => $user));
            } else if(isset($_POST['date']) && isset($_POST['check'])) {
                $date = $_POST['date'];
                $arrayUserId = $_POST['check'];
                $response   = $modelOver->dayOver($session, $arrayUserId, $date);
                if($response){
                    return $this->redirect('http://'.ROOT_URL.'/overtime');
                }
                return $this->render('register', array('user' => $user));
            }
            return $this->render('register',array('user' => $user));
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
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOver->leaderSearch($session,$search, $data['from'], $data['to']);
            return $this->render('index', array('user' => $user,'from' => $data['f'],'to'=>$data['t']));
        }
        $session = $this->getSessionUser();
        $user = $modelOver->chooseDateLeader($session, $data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionDirector()
    {
        $model = new UserModel();
        $modelOver = new OvertimeModel();
        $session =  $this->getSessionUser();
        // Set up day off for staff
        if(isset($_GET['register'])){
            $user = $model->listUser();
            if(isset($_POST['date']) && !isset($_POST['check'])){
                Yii::app()->admin->setFlash('error', "false");
                return $this->render('register', array('user' => $user));
            } else if(isset($_POST['date']) && isset($_POST['check'])) {
                $date = $_POST['date'];
                $arrayUserId = $_POST['check'];
                $response   = $modelOver->dayOver($session,$arrayUserId, $date);
                if($response){
                    return $this->redirect('http://'.ROOT_URL.'/overtime');
                }
                return $this->render('register', array('user' => $user));
            }
            return $this->render('register',array('user' => $user));
        }
        //Search
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $user   = $modelOver->searchUser($search);
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
        $user = $modelOver->chooseDate($data['from'], $data['to']);
        return $this->render('index', array('user' => $user, 'from' => $data['f'],'to'=>$data['t']));
    }

    public function actionDelete()
    {
        $model = new OvertimeModel();
        if(isset($_POST['id'])){
            $id         = $_POST['id'];
            $response   = $model->deleteUser($id);
            echo $response;
            return;
        }
        return $this->redirect('http://'.ROOT_URL);
    }
}
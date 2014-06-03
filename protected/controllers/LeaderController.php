<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/7/14
 * Time: 9:30 AM
 * To change this template use File | Settings | File Templates.
 */

class LeaderController extends Controller{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'leader') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        $session = Yii::app()->session['user'];
        $leaderModel = new LeaderModel();
        $sessionUse  = $this->getSessionUser();
        if(isset($_POST['submit'])){
            $search = $_POST['search'];
            $user   = $leaderModel->searchUser($session,$search);
            return $this->render('index',array('user' => $user));
        }
        $user        = $leaderModel->listUser($sessionUse);
        return $this->render('index',array('user' => $user));
    }


}
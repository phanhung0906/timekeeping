<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/7/14
 * Time: 10:52 AM
 * To change this template use File | Settings | File Templates.
 */

class DirectorController extends Controller
{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'director') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        $userModel = new UserModel();
        if(isset($_POST['submit'])){
            $search = $_POST['search'];
            $user   = $userModel->searchUser($search);
            return $this->render('index',array('user' => $user));
        }
        $user        = $userModel->listUser();
        return $this->render('index',array('user' => $user));
    }
}
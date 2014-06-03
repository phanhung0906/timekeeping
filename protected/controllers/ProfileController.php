<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 4/3/14
 * Time: 8:39 PM
 * To change this template use File | Settings | File Templates.
 */

class ProfileController extends Controller{

    public function actionIndex()
    {
        $this->checkSession();
        $model       = new UserModel();
        $session     = $this->getSessionUser();
        $user        = $model->findUserSession($session);
        return $this->render('index', array('user' => $user));
    }

    public function actionEdit()
    {
        $this->checkSession();
        $model      = new UserModel();
        $session    = Yii::app()->session['user'];
        $user       = $model->findUserSession($session);
        if(isset($_POST['submit']))
        {
            $username   = $_POST['username'];
            $fullName   = $_POST['fullname'];
            $email      = $_POST['email'];
            $address    = $_POST['address'];
            $phone      = $_POST['phone'];
            $position   = $_POST['position'];
            $birthday   = $_POST['birthday'];
            $sex        = $_POST['sex'];
            $response   = $model->saveUserProfile($session, $username, $fullName, $email, $address, $phone, $position, $birthday, $sex);
            switch($response){
                case (UserModel::ERROR_NAME_USER):
                    Yii::app()->admin->setFlash('error', "true");
                    return $this->render('profile', array('user' => $user));
                    break;
                case (UserModel::SUCCESS):
                    Yii::app()->admin->setFlash('success', "true");
                    Yii::app()->session['user'] = $username;
                    $updateUser = $model->findUserSession($username);
                    return  $this->render('profile', array('user' => $updateUser));
                    break;
                default:
                    break;
            }
        }
        return $this->render('profile',array('user' => $user,'error' => ''));
    }

    public function actionChangePassword()
    {
        $this->checkSession();
        $userModel = new UserModel();
        if (isset($_POST['signin'])) {
            $oldpass  = $_POST['oldpass'];
            $newpass  = $_POST['newpass'];
            $user     = $this->getSessionUser();
            $response = $userModel->changepassword($oldpass, $newpass, $user);

            if ($response != 0) {
                Yii::app()->admin->setFlash('success', "true");
                return $this->render('changePassword');
            } else{
                Yii::app()->admin->setFlash('error', "true");
                return $this->render('changePassword');
            }
        }
        $this->render('changePassword',array(
            'error' =>''));
    }

}
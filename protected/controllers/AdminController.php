<?php

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'admin') return true;
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
        $user = $userModel->listUser();
        return $this->render('index',array('user' => $user));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', $error);
        }
    }

    public function actionAdd()
    {
        $model = new UserModel();
        if(isset($_POST['username']))
        {
            $username   = $_POST['username'];
            $fullName   = $_POST['fullname'];
            $passwd     = $_POST['password'];
            $email      = $_POST['email'];
            $group      = $_POST['group'];
            $address    = $_POST['address'];
            $phone      = $_POST['phone'];
            $position   = $_POST['position'];
            $birthday   = $_POST['birthday'];
            $sex        = $_POST['sex'];
            $role       = $_POST['role'];
            $salary     = $_POST['salary'];
            $id_number  = $_POST['id_number'];
            $response   = $model->addUser($username, $fullName, $passwd, $email, $group, $address, $phone, $position, $birthday, $sex, $role, $salary, $id_number);
            switch($response){
                case (UserModel::ERROR_EXIST_USER):
                    Yii::app()->admin->setFlash('error1', "true");
                    return $this->render('add');
                    break;
                case (UserModel::ERROR_NAME_USER):
                    Yii::app()->admin->setFlash('error2', "true");
                    return $this->render('add');
                    break;
                case (UserModel::SUCCESS):
                    Yii::app()->admin->setFlash('error3', "true");
                    return  $this->render('add');
                    break;
                default:
                    break;
            }
        }
        return $this->render('add');
    }

    public function actionEdit()
    {
        $model = new UserModel();
        if(isset($_GET['id'])){
            if(isset($_POST['submit']))
            {
                $user_id    = $_GET['id'];
                $fullname   = $_POST['fullname'];
                $position   = $_POST['position'];
                $role       = $_POST['role'];
                $salary     = $_POST['salary'];
                $group      = $_POST['group'];
                $response   = $model->editUser($user_id, $fullname, $position, $role, $salary, $group);
                $user = $model->findUserId($user_id);
                if($response != 0){
                    Yii::app()->admin->setFlash('success', "true");
                    return $this->render('edit',array('user' => $user));
                } else {
                    Yii::app()->admin->setFlash('error', "true");
                    return $this->render('edit',array('user' => $user));
                }
            }
            $user_id  = $_GET['id'];
            $response = $model->findUserId($user_id);
            return $this->render('edit', array('user' => $response));
        }
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionDelete()
    {
        $model = new UserModel();
        if(isset($_POST['user_id'])){
            $user_id    = $_POST['user_id'];
            $response   = $model->deleteUser($user_id);
            echo $response;
            return;
        }
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionSendMail()
    {
        $modelMail = new MailModel();
       if(isset($_POST['arrayUser'])){
          $month = $_POST['month'];
          $year  = $_POST['year'];
          $arrayUser = json_decode($_POST['arrayUser']);
          $numArrayUser = count($arrayUser);
          for($i = 0; $i < $numArrayUser; $i++){
               $modelMail->sendMail($arrayUser[$i], $month, $year);
          }
           echo 1;return;
       }
       return $this->redirect('http://'.ROOT_URL);
    }

}
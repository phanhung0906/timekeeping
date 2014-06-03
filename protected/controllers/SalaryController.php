<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/16/14
 * Time: 11:02 PM
 * To change this template use File | Settings | File Templates.
 */

class SalaryController extends Controller{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() != null) return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        return $this->redirect('http://'.ROOT_URL.'/salary/'.$this->getSessionRole());
    }

    public function actionAdmin()
    {
        $modelUser = new UserModel();
        $user = $modelUser->listUser();

        if(isset($_GET['id'])){
            //Choose month
            $date = getdate();
            if(isset($_POST['month'])){
                $month = $_POST['month'];
                $year  = $_POST['year'];
                Yii::app()->session['salaryMonth'] = $month;
                Yii::app()->session['salaryYear'] = $year;
            } else {
                $month = $date['mon'];
                if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
                $year  = $date['year'];
                if(!Yii::app()->session['salaryMonth'] && !Yii::app()->session['salaryYear']){
                    Yii::app()->session['salaryMonth'] = $month;
                    Yii::app()->session['salaryYear'] = $year;
                }
            }
            $user = $modelUser->findUserId($_GET['id']);
            $salary = $this->salary($user, Yii::app()->session['salaryMonth'],  Yii::app()->session['salaryYear']);
            //Download
            if(isset($_POST['download'])){
                $pathSave='php://output';
                $this->exportExcel($user, $salary,  Yii::app()->session['salaryMonth'],  Yii::app()->session['salaryYear'],$pathSave);
            }
            return $this->render('salary',array('user'=>$user, 'salary'=>$salary, 'month' => $month,'year'=>$year));
        }
        unset(Yii::app()->session['salaryMonth']);
        unset(Yii::app()->session['salaryYear']);
        return $this->render('admin',array('user'=>$user));
    }

    public function actionDirector()
    {
        $modelUser = new UserModel();
        $date = getdate();
        if(isset($_POST['month'])){
            $month = $_POST['month'];
            $year  = $_POST['year'];
            Yii::app()->session['salaryMonth'] = $month;
            Yii::app()->session['salaryYear'] = $year;
        } else {
            $month = $date['mon'];
            if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
            $year  = $date['year'];
            if(!Yii::app()->session['salaryMonth'] && !Yii::app()->session['salaryYear']){
                Yii::app()->session['salaryMonth'] = $month;
                Yii::app()->session['salaryYear'] = $year;
            }
        }
        $session = $this->getSessionUser();
        $user = $modelUser->findUserSession($session);
        $salary = $this->salary($user, Yii::app()->session['salaryMonth'], Yii::app()->session['salaryYear']);
        //Download
        if(isset($_POST['download'])){
            $pathSave='php://output';
            $this->exportExcel($user,$salary,Yii::app()->session['salaryMonth'], Yii::app()->session['salaryYear'],$pathSave);
        }
        return $this->render('salary',array('user'=>$user,'salary'=>$salary,'month' => $month, 'year' => $year));
    }

    public function actionLeader()
    {
        $modelUser = new UserModel();
        $date = getdate();
        if(isset($_POST['month'])){
            $month = $_POST['month'];
            $year  = $_POST['year'];
            Yii::app()->session['salaryMonth'] = $month;
            Yii::app()->session['salaryYear'] = $year;
        } else {
            $month = $date['mon'];
            if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
            $year  = $date['year'];
            if(!Yii::app()->session['salaryMonth'] && !Yii::app()->session['salaryYear']){
                Yii::app()->session['salaryMonth'] = $month;
                Yii::app()->session['salaryYear'] = $year;
            }
        }
        $session = $this->getSessionUser();
        $user = $modelUser->findUserSession($session);
        $salary = $this->salary($user, Yii::app()->session['salaryMonth'], Yii::app()->session['salaryYear']);
        //Download
        if(isset($_POST['download'])){
            $pathSave='php://output';
            $this->exportExcel($user,$salary, Yii::app()->session['salaryMonth'] , Yii::app()->session['salaryYear'],$pathSave);
        }
        return $this->render('salary',array('user' => $user, 'salary'=>$salary, 'month' => $month,'year'=>$year));
    }

    public function actionUser()
    {
        $modelUser = new UserModel();
        $date = getdate();
        if(isset($_POST['month'])){
            $month = $_POST['month'];
            $year  = $_POST['year'];
        } else {
            $month = $date['mon'];
            if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
            $year  = $date['year'];
        }
        $session = $this->getSessionUser();
        $user = $modelUser->findUserSession($session);
        $salary = $this->salary($user, $month, $year);
        //Download
        if(isset($_POST['download'])){
            $pathSave='php://output';
            $this->exportExcel($user,$salary,$month, $year,$pathSave);
        }
        return $this->render('salary',array('user' => $user, 'salary'=>$salary, 'month' => $month,'year'=>$year));
    }

}
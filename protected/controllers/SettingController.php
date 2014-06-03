<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/1/14
 * Time: 10:37 AM
 * To change this template use File | Settings | File Templates.
 */

class SettingController extends Controller
{

    public function actionIndex()
    {
        $this->checkSession();
        if($this->getSessionRole() != 'admin') return $this->redirect('http://'.ROOT_URL);
        $model = new SettingModel();
        $currentBonus = $model->getBonus();
        $currentMail = $model->getMailCompany();
        $currentTime = $model->getTime();
        $timeIn  = $currentTime['hoursIn'].':'.$currentTime['minutesIn'];
        $timeOut = $currentTime['hoursOut'].':'.$currentTime['minutesOut'];
        $breakFrom = $currentTime['hoursFrom'].':'.$currentTime['minutesFrom'];
        $breakTo = $currentTime['hoursTo'].':'.$currentTime['minutesTo'];
        if(isset($_POST['bonus'])){
            $bonus = $_POST['bonus'];
            $response = $model->updateBonus($bonus);
            echo $response;return;
        }
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $response = $model->updateMailCompany($email,$password);
            echo $response;return;
        }
        if(isset($_POST['hoursIn'])){
            $hoursIn    = $_POST['hoursIn'];
            $minutesIn  =  $_POST['minutesIn'];
            $hoursOut   = $_POST['hoursOut'];
            $minutesOut = $_POST['minutesOut'];
            $hoursFrom  = $_POST['hoursFrom'];
            $minutesFrom= $_POST['minutesFrom'];
            $hoursTo    = $_POST['hoursTo'];
            $minutesTo   = $_POST['minutesTo'];
            if( ((int)$hoursIn*60 + (int)$minutesIn) >= ((int)$hoursOut*60 + (int)$minutesOut) ){
                echo 0;return;
            }
            if( ((int)$hoursFrom*60 + (int)$minutesFrom) >= ((int)$hoursTo*60 + (int)$minutesTo) ){
                echo 2;return;
            }
            if( (((int)$hoursFrom*60 + (int)$minutesFrom) < ((int)$hoursIn*60 + (int)$minutesIn))
                || (((int)$hoursFrom*60 + (int)$minutesFrom) > ((int)$hoursOut*60 + (int)$minutesOut))
                || (((int)$hoursTo*60 + (int)$minutesTo) > ((int)$hoursOut*60 + (int)$minutesOut))
                || (((int)$hoursTo*60 + (int)$minutesTo) < ((int)$hoursIn*60 + (int)$minutesIn))   ){
                echo 3;return;
            }
            $response = $model->settingTime($hoursIn,$minutesIn,$hoursOut,$minutesOut,$hoursFrom,$minutesFrom,$hoursTo,$minutesTo);
            echo $response;return;
        }
        return $this->render('index',array('timeIn' => $timeIn,'timeOut' => $timeOut,'breakFrom' => $breakFrom,'breakTo' => $breakTo, 'currentBonus'=>$currentBonus['bonus'],'currentMail'=>$currentMail['email']));
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

}
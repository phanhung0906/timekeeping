<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/20/14
 * Time: 1:18 PM
 * To change this template use File | Settings | File Templates.
 */

class UpdateController extends Controller{

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'admin') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        return $this->redirect('http://'.ROOT_URL.'/update/days');

    }

//    public function actionDay()
//    {
//        if(isset($_POST['date'])){
//            $date = $this->convertDate($_POST['date']);
//            $this->downAttlog($date, $date);
//            $this->updateDay();
//            echo 1; return;
//        }
//        return $this->render('day', array('notify'=>''));
//    }

    public function actionDays()
    {
        if(isset($_POST['from'])){
            if($_POST['from'] == '' || $_POST['to'] == ''){
                echo 3; return;
            }
            $from = $this->convertDate($_POST['from']);
            $to   = $this->convertDate($_POST['to']);
            if($this->getNumDayFromTo($_POST['from'], $_POST['to'])){
                if($this->downAttlog($from, $to) == 1 ){
                    echo 2;return;
                }
                $this->updateDays($from, $to);
                echo 1; return;
            } else {
                echo 4; return;
            }
        }
        return $this->render('days', array('notify'=>''));
    }

}
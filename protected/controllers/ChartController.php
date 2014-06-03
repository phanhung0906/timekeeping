<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 3/21/14
 * Time: 2:29 PM
 * To change this template use File | Settings | File Templates.
 */

class ChartController extends Controller {

    public function beforeAction($action)
    {
        $this->checkSession();
        if($this->getSessionRole() == 'admin' || $this->getSessionRole() == 'director') return true;
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionIndex()
    {
        //Choose month
       return $this->redirect('http://'.ROOT_URL.'/chart/month');
    }

    public function actionMonth()
    {
        $date = getdate();
        if(isset($_POST['month'])){
            $month = $_POST['month'];
            $year  = $_POST['year'];
        } else {
            $month = $date['mon'];
            if(strlen((string)$date['mon']) == 1) $month = '0'.$date['mon'];
            $year  = $date['year'];
        }
        $chart = $this->chart($month, $year);
        $statistic = $this->statistic($month, $year);
        return $this->render('month',array('month' => $month,'year' => $year, 'chart' => $chart,'statistic'=>$statistic));
    }

    public function actionYear()
    {
        $date = getdate();
        if(isset($_POST['year'])){
            $year  = $_POST['year'];
        } else {
            $year  = $date['year'];
        }
        $chart = $this->chartYear($year);
        $statistic = $this->statisticYear($year);
        return $this->render('year',array('year' => $year, 'chart' => $chart, 'statistic'=>$statistic));
    }
}
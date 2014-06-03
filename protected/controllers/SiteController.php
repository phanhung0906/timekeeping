<?php

class SiteController extends Controller
{

	public function actionIndex()
	{
        if (!isset(Yii::app()->session['user'])) {
            return $this->redirect('http://'.ROOT_URL.'/login');
        }
        if(!Yii::app()->session['language']) Yii::app()->session['language'] = 'vi';
        $modelUser       = new UserModel();
        $modelTime       = new TimeKeepingModel();
        $user        = $modelUser->listUser();
        $date = getdate();
        $currentDate = $date['year'].'-'.$date['mon'].'-'.$date['mday'];
        $arrayCurrentDate = $modelTime->showDate($currentDate);
        if (isset($_POST['user'])) {
            $id_number = $_POST['user'];
            $data = $this->chooseDate($_POST['from'], $_POST['to']);
            $from = $data['from'];
            $to = $data['to'];
            if(!$this->getNumDayFromTo($_POST['from'], $_POST['to'])){
                Yii::app()->user->setFlash('error', "false");
                return $this->render('index', array('user' => $user, 'arrayUser'=>$arrayCurrentDate,'from' => $_POST['from'], 'to'=> $_POST['to']));
            }
            // search user is all or not
            if($id_number == 'all'){
                $arrayUser = $modelTime->showIndex($from, $to);
                $arrayUser2 = $this->showIndex($arrayUser, $from, $to);
                return $this->render('index', array('user' => $user, 'arrayUser'=>$arrayUser2,'from' => $_POST['from'], 'to'=> $_POST['to']));
            } else {
                $arrayUser = $modelTime->showIndexId($id_number,$from,$to);
                $arrayUser2 = $this->showIndex($arrayUser, $from, $to);
                return $this->render('index', array('user' => $user, 'arrayUser'=>$arrayUser2,'from' => $_POST['from'], 'to'=> $_POST['to']));
            }
        }
        return $this->render('index', array('user' => $user, 'arrayUser'=>$arrayCurrentDate,'from' => $this->convertDate($currentDate), 'to'=> $this->convertDate($currentDate)));
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

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        if (isset(Yii::app()->session['user'])) {
            return $this->redirect('http://'.ROOT_URL);
        }
        $model = new UserModel();

		if(isset($_POST['user_name']))
		{
            $user       = $_POST['user_name'];
            $passwd     = $_POST['password'];
            $response   = $model->login($user,$passwd);
            if ($response == true) {
               Yii::app()->session['user'] = $user;
               $userInfo = $model->findUserSession($user);
               Yii::app()->session['role'] = $userInfo['role']; // save role to session to use later
               return $this->redirect('http://'.ROOT_URL);
            }
            Yii::app()->admin->setFlash('error', "true");
            return $this->renderPartial('login',array('user'=>$_POST['user_name']));
		}
		// display the login form
		$this->renderPartial('login',array('error'=>''));
	}

	/**
	 * Logs out the current admin and redirect to homepage.
	 */
	public function actionLogout()
	{
        Yii::app()->session->clear();
        return $this->redirect('http://'.ROOT_URL.'/login');
	}

    public function actionLanguage()
    {
        if(isset($_POST['lang'])){
            Yii::app()->session['language'] = $_POST['lang'];
            return;
        }
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionForgotPassword()
    {
        $modelMail = new MailCompanyModel();
        $emailModel = $modelMail->getMail();
        if($emailModel != false){
            $emailCompany = $emailModel['email'];
            $passCompany = $emailModel['password'];
        } else {
            $emailCompany = Yii::app()->params['adminEmail'];
            $passCompany = Yii::app()->params['password'];
        }
        $model = new UserModel();
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $list   = $model->forgotPassword($email);
            $link   = ROOT_URL.'/site/reset/email/'.$list['email'].'/token/'.$list['token'];
            $mail = new YiiMailer();
            $mail->setView('password');
            $mail->setData(array('link' => $link));
            $mail->setFrom($emailCompany, CHtml::encode(Yii::app()->name));
            $mail->setTo($email);
            $mail->setSubject('Reset Password');
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = $emailCompany;
            $mail->Password = $passCompany;
            if ($mail->send()) {
                Yii::app()->user->setFlash('notify','true');
                return $this->redirect('http://'.ROOT_URL.'/login');
            } else {
                Yii::app()->user->setFlash('emailfalse','true');
                return $this->redirect('http://'.ROOT_URL.'/login');
            }
        } else return $this->redirect('http://'.ROOT_URL.'/login');
    }

    public function actionReset()
    {
        $model = new UserModel();
        if(isset($_GET['email']) && $_GET['token']){
            if ( $model->checkToken($_GET['email'],$_GET['token'])){
                if(isset($_POST['newpass'])){
                    $credentials = array(
                        'password'              => $_POST['newpass'],
                        'password_confirmation' => $_POST['confirm']
                    );
                    if($model->resetPassword($_GET['email'], $_GET['token'], $credentials['password'])) {
                        return $this->redirect('http://'.ROOT_URL.'/login');
                    }
                    return $this->redirect('http://'.ROOT_URL.'/login');
                }
                return $this->renderPartial('email');
            } else return $this->redirect('http://'.ROOT_URL.'/login');
        } else return $this->redirect('http://'.ROOT_URL.'/login');
    }

    public function actionCronEmail()
    {
        $modelUser = new UserModel();
        $modelMail = new MailModel();
        $getUser = $modelMail->getUser();
        if(count($getUser) == 0) return 0;
        $numUser = count($getUser);
        for($i = 0; $i < $numUser; $i++){
            $user = $modelUser->findUserId($getUser[$i]['user_id']);
            $salary = $this->salary($user, $getUser[$i]['month'], $getUser[$i]['year']);
            $pathSave = ROOT_DIR.'/'.$getUser[$i]['month'].'_'.$getUser[$i]['year'].'_'.$user['fullname'].'.xls';
            $this->exportExcel($user,$salary,$getUser[$i]['month'], $getUser[$i]['year'], $pathSave);
            $result = $this->sendMail($getUser[$i]['email'], $user,$getUser[$i]['month'], $getUser[$i]['year']);
            if($result == 1){
                $modelMail->update($getUser[$i]['id']);
            }
        }
        return 1;
    }

    public function actionCronUpdate()
    {
        $date   = getdate();
        $mon = $date['mon'];
        $mday = $date['mday'];
        if(strlen((string)$date['mon']) == 1) $mon = '0'.$date['mon'];
        if(strlen((string)$date['mday']) == 1) $mday = '0'.$date['mday'];
        $day = $date['year'].'-'.$mon.'-'.$mday;
        if($this->downAttlog($day,$day) == 1 ){
            echo 2;return;
        }
        $this->updateDays($day, $day);
        echo 1; return;
    }
}
<?php


class PropertyController extends Controller
{


    public function actionIndex()
    {
        $model = new Property();
        if(isset($_POST['submit'])){
            $search = $_POST['search'];
            $pro   = $model->searchPro($search);
            return $this->render('index',array('pro' => $pro));
        }
        $pro = $model->pro();
        return $this->render('index',array('pro' => $pro));
    }

    public function actionCreate()
    {
        $model = new Property();
        if(isset($_POST['ok']))
        {
            $pro_name   = $_POST['pro_name'];
            $parameter  = $_POST['parameter'];
            $IMEI_serial= $_POST['IMEI_serial'];
            if ($pro_name != '') {
                if ($IMEI_serial != '') {
                        $response  = $model->pro_create($pro_name, $IMEI_serial, $parameter);
                        switch ($response) {
                            case (Property::ERROR_PRO):
                                return $this->render('create', array('error' => "
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Cảnh báo!</strong> Thiết bị này đã được tạo. Xin kiểm tra lại!
                                    </div>
                                     "));
                                break;
                            case (Property::SUCCESS):
                                /*return $this->render('create', array('error' => "
                                    <div class='alert alert-success'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Success!</strong> Property have been created successfully!
                                    </div>
                                    "));*/
                                return $this->redirect('http://'.ROOT_URL.'/property');
                                break;
                            
                            default:
                                
                                break;
                        }
                    
                    
                }
                return $this->render('create', array('error' => "
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Warning!</strong> Bạn phải nhập số serial . Please create again!
                                    </div>
                                     "));

            }
            return $this->render('create', array('error' => "
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Warning!</strong> Bạn phải nhập Tên thiết bị . Mời bạn tạo lại!
                                    </div>
                                     "));

            

        }
        return $this->render('create', array('error' => ''));
    }

    public function actionEdit()
    {
        $model = new Property();
        if(isset($_GET['id'])){
            if(isset($_POST['ok']))
            {
                $pro_id             = $_GET['id'];
                $pro_name           = $_POST['pro_name'];
                $parameter          = $_POST['parameter'];
                $IMEI_serial        = $_POST['IMEI_serial'];
                $response   = $model->editPro($pro_id, $pro_name, $IMEI_serial, $parameter);
                if($response != 0)
                {                   
                    $pro = $model->findProId($pro_id);
                    return $this->redirect('http://'.ROOT_URL.'/property');
               }
                $pro = $model->findProId($pro_id);
                return $this->render('edit',array('pro' => $pro, 'error' => "
                       <div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong>Error!</strong> Bạn không thay đổi gì!
                        </div>
                "));
            }
            $pro_id  = $_GET['id'];
            $response = $model->findProId($pro_id);
            return $this->render('edit', array('error' => '','pro' => $response));
        }
        return $this->redirect('/atmarkcafe');
        //$this->render('edit');
    }

    public function actionDelete()
    {
        $model = new Property();
        if(isset($_POST['pro_id'])){
            $pro_id    = $_POST['pro_id'];
            $response   = $model->deletePro($pro_id);
            return $this->redirect('http://'.ROOT_URL.'/property');
        }
        return $this->redirect('/atmarkcafe');
    }

    public function actionDetail()
    {
        $model = new Property();
        if (isset($_GET['id'])) {
            $pro_id  = $_GET['id'];
            //$pro = $model->detail($pro_id);
            $response = $model->findProId($pro_id);
            return $this->render('detail',array('pro' => $response));
        }
    }
    public function actionBorrow()
    {
        $model = new Property();
        if (isset($_GET['id'])) {
            if(isset($_POST['ok']))
            {
                $pro_id             = $_GET['id'];
                $property           = $_POST['property'];
                $borrowers          = $_POST['borrowers'];
                $b_time             = $_POST['b_time'];
                $r_time             = $_POST['r_time'];
                $b_date             = $_POST['b_date'];
                $r_date             = $_POST['r_date'];
                
                if($borrowers != '' &&  $b_date != '' && $r_date != '') {
                    
                        if ($r_date=$b_date) {
                            if ($b_time<=$r_time) {
                                if ($b_date>=date('yyyy-mm-dd')) {
                                    $response   = $model->borrow($pro_id, $borrowers, $b_time, $b_date, $r_time, $r_date);
                                    if ($response) {
                                        $pro = $model->findProId($pro_id);
                                        return $this->redirect('http://'.ROOT_URL.'/property');
                                    }
                                    $pro = $model->findProId($pro_id);
                                    return $this->render('borrow',array('pro' => $pro,   'error' => "
                                           <div class='alert alert-danger'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                <strong>Error!</strong>  Đã có người mượn!
                                            </div>
                                    ")); 
                                }
                                $pro = $model->findProId($pro_id);
                                return $this->render('borrow',array('pro' => $pro,   'error' => "
                                       <div class='alert alert-danger'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            <strong>Error!</strong>  borrow date < now
                                        </div>
                                ")); 
                            }
                            $pro = $model->findProId($pro_id);
                            return $this->render('borrow',array('pro' => $pro,    'error' => "
                                   <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Error!</strong>  borrow time > return time
                                    </div>
                            ")); 
                            
                        }
                        if ($r_date>$b_date) {
                            if ($b_date>=date('yyyy-mm-dd')) {
                                $response   = $model->borrow($pro_id, $property, $borrowers, $b_time, $b_date, $r_time, $r_date);
                                if ($response) {
                                    $pro = $model->findProId($pro_id);
                                    return $this->redirect('http://'.ROOT_URL.'/property');
                                }
                                $pro = $model->findProId($pro_id);
                                return $this->render('borrow',array('pro' => $pro,   'error' => "
                                       <div class='alert alert-danger'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            <strong>Error!</strong>  Đã có người mượn!
                                        </div>
                                ")); 
                            }
                            $pro = $model->findProId($pro_id);
                            return $this->render('borrow',array('pro' => $pro,    'error' => "
                                   <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Error!</strong>  borrow date < now
                                    </div>
                            ")); 
                        }
                        $pro = $model->findProId($pro_id);
                        return $this->render('borrow',array('pro' => $pro,   'error' => "
                               <div class='alert alert-danger'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <strong>Error!</strong>  borrow date >= return date
                                </div>
                        "));        
                                      
                    
                }
                $pro = $model->findProId($pro_id);
                return $this->render('borrow',array('pro' => $pro,     'error' => "
                        <div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong>Error!</strong>  Bạn không được bỏ trống các mục đánh dấu *
                        </div>
                "));                                 
            }
            $pro_id  = $_GET['id'];
            $response = $model->findProId($pro_id);
            return $this->render('borrow', array('error' => '',  'pro' => $response));
        }
        return $this->redirect('http://'.ROOT_URL);
    }

    public function actionReturnpro() {
        $model = new Property();
        if(isset($_GET['id'])){
            if(isset($_POST['ok']))
            {
                $pro_id=$_GET['id'];
                $pro_name = $_POST['property'];
                $response = $model->returnpro($pro_id);
                if($response != 0)
                {                   
                    $reBorrow = $model->findProId($pro_id);
                    return $this->redirect('http://'.ROOT_URL.'/property');
               }
                $reBorrow = $model->findProId($pro_id);
                return $this->render('returnpro',array('rb' => $reBorrow ,'error' => "
                       <div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong>Error!</strong> You haven't change infomation of this admin
                        </div>
                "));
            }
            $pro_id  = $_GET['id'];
            $response = $model->findProId($pro_id);
            return $this->render('returnpro', array('error'=>'',  'rb'=>$response));
        }
        return $this->redirect('/atmarkcafe');
        // $this->render('returnpro');
    }

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


     public function actionLstSendMail(){
        $model = new Property();
        $send = $model->lstSend();
        return $this->render('lstsendmail',array('send' => $send));
        //$this->render('lstsendmail');
    }

    public function actionSendmail()
    {
        //$modelUser = new UserModel();
        $modelMail = new Remind();
        if(isset($_POST['arrayUser'])){
          //$month = $_POST['month'];
          //$year  = $_POST['year'];
          $arrayUser = json_decode($_POST['arrayUser']);
          $numArrayUser = count($arrayUser);
          for($i = 0; $i < $numArrayUser; $i++){
               $modelMail->sendMail($arrayUser[$i]);
          }
           echo 1;return;
       }
       return $this->redirect('http://'.ROOT_URL);
    }
 

}
<?php

/**
 * UserIdentity represents the data needed to identity a admin.
 * It contains the authentication method that checks if the provided
 * data can identity the admin.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a admin.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent admin identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
//	public function authenticate()
//	{
//        $this->setState('roles', 'admin hung');
//
//		$users = array(
//			// username => password
//			'demo'  => 'demo',
//			'admin' => 'admin',
//		);
//		if(!isset($users[$this->username])) //check DB have admin or not
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password) //check password
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;       //check ok
//		return !$this->errorCode;
//	}

    public function authenticate()
    {
        $username = Yii::app()->session['admin'];
        $user = Yii::app()->db->createCommand()
        ->select('role')
        ->from('admin')
        ->where('username=:username', array(':username'=>$username))
        ->queryRow();
        $this->setState('roles', $user['role']);
//        $record = admin::model()->findByAttributes(array('username' => 'hung'));
//        if ($record===null)
//            $this->errorCode=self::ERROR_USERNAME_INVALID;
//        else if($record->password!==md5($this->password))
//            $this->errorCode=self::ERROR_PASSWORD_INVALID;
//        else
//        {
//            $this->id=$record->id;
//            $this->setState('roles', $record->role);
//            $this->errorCode=self::ERROR_NONE;
//        }
//        return !$this->errorCode;
    }

    public function getId(){
        return $this->id;
    }
}
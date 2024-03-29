<?php

class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a admin.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$password=Yii::app()->getController()->getModule()->password;
		if($password===null)
			throw new CException('Please configure the "password" property of the "gii" module.');
		elseif($password===false || $password===$this->password)
			$this->errorCode=self::ERROR_NONE;
        else
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		return !$this->errorCode;
	}
}
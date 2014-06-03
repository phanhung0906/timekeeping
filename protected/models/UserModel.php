<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * admin login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserModel extends CFormModel
{
    const ERROR_EXIST_USER = -1;
    const ERROR_NAME_USER = -2;
    const SUCCESS = -3;
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;


	/**
	 * Logs in the admin using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login($user, $passwd)
	{
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('username=:username and password=:password', array(':username'=>$user, ':password'=>md5($passwd)))
            ->queryRow();
        return ($command != false);
	}

    public function changepassword($oldpass, $newpass, $userName)
    {
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('username=:username', array(':username'=>$userName))
            ->queryRow();
        $result1  = $command;
        if (md5($oldpass) == $result1['password']) {
            $newpassmd5 = md5($newpass);
            $sql2     = "update user set password=:password where user_id= :user_id";
            $command2 = Yii::app()->db->createCommand($sql2);
            $command2->bindParam(":password",$newpassmd5,PDO::PARAM_STR);
            $command2->bindParam(":user_id",$result1['user_id'],PDO::PARAM_STR);
            return $command2->execute();
        }
        return 0;
    }

    public function listUser()
    {
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->queryAll();
        return $command;
    }

    public function findUserId($user_id)
    {
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('user_id=:user_id', array(':user_id'=>$user_id))
            ->queryRow();
        return $command;
    }

    public function findUserSession($username)
    {
        $user = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('username=:username', array(':username'=>$username))
            ->queryRow();
        return $user;
    }

    public function saveUserProfile($session, $username, $fullName, $email, $address, $phone, $position, $birthday, $sex)
    {
        if($session != $username){
            $result = Yii::app()->db->createCommand()
                ->select('username')
                ->from('user')
                ->where('username=:username', array(':username'=>$username))
                ->queryAll();
        } else $result = null;

        if ($result == null) {
            $sql = "update user set  username='".$username."', email='".$email."',address='".$address."',fullname='".$fullName."',phone='".$phone."',position='".$position."',birthday='".$birthday."',sex='".$sex."' where username='".$session."'";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
            return UserModel::SUCCESS;
        }
        return UserModel::ERROR_NAME_USER;
    }

    public function addUser($username, $fullName, $passwd, $email, $group, $address, $phone, $position, $birthday, $sex, $role, $salary, $id_number)
    {
        $result = Yii::app()->db->createCommand()
            ->select('username')
            ->from('user')
            ->where('username=:username', array(':username'=>$username))
            ->orWhere('email=:email',array(':email' => $email))
            ->orWhere('id_number=:id_number',array(':id_number'=> $id_number))
            ->queryAll();
        $command = Yii::app()->db->createCommand();
        if ($result == null) {
            $command->insert('user', array(
                'username'      =>  $username,
                'fullname'      =>  $fullName,
                'email'         =>  $email,
                'password'      =>  md5($passwd),
                'address'       =>  $address,
                'phone'         =>  $phone,
                'position'      =>  $position,
                'birthday'      =>  $birthday,
                'sex'           =>  $sex,
                'role'          =>  $role,
                'basicSalary'   => $salary,
                'group_user'    => $group,
                'id_number'     => $id_number
            ));
            return UserModel::SUCCESS;
        } else return UserModel::ERROR_NAME_USER;
    }

    public function editUser($user_id, $fullname, $position, $role, $salary, $group)
    {
        $sql = "update user set fullname='".$fullname."',position='".$position."',role='".$role."',basicSalary='".$salary."',group_user=".$group." where user_id=".$user_id;
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function deleteUser($user_id)
    {
        $command1 = Yii::app()->db->createCommand();
        $command1->delete('dayoff', 'user_id=:user_id', array(':user_id'=>$user_id));
        $command1->delete('overtime', 'user_id=:user_id', array(':user_id'=>$user_id));
        $sql = "DELETE FROM user where user_id='".$user_id."'";
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }

    public function searchUser($search)
    {
        $command = Yii::app()->db->createCommand();
        return $command->select()
                ->from('user')
                ->where(array('like', 'fullname', '%'.$search.'%'))
                ->queryAll();
    }

    public function forgotPassword($email)
    {
        $result = Yii::app()->db->createCommand()
            ->select()
            ->from('user')
            ->where('email=:email', array(':email'=>$email))
            ->queryRow();
        $token = uniqid();
        Yii::app()->db->createCommand()->delete('password_remind', 'email=:email', array(':email'=>$email));
        Yii::app()->db->createCommand()->insert('password_remind', array(
            'email'=>$email,
            'token'=>$token
        ));

        if ($result != false) {
            return $list = array('email' => $email,'token' => $token);
        }
        return false;
    }

    public function checkToken($email,$token)
    {
        $result = Yii::app()->db->createCommand()
            ->select()
            ->from('password_remind')
            ->where('token=:token', array(':token'=>$token))
            ->andWhere('email=:email', array(':email'=>$email))
            ->queryRow();
        if ($result != false) {
            return true;
        }
        return false;
    }

    public function resetPassword($email,$token,$password)
    {
        $md5pass =  md5($password);
        $result = Yii::app()->db->createCommand()
            ->select()
            ->from('password_remind')
            ->where('token=:token', array(':token'=>$token))
            ->andWhere('email=:email', array(':email'=>$email))
            ->queryRow();
        Yii::app()->db->createCommand()->delete('password_remind', 'email=:email', array(':email'=>$email));
        if ($result != false) {
            Yii::app()->db->createCommand()->update('user', array(
                'password' => $md5pass,
            ), 'email=:email', array(':email'=>$result['email']));
            return true;
        }
        return false;
    }

}

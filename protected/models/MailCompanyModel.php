<?php
/**
 * Created by JetBrains PhpStorm.
 * User: iStorm
 * Date: 5/21/14
 * Time: 2:57 PM
 * To change this template use File | Settings | File Templates.
 */

class MailCompanyModel {
    public function getMail()
    {
        $command = Yii::app()->db->createCommand()
            ->select()
            ->from('email_company')
            ->queryRow();
        return $command;
    }
}
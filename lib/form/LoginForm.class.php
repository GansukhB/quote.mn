<?php

/**
 * Base project form.
 *
 * @package    myproject
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class LoginForm extends sfForm
{
  public function configure()
  {
    $this->widgetSchema['username']       = new sfWidgetFormInputText(array(), array('size' => 30,'class'=> 'form-control', 'placeholder' => "Имэйл"));
    $this->widgetSchema['password']       = new sfWidgetFormInputPassword(array(), array('size' => 30,'class'=> 'form-control', 'placeholder' => 'Нууц үг'));

    $this->widgetSchema->setLabels(array('username' => 'И-Мэйл'));
    $this->widgetSchema->setLabels(array('password' => 'Нууц үг'));

    $this->validatorSchema['username'] = new sfValidatorEmail(
            array('required' => true),
            array('required' => 'Та И-Мэйл оруулна уу'));

    $this->validatorSchema['password'] = new sfValidatorString(
            array('required' => true),
            array('required' => 'Та нууц үгээ оруулна уу'));

    $this->widgetSchema->setNameFormat('user[%s]');
  }
}
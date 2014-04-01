<?php

/**
 * Page form base class.
 *
 * @method Page getObject() Returns the current form's model object
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'parent_id'       => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'front_image'     => new sfWidgetFormInputText(),
      'body'            => new sfWidgetFormTextarea(),
      'is_link'         => new sfWidgetFormInputText(),
      'link'            => new sfWidgetFormTextarea(),
      'is_active'       => new sfWidgetFormInputText(),
      'is_in_menu'      => new sfWidgetFormInputText(),
      'sort'            => new sfWidgetFormInputText(),
      'created_user_id' => new sfWidgetFormInputText(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_id'       => new sfValidatorInteger(),
      'title'           => new sfValidatorString(array('max_length' => 255)),
      'front_image'     => new sfValidatorString(array('max_length' => 255)),
      'body'            => new sfValidatorString(),
      'is_link'         => new sfValidatorInteger(),
      'link'            => new sfValidatorString(array('max_length' => 520)),
      'is_active'       => new sfValidatorInteger(),
      'is_in_menu'      => new sfValidatorInteger(),
      'sort'            => new sfValidatorInteger(),
      'created_user_id' => new sfValidatorInteger(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('page[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Page';
  }

}

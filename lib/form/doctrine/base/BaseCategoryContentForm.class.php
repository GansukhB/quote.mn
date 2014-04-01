<?php

/**
 * CategoryContent form base class.
 *
 * @method CategoryContent getObject() Returns the current form's model object
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryContentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'model_name'      => new sfWidgetFormInputText(),
      'model_id'        => new sfWidgetFormInputText(),
      'category_id'     => new sfWidgetFormInputText(),
      'created_user_id' => new sfWidgetFormInputText(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'model_name'      => new sfValidatorString(array('max_length' => 20)),
      'model_id'        => new sfValidatorInteger(),
      'category_id'     => new sfValidatorInteger(),
      'created_user_id' => new sfValidatorInteger(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('category_content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryContent';
  }

}

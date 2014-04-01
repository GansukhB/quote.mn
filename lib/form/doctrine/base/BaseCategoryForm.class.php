<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'model_name'      => new sfWidgetFormInputText(),
      'parent_id'       => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'sort'            => new sfWidgetFormInputText(),
      'is_active'       => new sfWidgetFormInputText(),
      'created_user_id' => new sfWidgetFormInputText(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'model_name'      => new sfValidatorString(array('max_length' => 20)),
      'parent_id'       => new sfValidatorInteger(),
      'title'           => new sfValidatorString(array('max_length' => 50)),
      'sort'            => new sfValidatorInteger(),
      'is_active'       => new sfValidatorInteger(),
      'created_user_id' => new sfValidatorInteger(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

}

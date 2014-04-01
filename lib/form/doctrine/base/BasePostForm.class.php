<?php

/**
 * Post form base class.
 *
 * @method Post getObject() Returns the current form's model object
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'category_id'     => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'front_image'     => new sfWidgetFormInputText(),
      'short_body'      => new sfWidgetFormTextarea(),
      'body'            => new sfWidgetFormTextarea(),
      'is_active'       => new sfWidgetFormInputText(),
      'is_commentable'  => new sfWidgetFormInputText(),
      'is_top'          => new sfWidgetFormInputText(),
      'is_featured'     => new sfWidgetFormInputText(),
      'count_view'      => new sfWidgetFormInputText(),
      'count_comment'   => new sfWidgetFormInputText(),
      'created_user_id' => new sfWidgetFormInputText(),
      'published_at'    => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'category_id'     => new sfValidatorInteger(),
      'title'           => new sfValidatorString(array('max_length' => 255)),
      'front_image'     => new sfValidatorString(array('max_length' => 255)),
      'short_body'      => new sfValidatorString(),
      'body'            => new sfValidatorString(),
      'is_active'       => new sfValidatorInteger(),
      'is_commentable'  => new sfValidatorInteger(),
      'is_top'          => new sfValidatorInteger(),
      'is_featured'     => new sfValidatorInteger(),
      'count_view'      => new sfValidatorInteger(),
      'count_comment'   => new sfValidatorInteger(),
      'created_user_id' => new sfValidatorInteger(),
      'published_at'    => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }

}

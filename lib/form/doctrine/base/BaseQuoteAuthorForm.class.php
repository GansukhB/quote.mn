<?php

/**
 * QuoteAuthor form base class.
 *
 * @method QuoteAuthor getObject() Returns the current form's model object
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseQuoteAuthorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'title'           => new sfWidgetFormInputText(),
      'bio'             => new sfWidgetFormTextarea(),
      'link'            => new sfWidgetFormTextarea(),
      'author_type'     => new sfWidgetFormInputText(),
      'created_user_id' => new sfWidgetFormInputText(),
      'is_top'          => new sfWidgetFormInputText(),
      'is_featured'     => new sfWidgetFormInputText(),
      'is_active'       => new sfWidgetFormInputText(),
      'published_at'    => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'bio'             => new sfValidatorString(array('required' => false)),
      'link'            => new sfValidatorString(array('required' => false)),
      'author_type'     => new sfValidatorInteger(array('required' => false)),
      'created_user_id' => new sfValidatorInteger(),
      'is_top'          => new sfValidatorInteger(),
      'is_featured'     => new sfValidatorInteger(),
      'is_active'       => new sfValidatorInteger(),
      'published_at'    => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('quote_author[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'QuoteAuthor';
  }

}

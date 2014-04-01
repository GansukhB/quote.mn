<?php

/**
 * QuoteAuthor form.
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class QuoteAuthorForm extends BaseQuoteAuthorForm
{
  public function configure()
  {
    $this->widgetSchema['author_type'] = new sfWidgetFormDoctrineChoice(
        array('model' => 'QuoteAuthorType', 
                'add_empty' => true,
                'order_by' => array('id', 'asc')
                )); 
    $this->widgetSchema['link'] = new sfWidgetFormInputText();
    $this->widgetSchema['is_active'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_top'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_featured'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['published_at']->setDefault(date("Y/m/d h:i:s"));
    
    $this->validatorSchema['link'] = new sfValidatorString(array('required' => false), array('required' => AppConstants::getRequiredText()));
  }
}

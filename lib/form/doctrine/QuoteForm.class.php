<?php

/**
 * Quote form.
 *
 * @package    quote.mn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class QuoteForm extends BaseQuoteForm
{
  public function configure()
  {
    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(
        array('model' => 'QuoteCategory', 
                'add_empty' => true,
                'order_by' => array('title', 'asc')
                )); 
    $this->widgetSchema['is_active'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_top'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_featured'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['published_at']->setDefault(date("Y/m/d h:i:s"));
  }
}

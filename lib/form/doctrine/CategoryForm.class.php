<?php

/**
 * Category form.
 *
 * @package    ecommerce
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryForm extends BaseCategoryForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['created_user_id'], $this['sort'], $this['model_name']);
    
      global $category_options;
      $category_options[0] = 'Үндсэн ангилал';
      
      $categories = CategoryTable::getInstance()->getCategorysByParentId(0, $this->getOption('model_name') );
      AppTools::display_category($categories, 0, $this->getOption('module_name'));
      
      $this->widgetSchema['parent_id'] = new sfWidgetFormChoice(array('choices' => $category_options), array());
              
      
      $this->widgetSchema['title'] = new sfWidgetFormInputText(array(), array('class'=> 'form-control', 'placeholder' => "Ангилалын нэр"));
      $this->widgetSchema['is_active'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice(1)));
      
      $this->validatorSchema['title'] = new sfValidatorString(array('required' => true), array('required' => 'Заавал оруулна'));
      
      
      $this->widgetSchema['parent_id']->setLabel('Үндсэн ангилал');
      $this->widgetSchema['title']->setLabel('Ангилалын нэр');
      $this->widgetSchema['is_active']->setLabel('Идэвхитэй эсэх');
  }
}

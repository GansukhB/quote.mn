<?php

/**
 * Post form.
 *
 * @package    ecommerce
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PostForm extends BasePostForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['count_view'], $this['count_comment'], $this['created_user_id'], $this['category_id']);
//    
//    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(
//        array('model' => 'PostCategory', 
//                'add_empty' => true,
//                'order_by' => array('sort', 'asc')
//                )); 
    
    
    $this->widgetSchema['body'] = new sfWidgetFormCKEditor();
    
    $this->widgetSchema['front_image_delete'] = new sfWidgetFormInputCheckbox(array(), array('class'=> 'form-control') );
    $this->widgetSchema['front_image'] = new sfWidgetFormInputFileEditable(array(
                'file_src' => '',
                'is_image' => false,
                'with_delete' => !$this->isNew() && $this->getObject()->getFrontImage(),
                'edit_mode' => !$this->isNew() && $this->getObject()->getFrontImage(),
                'template' => '<div style="margin-top: 15px;">%file%<br />%input%<br />%delete% '. AppConstants::getDeleteCurrentImage() .'</div>'
                )
              , array('class'=>'', 'placeholder'=>''));
    
    $this->widgetSchema['is_active'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_commentable'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_featured'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice(0)));
    $this->widgetSchema['is_top'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice(0)));
    
    $this->widgetSchema['published_at']->setDefault(date("Y/m/d h:i:s"));
    
    $this->validatorSchema['title'] = new sfValidatorString(array('required' => true), array('required' => AppConstants::getRequiredText()));
    $this->validatorSchema['front_image_delete'] = new sfValidatorBoolean(); 
    $this->validatorSchema['front_image'] = new sfValidatorFile(
                        array(
                            'required' => false,
                            'path' => sfConfig::get('sf_upload_dir').'/posts/'.  ( $this->getObject()->isNew() ? date("Y-m") : AppTools::getYearMonthText($this->getObject()->getCreatedAt()) ),
                            'max_size' => 1048576*5,
                            'mime_types' => array(
                                'image/jpeg',
                                'image/pjpeg',
                                'image/png',
                                'image/x-png',
                                'image/gif',
                            )
                        ),
                        array(
                            'required' => 'Та зураг оруулна уу',
                            'max_size' => 'Таны оруулсан зурагны хэмжээ иx байна. Хамгийн иxдээ 5MB.',
                            'mime_types' => 'Та зөвxөн зурган файл оруулаx боломжтой'));
    $this->validatorSchema['short_body'] = new sfValidatorString(array('required' => true), array('required' => AppConstants::getRequiredText()));
    $this->validatorSchema['body'] = new sfValidatorString(array('required' => true), array('required' => AppConstants::getRequiredText()));
    
    //$this->widgetSchema->setLabel('category_id', 'Төрөл');
    $this->widgetSchema->setLabel('title', 'Гарчиг');
    $this->widgetSchema->setLabel('front_image', 'Нүүр зураг');
    $this->widgetSchema->setLabel('short_body', 'Товч агуулга');
    $this->widgetSchema->setLabel('body', 'Агуулга');
    
    $this->widgetSchema->setLabel('is_active', 'Идэвхитэй эсэх');
    $this->widgetSchema->setLabel('is_commentable', 'Сэтгэгдэл бичиж болох эсэх');
    $this->widgetSchema->setLabel('is_featured', 'Онцлох мэдээ эсэх');
    $this->widgetSchema->setLabel('is_top', 'Нүүр хуудсанд онцлох эсэх');
    $this->widgetSchema->setLabel('published_at', 'Нийтлэгдсэн огноо');
    
    
    /*
     * Ангилал оруулж ирэх
     */
      global $category_options;
      $category_options[0] = 'Ангилалгүй';
      
      $categories = CategoryTable::getInstance()->getCategorysByParentId(0, 'post');
      AppTools::display_category($categories, 0, 'post');
      
      //$moduleCategoryForm = new sfForm();
      
      //$moduleCategoryForm->setWidget('module_category_set', new sfWidgetFormChoice(array(
      $this->setWidget('category', new sfWidgetFormChoice(array(
            'multiple' => 'true',
            'expanded' => true,
            'choices'   => $category_options,
            'default' => '0'
            ), array('label' => 'label') ));
      
      //$this->embedForm('module_category', $moduleCategoryForm);
      $this->widgetSchema->setLabel('category', 'Нийтлэлийн ангилал');
      $this->validatorSchema['category'] = new sfValidatorString(array('required'=>false));
      
      if(!$this->isNew())
      {
        $category_ids = AppTools::getCategoryIds('post', $this->getObject()->getId());  
        $this->widgetSchema['category']->setDefault($category_ids);
      }
  }
}

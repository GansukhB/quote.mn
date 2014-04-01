<?php

/**
 * Page form.
 *
 * @package    ecommerce
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageForm extends BasePageForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['created_user_id'], $this['sort']);
    
    global $options;
    $options[0] = 'Үндсэн цэс';

    $pages = PageTable::getInstance()->getPagesByParentId(0);
    AppTools::display_options($pages, 0);
    
    $this->widgetSchema['parent_id'] = new sfWidgetFormChoice(array('choices' => $options), array('class'=>'form-control', 'placeholder'=>'Үндэс', 'style' => ''));
       
    $this->widgetSchema['body'] = new sfWidgetFormCKEditor();
    
    $this->widgetSchema['front_image_delete'] = new sfWidgetFormInputCheckbox(array(), array() );
    $this->widgetSchema['front_image'] = new sfWidgetFormInputFileEditable(array(
                'file_src' => '',
                'is_image' => false,
                'with_delete' => !$this->isNew() && $this->getObject()->getFrontImage(),
                'edit_mode' => !$this->isNew() && $this->getObject()->getFrontImage(),
                'template' => '<div style="margin-top: 15px;">%file%<br />%input%<br />%delete% '. AppConstants::getDeleteCurrentImage() .'</div>'
                )
              , array('class'=>'', 'placeholder'=>''));
    $this->widgetSchema['link'] = new sfWidgetFormInputText();
    $this->widgetSchema['is_link'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice(0)));
    $this->widgetSchema['is_active'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice()));
    $this->widgetSchema['is_in_menu'] = new sfWidgetFormSelect(array('choices' => AppConstants::getBooleanChoice(0)));
    
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
    $this->validatorSchema['body'] = new sfValidatorString(array('required' => false), array('required' => AppConstants::getRequiredText()));
    $this->validatorSchema['link'] = new sfValidatorString(array('required' => false), array('required' => AppConstants::getRequiredText()));
    
    $this->widgetSchema->setLabel('parent_id', 'Үндсэн цэс');
    $this->widgetSchema->setLabel('title', 'Гарчиг');
    $this->widgetSchema->setLabel('front_image', 'Нүүр зураг');
    $this->widgetSchema->setLabel('body', 'Агуулга');
    $this->widgetSchema->setLabel('is_link', 'Холбоос эсэх');
    $this->widgetSchema->setLabel('link', 'Холбоос');
    $this->widgetSchema->setLabel('is_active', 'Идэвхитэй эсэх');
    $this->widgetSchema->setLabel('is_in_menu', 'Цэсэнд харагдах эсэх');
    
  }
}

<?php

/**
 * system actions.
 *
 * @package    ecommerce
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systemActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }
  public function executeSearch(sfWebRequest $request)
  {
     
  }
  public function executeChangestate(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $field = $request->getParameter('field');
      $model_name = $request->getParameter('model_name');
      
      $item = Doctrine::getTable(AppTools::getClassnameByTable($model_name))->find($id);
      
      if($item->get($field))
      {
          $item->set($field, '0');
      }
      else
      {
          $item->set($field, '1');
          if($field == 'is_active')
          switch($model_name)
          {
            case 'quote':
              $quote = $item;
              $quote->Publish();
              $quote_category = AppConstants::getQuoteCategory($quote->getCategoryId());
              if($quote_category->getId()) $quote_category->Publish();
              
              $quote_author = AppConstants::getQuoteAuthor($quote->getAuthorId());
              if($quote_author){
                $quote_author->Publish();
                $quote_author_type = AppConstants::getQuoteAuthorType($quote_author->getAuthorType());
                if($quote_author_type->getId()) $quote_author_type->Publish();
              }
              break;
              
            case 'quote_author':
              $quote_author = $item;
              if($quote_author){
                $quote_author->Publish();
                $quote_author_type = AppConstants::getQuoteAuthorType($quote_author->getAuthorType());
                if($quote_author_type->getId()) $quote_author_type->Publish();
              }
              break;
              
            case 'quote_author_type':
              $quote_author_type = $item;
              $quote_author_type->Publish();
              break; 
            
            case 'quote_category':
              $quote_category = $item;
              $quote_category->Publish();
              break; 
          }
      }
      $item->save();
      $this->redirect($request->getReferer());
  }
}

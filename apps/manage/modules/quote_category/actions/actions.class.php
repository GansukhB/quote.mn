<?php

/**
 * quote_category actions.
 *
 * @package    quote.mn
 * @subpackage quote_category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quote_categoryActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    /*
    $this->quote_categorys = new sfDoctrinePager ('QuoteCategory', sfConfig::get('app_max_content_per_page'));
    $this->quote_categorys -> getQuery()
	     ->from('QuoteCategory a')
		 ->orderBy('a.created_at DESC');
	  $this->quote_categorys -> setPage($this->getRequestParameter('page',1)); 
	  $this->quote_categorys -> init();
    */
    
    $this->my_pager = new MyPager('quote_category', array(), 'id DESC', sfConfig::get('app_max_content_per_page'), $this->getRequestParameter('page',1));
    $this->quote_categorys = $this->my_pager->getResult();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new QuoteCategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new QuoteCategoryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($quote_category = Doctrine_Core::getTable('QuoteCategory')->find(array($request->getParameter('id'))), sprintf('Object quote_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteCategoryForm($quote_category);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($quote_category = Doctrine_Core::getTable('QuoteCategory')->find(array($request->getParameter('id'))), sprintf('Object quote_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteCategoryForm($quote_category);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($quote_category = Doctrine_Core::getTable('QuoteCategory')->find(array($request->getParameter('id'))), sprintf('Object quote_category does not exist (%s).', $request->getParameter('id')));
    $quote_category->delete();

    $this->redirect('quote_category/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
	  if($form->getObject()->isNew())
	  {
            $form->getObject()->setCreatedUserId($this->getUser()->getId());
	    $form->getObject()->setCreatedAt(date("Y/m/d h:i:s"));
	  }
      $quote_category = $form->save();
	  
	  $quote_category->setUpdatedAt(date("Y/m/d h:i:s"));
      $quote_category->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('quote_category/edit?id='.$quote_category->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
}

<?php

/**
 * quote actions.
 *
 * @package    quote.mn
 * @subpackage quote
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quoteActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('quote/list');
  }
  public function executeList(sfWebRequest $request)
  {
    /*
    $this->quotes = new sfDoctrinePager ('Quote', sfConfig::get('app_max_content_per_page'));
    $this->quotes -> getQuery()
	     ->from('Quote a')
		 ->orderBy('a.created_at DESC');
	  $this->quotes -> setPage($this->getRequestParameter('page',1)); 
	  $this->quotes -> init();
    */
    $this->internal_url = 'quote/list';
    $this->whereArray = array();
    if($request->getParameter('author_id'))
    {
      $this->whereArray['author_id'] = $request->getParameter('author_id');
    }
    if($request->getParameter('category_id'))
    {
      $this->whereArray['category_id'] = $request->getParameter('category_id');
    }
    if($request->getParameter('is_top'))
    {
      $this->whereArray['is_top'] = $request->getParameter('is_top');
    }
    if($request->getParameter('is_featured'))
    {
      $this->whereArray['is_featured'] = $request->getParameter('is_featured');
    }
    if($request->getParameter('is_active'))
    {
      $this->whereArray['is_active'] = $request->getParameter('is_active');
    }
    
    
    $this->my_pager = new MyPager('quote', $this->whereArray, 'is_active ASC, id DESC ', sfConfig::get('app_max_content_per_page'), $this->getRequestParameter('page',1));
    $this->quotes = $this->my_pager->getResult();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new QuoteForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new QuoteForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($quote = Doctrine_Core::getTable('Quote')->find(array($request->getParameter('id'))), sprintf('Object quote does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteForm($quote);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($quote = Doctrine_Core::getTable('Quote')->find(array($request->getParameter('id'))), sprintf('Object quote does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteForm($quote);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($quote = Doctrine_Core::getTable('Quote')->find(array($request->getParameter('id'))), sprintf('Object quote does not exist (%s).', $request->getParameter('id')));
    $quote->delete();

    $this->redirect('quote/index');
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
      $quote = $form->save();
	  
	  $quote->setUpdatedAt(date("Y/m/d h:i:s"));
      $quote->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('quote/edit?id='.$quote->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
}

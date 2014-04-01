<?php

/**
 * quote_author_type actions.
 *
 * @package    quote.mn
 * @subpackage quote_author_type
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quote_author_typeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    /*
    $this->quote_author_types = new sfDoctrinePager ('QuoteAuthorType', sfConfig::get('app_max_content_per_page'));
    $this->quote_author_types -> getQuery()
	     ->from('QuoteAuthorType a')
		 ->orderBy('a.created_at DESC');
	  $this->quote_author_types -> setPage($this->getRequestParameter('page',1)); 
	  $this->quote_author_types -> init();
    */
    
    $this->my_pager = new MyPager('quote_author_type', array(), 'id DESC', sfConfig::get('app_max_content_per_page'), $this->getRequestParameter('page',1));
    $this->quote_author_types = $this->my_pager->getResult();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new QuoteAuthorTypeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new QuoteAuthorTypeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($quote_author_type = Doctrine_Core::getTable('QuoteAuthorType')->find(array($request->getParameter('id'))), sprintf('Object quote_author_type does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteAuthorTypeForm($quote_author_type);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($quote_author_type = Doctrine_Core::getTable('QuoteAuthorType')->find(array($request->getParameter('id'))), sprintf('Object quote_author_type does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteAuthorTypeForm($quote_author_type);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($quote_author_type = Doctrine_Core::getTable('QuoteAuthorType')->find(array($request->getParameter('id'))), sprintf('Object quote_author_type does not exist (%s).', $request->getParameter('id')));
    $quote_author_type->delete();

    $this->redirect('quote_author_type/index');
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
      $quote_author_type = $form->save();
	  
	  $quote_author_type->setUpdatedAt(date("Y/m/d h:i:s"));
      $quote_author_type->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('quote_author_type/edit?id='.$quote_author_type->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
}

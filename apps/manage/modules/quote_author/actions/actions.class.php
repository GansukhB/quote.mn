<?php

/**
 * quote_author actions.
 *
 * @package    quote.mn
 * @subpackage quote_author
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quote_authorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    /*
    $this->quote_authors = new sfDoctrinePager ('QuoteAuthor', sfConfig::get('app_max_content_per_page'));
    $this->quote_authors -> getQuery()
	     ->from('QuoteAuthor a')
		 ->orderBy('a.created_at DESC');
	  $this->quote_authors -> setPage($this->getRequestParameter('page',1)); 
	  $this->quote_authors -> init();
    */
    
    $this->my_pager = new MyPager('quote_author', array(), 'id DESC', sfConfig::get('app_max_content_per_page'), $this->getRequestParameter('page',1));
    $this->quote_authors = $this->my_pager->getResult();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new QuoteAuthorForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new QuoteAuthorForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($quote_author = Doctrine_Core::getTable('QuoteAuthor')->find(array($request->getParameter('id'))), sprintf('Object quote_author does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteAuthorForm($quote_author);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($quote_author = Doctrine_Core::getTable('QuoteAuthor')->find(array($request->getParameter('id'))), sprintf('Object quote_author does not exist (%s).', $request->getParameter('id')));
    $this->form = new QuoteAuthorForm($quote_author);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($quote_author = Doctrine_Core::getTable('QuoteAuthor')->find(array($request->getParameter('id'))), sprintf('Object quote_author does not exist (%s).', $request->getParameter('id')));
    $quote_author->delete();

    $this->redirect('quote_author/index');
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
      $quote_author = $form->save();
	  
	  $quote_author->setUpdatedAt(date("Y/m/d h:i:s"));
      $quote_author->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('quote_author/edit?id='.$quote_author->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
}

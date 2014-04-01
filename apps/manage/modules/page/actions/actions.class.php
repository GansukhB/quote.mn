<?php

/**
 * page actions.
 *
 * @package    ecommerce
 * @subpackage page
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pageActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pages = new sfDoctrinePager ('page', sfConfig::get('app_max_content_per_page'));
    $this->pages -> getQuery()
	     ->from('page a')
		 ->orderBy('a.created_at DESC');
	$this->pages -> setPage($this->getRequestParameter('page',1)); 
	$this->pages -> init();
        
        $this->pages_menu = Doctrine::getTable('Page')->getModulePagesMenu();
        $this->pages_menu_draft = Doctrine::getTable('Page')->getModulePagesMenuDraft();

        $this->pages_hidden = Doctrine::getTable('Page')->getModulePagesHidden();
        $this->pages_hidden_draft = Doctrine::getTable('Page')->getModulePagesHiddenDraft();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new pageForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new pageForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($page = Doctrine_Core::getTable('page')->find(array($request->getParameter('id'))), sprintf('Object page does not exist (%s).', $request->getParameter('id')));
    $this->form = new pageForm($page);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($page = Doctrine_Core::getTable('page')->find(array($request->getParameter('id'))), sprintf('Object page does not exist (%s).', $request->getParameter('id')));
    $this->form = new pageForm($page);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($page = Doctrine_Core::getTable('page')->find(array($request->getParameter('id'))), sprintf('Object page does not exist (%s).', $request->getParameter('id')));
    $page->delete();

    $this->redirect('page/index');
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
      $page = $form->save();
      
      if($form->isNew())
      {
          $page->setSort($page->getId());
      }
	  $page->setUpdatedAt(date("Y/m/d h:i:s"));
          $page->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('page/edit?id='.$page->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
    public function executeMove(sfWebRequest $request)
    {
        $item_id = $request->getParameter('id');
        $move_to = $request->getParameter('to');

        AppTools::switchListitem('Page', $item_id, $move_to, array('is_in_menu' => '1', 'is_active' => '1'));
        
        $this->redirect('page/index');
    }
}

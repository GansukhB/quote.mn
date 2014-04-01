<?php

/**
 * post actions.
 *
 * @package    ecommerce
 * @subpackage post
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class postActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->posts = new sfDoctrinePager ('Post', sfConfig::get('app_max_content_per_page'));
    $this->posts -> getQuery()
	     ->from('Post a')
		 ->orderBy('a.created_at DESC');
	$this->posts -> setPage($this->getRequestParameter('page',1)); 
	$this->posts -> init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PostForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PostForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($post = Doctrine_Core::getTable('Post')->find(array($request->getParameter('id'))), sprintf('Object post does not exist (%s).', $request->getParameter('id')));
    $this->form = new PostForm($post);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($post = Doctrine_Core::getTable('Post')->find(array($request->getParameter('id'))), sprintf('Object post does not exist (%s).', $request->getParameter('id')));
    $this->form = new PostForm($post);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($post = Doctrine_Core::getTable('Post')->find(array($request->getParameter('id'))), sprintf('Object post does not exist (%s).', $request->getParameter('id')));
    $post->delete();

    $this->redirect('post/index');
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
      $post = $form->save();
	  
	  $post->setUpdatedAt(date("Y/m/d h:i:s"));
      $post->save();
	  
      $post_categories = $form['category']->getValue();
      /* Ангилал оноолт */
      Doctrine::getTable('CategoryContent')->createCheckedCategoryContent('post', $post->getId(), $post_categories);
      /* Ангилал устгах тохиолдолд */
      Doctrine::getTable('CategoryContent')->deleteUncheckedCategoryContent('post', $post->getId(), $post_categories);
            
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
      $this->redirect('post/edit?id='.$post->getId());
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }
  public function executeChangestate(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $field = $request->getParameter('field');
      
      $post = Doctrine::getTable('Post')->find($id);
      
      if($post->get($field))
      {
          $post->set($field, '0');
      }
      else
      {
          $post->set($field, '1');
      }
      $post->save();
      $this->redirect($request->getReferer());
  }
  
}

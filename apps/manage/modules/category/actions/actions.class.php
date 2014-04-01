<?php

/**
 * category actions.
 *
 * @package    ecommerce
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->categorys = Doctrine_Core::getTable('Category')->getCategories($request->getParameter('model_name'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->categorys = Doctrine_Core::getTable('Category')->getCategories($request->getParameter('model_name'));
    $this->form = new CategoryForm(null,  array ('model_name' => $request->getParameter('model_name')));
    
    $this->setTemplate('index');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->categorys = Doctrine_Core::getTable('Category')->getCategories($request->getParameter('model_name'));
    $this->form = new CategoryForm(null,  array ('model_name' => $request->getParameter('model_name')));

    $this->processForm($request, $this->form, $request->getParameter('model_name') );

    $this->setTemplate('index');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->categorys = Doctrine_Core::getTable('Category')->getCategories($request->getParameter('model_name'));
    $this->forward404Unless($category = Doctrine_Core::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoryForm($category, array ('model_name' => $request->getParameter('model_name')));
    $this->setTemplate('index');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->categorys = Doctrine_Core::getTable('Category')->getCategories($request->getParameter('model_name'));
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($category = Doctrine_Core::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoryForm($category, array ('model_name' => $request->getParameter('model_name')));

    $this->processForm($request, $this->form, $request->getParameter('model_name'));

    $this->setTemplate('index');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($category = Doctrine_Core::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $category->delete();

    $this->redirect('category/index?model_name='.$request->getParameter('model_name'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $model_name)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
	  if($form->getObject()->isNew())
	  {
            $form->getObject()->setCreatedUserId($this->getUser()->getId());
            $form->getObject()->setModelName($model_name);
	    $form->getObject()->setCreatedAt(date("Y/m/d h:i:s"));
	  }
      $category = $form->save();
      
      if($category->getId() == $category->getParentId())
      {
          $category->setParentId(0);
          $category->save();
      }
      if($form->isNew())
      {
          $category->setSort($category->getId());
      }
	  
	  $category->setUpdatedAt(date("Y/m/d h:i:s"));
          $category->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
          //$this->redirect('category/edit?id='.$category->getId().'&model_name='.$model_name);
          $this->redirect('category/index?model_name='.$model_name);
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
        $model_name = $request->getParameter('model_name');
        
        AppTools::switchListitem('Category', $item_id, $move_to, array('model_name' => $model_name));
        
        $this->redirect('category/index?model_name='.$model_name);
    }
    
  public function executeChangestate(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $field = $request->getParameter('field');
      
      $post = Doctrine::getTable('Category')->find($id);
      
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

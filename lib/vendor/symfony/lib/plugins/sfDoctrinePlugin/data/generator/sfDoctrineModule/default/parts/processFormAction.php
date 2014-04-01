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
      $<?php echo $this->getSingularName() ?> = $form->save();
	  
	  $<?php echo $this->getSingularName() ?>->setUpdatedAt(date("Y/m/d h:i:s"));
      $<?php echo $this->getSingularName() ?>->save();
	  
	  $this->getUser()->setFlash('alert', 'success' );
	  $this->getUser()->setFlash('message', 'Амжилттай хадгаллаа' );
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
      $this->redirect('@<?php echo $this->getUrlForAction('edit') ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>);
<?php else: ?>
      $this->redirect('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams() ?>);
<?php endif; ?>
    }
	else
	{
	  $this->getUser()->setFlash('alert', 'danger' );
	  $this->getUser()->setFlash('message', 'Мэдээ мэдээллийн талбарыг бүрэн бөглөнө үү.' );		
	}
  }

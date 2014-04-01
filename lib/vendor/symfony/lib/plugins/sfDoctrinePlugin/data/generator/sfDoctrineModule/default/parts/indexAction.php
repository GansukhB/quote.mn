  public function executeIndex(sfWebRequest $request)
  {
<?php if (isset($this->params['with_doctrine_route']) && $this->params['with_doctrine_route']): ?>
    $this-><?php echo $this->getPluralName() ?> = $this->getRoute()->getObjects();
<?php else: ?>
    /*
    $this-><?php echo $this->getPluralName() ?> = new sfDoctrinePager ('<?php echo $this->getModelClass() ?>', sfConfig::get('app_max_content_per_page'));
    $this-><?php echo $this->getPluralName() ?> -> getQuery()
	     ->from('<?php echo $this->getModelClass() ?> a')
		 ->orderBy('a.created_at DESC');
	  $this-><?php echo $this->getPluralName() ?> -> setPage($this->getRequestParameter('page',1)); 
	  $this-><?php echo $this->getPluralName() ?> -> init();
    */
    
    $this->my_pager = new MyPager('<?php echo $this->getSingularName() ?>', array(), 'id DESC', sfConfig::get('app_max_content_per_page'), $this->getRequestParameter('page',1));
    $this-><?php echo $this->getPluralName() ?> = $this->my_pager->getResult();
<?php endif; ?>
  }

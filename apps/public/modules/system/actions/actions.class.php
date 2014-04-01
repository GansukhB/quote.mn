<?php

/**
 * system actions.
 *
 * @package    quote.mn
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
    $this->quote_categorys = QuoteCategoryTable::getInstance()->findAll();
  }
  public function executeError404(sfWebRequest $request)
  {
    
  }
  public function executeSitemap(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');
    
    switch($this->type)
    {
      case 'category':
        $this->urls = QuoteCategoryTable::getInstance()
          ->createQuery()
          ->where('is_active=1')
          ->orderBy('title ASC')
          ->execute();
        
        break;
      case 'author':
        $this->urls = QuoteAuthorTable::getInstance()
          ->createQuery()
          ->where('is_active=1')
          ->orderBy('title ASC')
          ->execute();
        break;
      default:
    }
    $this->setLayout('sitemap_layout');
  }
}

<?php

/**
 * category actions.
 *
 * @package    quote.mn
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quote_categoryActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->quote_categorys = $this->mysql->SelectRows('quote_category', array('is_active' => '1'), null, 'title' );
    $this->quote_categorys = $this->mysql->RecordsArray();
  }
  public function executeShow(sfWebRequest $request)
  {
    $this->category = QuoteCategoryTable::getInstance()->find($request->getParameter('id'));
    
    $this->forward404Unless($this->category);
    //if($this->category) { $this->forward404(); }
    
    $this->page_title = $this->category->getTitle().' quotes';
    $this->page_route = '@category_show?id='.$request->getParameter('id').'&slug='.$request->getParameter('slug');
    
    $category_id = $request->getParameter('id');
    $page = $request->getParameter('page', 1);
    $per_page = sfConfig::get('app_quotes_per_page');
    
    $select = array('', 'qa.author_type AS quote_author_type_id', 'qa.title AS quote_author_title', 
                                 'qc.title AS quote_category_title', 'qat.title AS quote_author_type_title');
    $join = array('', 'quote_author qa ON t.author_id=qa.id',
                            'quote_category qc ON t.category_id=qc.id',
                            'quote_author_type qat ON qa.author_type=qat.id');
    
    $this->my_pager = new MyPager('quote', array('category_id' => $category_id, 'is_active' => '1'), 'published_at DESC', $per_page, $page, $select, $join);
    $this->quotes = $this->my_pager->getResult();
    $this->quotes_count = $this->my_pager->getMySQL()->RowCount();
    
    $this->getResponse()->setTitle( $this->page_title . ' :: '. sfConfig::get('app_title_site_default')); 
    
    $this->setTemplate('list', 'quote');
  }
}

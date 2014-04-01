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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $per_page = sfConfig::get('app_quote_author_per_page');
    $page = $request->getParameter('page', 1);
    $this->page_title = 'Authors';
    $this->page_helper = '';
    $this->page_route = '@quote_author';
    
    $whereArray = array();
    $whereArray['is_active'] = '1';
    
    if($request->getParameter('author_type'))
    {
      $author_type = QuoteAuthorTypeTable::getInstance()->find($request->getParameter('author_type'));
      if($author_type)
        $this->page_helper = $author_type->getTitle(); 
      $whereArray['author_type'] = $request->getParameter('author_type');
      
      $this->page_title = $author_type->getTitle(). ' authors';
    }
    if($request->getParameter('start'))
    {
      //$whereArray['author_type'] = $request->getParameter('author_type');
    }
    
    $this->my_pager = new MyPager('quote_author', $whereArray, 'title ASC', $per_page, $page);
    $this->quote_authors = $this->my_pager->getResult();
    $this->quote_authors_count = $this->my_pager->getMySQL()->RowCount();
    
    $this->getResponse()->setTitle( $this->page_title . ' :: '. sfConfig::get('app_title_site_default')); 
  }
  public function executeShow(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->author = QuoteAuthorTable::getInstance()->find($id);
    
    $this->forward404Unless($this->author && $this->author->getIsActive());
    
    $this->page_title = $this->author->getTitle().' quotes';
    $this->page_helper = '';
    $this->page_route = '@quote_author_show?id='.$request->getParameter('id').'&slug='.$request->getParameter('slug');
    
    $author_id = $request->getParameter('id');
    $page = $request->getParameter('page', 1);
    $per_page = sfConfig::get('app_quotes_per_page');
    
    $select = array('', 'qa.author_type AS quote_author_type_id', 'qa.title AS quote_author_title', 
                                 'qc.title AS quote_category_title', 'qat.title AS quote_author_type_title');
    $join = array('', 'quote_author qa ON t.author_id=qa.id',
                            'quote_category qc ON t.category_id=qc.id',
                            'quote_author_type qat ON qa.author_type=qat.id');
    
    $this->my_pager = new MyPager('quote', array('author_id' => $author_id, 'is_active' => '1'), 'published_at DESC', $per_page, $page, $select, $join);
    $this->quotes = $this->my_pager->getResult();
    $this->quotes_count = $this->my_pager->getMySQL()->RowCount();
    
    $this->getResponse()->setTitle( $this->page_title . ' :: '. sfConfig::get('app_title_site_default')); 
    
    $this->setTemplate('list', 'quote');
  }
}

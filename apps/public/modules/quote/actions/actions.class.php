<?php

/**
 * quote actions.
 *
 * @package    quote.mn
 * @subpackage quote
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class quoteActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->page_title = 'All quotes';
    $this->page_route = 'quote/index';
    
    $page = $request->getParameter('page', 1);
    $per_page = sfConfig::get('app_quotes_per_page');
    
    $select = array('', 'qa.author_type AS quote_author_type_id', 'qa.title AS quote_author_title', 
                                 'qc.title AS quote_category_title', 'qat.title AS quote_author_type_title');
    $join = array('', 'quote_author qa ON t.author_id=qa.id',
                            'quote_category qc ON t.category_id=qc.id',
                            'quote_author_type qat ON qa.author_type=qat.id');
    
    $this->my_pager = new MyPager('quote', array('is_active' => '1'), 'published_at DESC', $per_page, $page, $select, $join);
    $this->quotes = $this->my_pager->getResult();
    $this->quotes_count = $this->my_pager->getMySQL()->RowCount();
    $this->setTemplate('list', 'quote');
  }
  public function executeShow(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->quote = QuoteTable::getInstance()->find($id);
    $this->forward404Unless($this->quote);
    
    $this->quote_author = QuoteAuthorTable::getInstance()->find($this->quote->getAuthorId());
    if($this->quote_author)
    {
      if($this->quote_author->getIsActive() == 0)
        $this->quote_author->Publish();
    }
    $this->quote_category = QuoteCategoryTable::getInstance()->find($this->quote->getCategoryId());
    $this->getResponse()->setTitle(PublicTools::strip_quotes($this->quote->getBody()). ' ~ ' . $this->quote_author->getTitle() . ' :: '. sfConfig::get('app_title_site_default')); 
  }
}

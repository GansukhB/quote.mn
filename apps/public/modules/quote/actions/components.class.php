<?php
class quoteComponents extends sfComponents
{
  public function executeTop(sfWebRequest $request) {
    $this->quote = QuoteTable::getInstance()
      ->createQuery()
      ->where('is_top = 1')
      ->andWhere('is_active = 1')
      ->fetchOne();
  }
  public function executeLatest(sfWebRequest $request)
  {
    $select = array('', 'qa.author_type AS quote_author_type_id', 'qa.title AS quote_author_title', 
                                 'qc.title AS quote_category_title', 'qat.title AS quote_author_type_title');
    $join = array('', 'quote_author qa ON t.author_id=qa.id',
                            'quote_category qc ON t.category_id=qc.id',
                            'quote_author_type qat ON qa.author_type=qat.id');
    $whereArray = array();
    if($this->category_id)
    {
      $whereArray['category_id'] = $this->category_id;
    }
    if($this->author_id)
    {
      $whereArray['category_id'] = $this->category_id;
    }
    $whereArray['is_active'] = '1';
    
    $this->my_pager = new MyPager('quote', $whereArray, 'published_at DESC', $this->per_page, 1, $select, $join);
    $this->quotes = $this->my_pager->getResult();
    $this->quotes_count = $this->my_pager->getMySQL()->RowCount();
  }
}

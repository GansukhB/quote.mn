<?php
class quote_categoryComponents extends sfComponents
{
  public function executeLatest(sfWebRequest $request)
  {
    $this->categories = QuoteCategoryTable::getInstance()
      ->createQuery()
      ->where('is_active = 1')
      ->orderBy('published_at desc')
      ->limit($this->limit)
      ->execute();
  }
  public function executeCategory(sfWebRequest $request)
  {
    $this->categories = QuoteCategoryTable::getInstance()
      ->createQuery()
      ->where('is_active = 1')
      ->orderBy('title ASC')
      ->execute();
  }
}

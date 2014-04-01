<?php
class quote_authorComponents extends sfComponents
{
  public function executeLatest(sfWebRequest $request)
  {
    $this->authors = QuoteAuthorTable::getInstance()
      ->createQuery()
      ->where('is_active = 1')
      ->orderBy('published_at desc')
      ->limit($this->limit)
      ->execute();
  }
  public function executeBio(sfWebRequest $request)
  {
  }
  public function executeAuthortype(sfWebRequest $request)
  {
    $this->author_types = QuoteAuthorTypeTable::getInstance()
      ->createQuery()
      ->where('is_active = 1')
      ->orderBy('title ASC')
      ->execute();
  }
}

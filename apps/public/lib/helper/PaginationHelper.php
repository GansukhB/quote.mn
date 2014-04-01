<?php
 
function pager_navigation($pager, $uri)
{
  $navigation = '<ul class="pagination pagination-sm">';
 
  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
 
    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= '<li>'.link_to('First',  $uri.'1').'</li>';
      $navigation .= '<li>'.link_to('Previous',  $uri.$pager->getPreviousPage()).'</li>';
    }
 
    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
        if($page == $pager->getPage())
            $links[] = '<li class="active">'.link_to($page, $uri.$page).'</li>';
        else
            $links[] = '<li>'.link_to($page, $uri.$page).'</li>';
    }
    $navigation .= join('  ', $links);
 
    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= '<li>'.link_to('Next', $uri.$pager->getNextPage()).'</li>';
      $navigation .= '<li>'.link_to('Last',  $uri.$pager->getLastPage()).'</li>';
    }
 
  }
 
  $navigation .= '</ul>';
  return $navigation;
}
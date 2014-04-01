<?php
global $page_html;
global $page_put;

class PageTree
{
    public function __construct()
    {

    }
  public function getTree($pages)
  {
    global $page_html;
    global $page_put;
    $page_put = array();
    
    $this->pages = $pages;
          
    $this->DFSTree(null, $this->pages);
        
    return $page_html;
  }
  private function DFSTree($root, $list)
  {
      global $page_html;
      global $page_put;
      
        $childs = array();
        
        foreach($list as $page)
        {
            if($root)
            {
                if($page->getParentId() == $root->getId())
                {
                    array_push($childs, $page);
                }
            }
            else
            {
                if($page->getParentId() == '0')
                {
                    array_push($childs, $page);
                }
            }   
        }
        $child_count = count($childs);

        if($child_count == 0 && $root)
        {
            $page_html .= "<li><div class=\"box-menu-list  tooltip-buttons\">".$root->getTitle()."<div class=\"pull-right\"> 
                        <a href=\"". url_for('page/edit?id='.$root->getId())."\"  class=\"btn btn-xs btn-warning\"  data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Засварлах\"><i class=\"fa fa-edit\"></i> Засварлах</a>
                        <a href=\"". url_for('page/move?id='.$root->getId().'&to=up')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Дээш зөөх\">&nbsp;<i class=\"fa fa-arrow-up\"></i>&nbsp;</a>
                        <a href=\"". url_for('page/move?id='.$root->getId().'&to=down')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"Доош зөөх\">&nbsp;<i class=\"fa fa-arrow-down\"></i>&nbsp;</a>
                        </div></div></li>";
            
            $page_put[] = $root;
        }
        else
        {
            if($root)
            {
                $page_html .= "<li><div class=\"box-menu-list tooltip-buttons\">".$root->getTitle()."<div class=\"pull-right\">  
                            <a href=\"". url_for('page/edit?id='.$root->getId())."\"  class=\"btn btn-xs btn-warning\"  data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Засварлах\"><i class=\"fa fa-edit\"></i> Засварлах</a> 
                            <a href=\"". url_for('page/move?id='.$root->getId().'&to=up')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Дээш зөөх\">&nbsp;<i class=\"fa fa-arrow-up\"></i>&nbsp;</a>
                            <a href=\"". url_for('page/move?id='.$root->getId().'&to=down')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"Доош зөөх\">&nbsp;<i class=\"fa fa-arrow-down\"></i>&nbsp;</a>
                            </div></div><ul>";
                
                $page_put[] = $root;
            }
            foreach($childs as $child)
            {
                $this->DFSTree($child, $list);
            }

            $page_html .= "</ul></li>";
        }
  }
  public function getPagePut($pages)
  {
      global $page_put;
      $result = array();
      
      foreach($pages as $page)
      {
          $count = 0;
          foreach($page_put as $put)
          {
              if($page->getId() == $put->getId())
              {
                  $count++;
              }
          }
          if($count == 0)
          {
              $result[] = $page;
          }
      }
      
      return $result;
  }
}
?>

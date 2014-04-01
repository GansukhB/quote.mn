<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfDoctrine pager class.
 *
 * @package    sfDoctrinePlugin
 * @subpackage pager
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfDoctrinePager.class.php 28897 2010-03-30 20:30:24Z Jonathan.Wage $
 */
class MyPager 
{
  protected $table_name;
  protected $order_by;
  protected $per_page;
  protected $page;
  protected $result;
  protected $result_count; 
  protected $mysql;
  public $query;

  public function __construct($table_name, $where = null, $order_by = 'id DESC', $per_page = 10, $page = 1, $select = array(), $join = array() ) {
    $this->mysql = new MySQL();
    $this->result_count = $this->mysql->Query('SELECT COUNT(id) AS result_count FROM '.
                          $table_name.'  '. $this->mysql->BuildSQLWhereClause($where));
    $this->result_count = $this->mysql->RecordsArray();
    $this->result_count = $this->result_count['0']['result_count'];
    
    $limit = ( $page - 1) * $per_page . ', '. $per_page;
    
    $this->page = $page; 
    $this->per_page = $per_page;
    /*
    $this->query = 'SELECT  t.*, qa.author_type AS quote_author_type_id, qa.title AS quote_author_title, 
                                 qc.title AS quote_category_title, qat.title AS quote_author_type_title
                        FROM    (
                                SELECT  id
                                FROM    '.$table_name.' '. $this->mysql->BuildSQLWhereClause($where) .'
                                ORDER BY
                                        id
                                LIMIT '.$limit.'
                                ) q
                        JOIN    '.$table_name.' t
                        ON      t.id = q.id 
                            JOIN quote_author qa ON t.author_id=qa.id
                            JOIN quote_category qc ON t.category_id=qc.id
                            JOIN quote_author_type qat ON qa.author_type=qat.id';
     */
    $select = implode(' , ', $select);
    $join = implode(' JOIN ', $join);
    
    $this->query = 'SELECT  t.* '.$select.'
                        FROM    (
                                SELECT  id
                                FROM    '.$table_name.' '. $this->mysql->BuildSQLWhereClause($where) .'
                                ORDER BY
                                        '.$order_by.'
                                LIMIT '.$limit.'
                                ) q
                        JOIN    '.$table_name.' t
                        ON      t.id = q.id '.$join; 
    $this->result = $this->mysql->Query($this->query);
    $this->result = $this->mysql->RecordsArray();
  }
  public function getResult()
  {
    return $this->result;
  }
  public function getPagination( $internal_uri )
  {
    $html = '<ul class="pagination pagination-sm">';
    if($this->page != '1')
    {
      $html .= '<li class="">'.
        '<a href="'.$internal_uri.'?page=1" title="Go to first page.">'.
        'First'.'</a></li>';
      $html .= '<li class="">'.
        '<a href="'.$internal_uri.'?page='.($this->page - 1).'" title="Go to previous page.">'.
        'Previous'.'</a></li>';
    }
    for($i = $this->page - 3; $i <= $this->page + 3; $i++)
    {
      if($i >= 1 && $i <= $this->getLastPage() )
      {
        if($i == $this->page)
        {
          $html .= '<li class="active">'.'<a href="'.$internal_uri.'?page='.$i.'" title="Go to page '.$i.'">'. $i .'</a></li>';
        }
        else
        {
          $html .= '<li class="">'.'<a href="'.$internal_uri.'?page='.$i.'" title="Go to page '.$i.'">'. $i .'</a></li>';
        }
      }
    }
    if($this->page != $this->getLastPage())
    {
      $html .= '<li class="">'.
        '<a href="'.$internal_uri.'?page='.($this->page + 1).'" title="Go to next page.">'.
        'Next'.'</a></li>';
      $html .= '<li class="">'.
        '<a href="'.$internal_uri.'?page='.$this->getLastPage().'" title="Go to last page.">'.
        'Last'.'</a></li>';
    }
    $html .= '</ul>';
    return $html;
  }
  public function getLastPage()
  {
    return ceil($this->result_count / $this->per_page);
  }
  public function getMySQL()
  {
    return $this->mysql;
  }
}

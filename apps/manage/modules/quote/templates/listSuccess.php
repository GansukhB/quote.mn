<h1>Quotes <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('quote/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <a href="<?php echo url_for('quote/list') ?>" class="btn btn-primary"><i class="fa fa-list"></i> Жагсаалт</a>
<hr />
<?php
  $tmp_array = array();
  foreach($whereArray as $field => $value)
  {
    $tmp_array[$field] = $value;
  }
  $whereArray = $tmp_array;
?>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Body</th>
      <th>Author</th>
      <th>Category</th>
      <th>Created user</th>
      <th>Is top</th>
      <th>Is featured</th>
      <th>Is active</th>
      <th>Published at</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th style="width: 180px;"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($quotes as $quote): ?>
    <tr>
      <td><a href="<?php echo url_for('quote/edit?id='.$quote['id']) ?>"><?php echo $quote['id'] ?></a></td>
      <td><?php echo $quote['body'] ?></td>
      <td>
        <a href="<?php echo url_for('quote_author/edit?id='.$quote['author_id']); ?>" target="_blank">
        <?php echo AppConstants::getQuoteAuthor($quote['author_id'])->getTitle(); ?>
        </a>
        <a href="<?php echo url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array('author_id' => $quote['author_id']) );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('quote_category/edit?id='.$quote['category_id']); ?>" target="_blank">
        <?php echo AppConstants::getQuoteCategory($quote['category_id'])->getTitle(); ?>
        </a>
        <a href="<?php echo url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array('category_id' => $quote['category_id']) );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td><?php echo AppConstants::getUser($quote['created_user_id'])->getUsername(); ?></td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote&id='.$quote['id'].'&field=is_top') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote['is_top']) ?>
        </a>
        <a href="<?php echo url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array('is_top' => '1') );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote&id='.$quote['id'].'&field=is_featured') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote['is_featured']) ?>
        </a>
        <a href="<?php echo url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array('is_featured' => '1') );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote&id='.$quote['id'].'&field=is_active') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote['is_active']) ?>
        </a>
        <a href="<?php echo url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array('is_active' => '1') );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td><?php echo $quote['published_at'] ?></td>
      <td><?php echo $quote['created_at'] ?></td>
      <td><?php echo $quote['updated_at'] ?></td>
      <td>
	    <a href="<?php echo url_for('quote/edit?id='.$quote['id']) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Засварлах</a>
		  <a href="<?php echo url_for('quote/delete?id='.$quote['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
	  </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php  if(count($quotes) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('quote/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
<div class="text-center">
	<?php //echo pager_navigation($quotes, 'quote/index'  ) ?>
  <?php //echo html_entity_decode( $my_pager->getPagination(url_for(AppConstants::getFilterUrl($internal_url, $whereArray, array())) ) ) ?>
  <?php echo html_entity_decode( $my_pager->getPagination(url_for($internal_url). AppConstants::getFilterUrl('', $whereArray, array() ))); ?>
</div>


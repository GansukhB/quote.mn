<h1>Quote categorys <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('quote_category/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<hr />
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
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
    <?php foreach ($quote_categorys as $quote_category): ?>
    <tr>
      <td><a href="<?php echo url_for('quote_category/edit?id='.$quote_category['id']) ?>"><?php echo $quote_category['id'] ?></a></td>
      <td>
        <?php echo $quote_category['title'] ?>
        <a href="<?php echo url_for('quote/list'). AppConstants::getFilterUrl('', array(), array('category_id' => $quote_category['id']) );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td><?php echo AppConstants::getUser($quote_category['created_user_id'])->getUsername(); ?></td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_category&id='.$quote_category['id'].'&field=is_top') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_category['is_top']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_category&id='.$quote_category['id'].'&field=is_featured') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_category['is_featured']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_category&id='.$quote_category['id'].'&field=is_active') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_category['is_active']) ?>
        </a>
      </td>
      <td><?php echo $quote_category['published_at'] ?></td>
      <td><?php echo $quote_category['created_at'] ?></td>
      <td><?php echo $quote_category['updated_at'] ?></td>
      <td>
	    <a href="<?php echo url_for('quote_category/edit?id='.$quote_category['id']) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Засварлах</a>
		  <a href="<?php echo url_for('quote_category/delete?id='.$quote_category['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
	  </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php  if(count($quote_categorys) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('quote_category/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
<div class="text-center">
	<?php //echo pager_navigation($quote_categorys, 'quote_category/index'  ) ?>
  <?php echo html_entity_decode( $my_pager->getPagination(url_for('quote_category/index') ) ) ?>
</div>


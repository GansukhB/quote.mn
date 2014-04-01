<h1>Quote author types <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('quote_author_type/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
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
    <?php foreach ($quote_author_types as $quote_author_type): ?>
    <tr>
      <td><a href="<?php echo url_for('quote_author_type/edit?id='.$quote_author_type['id']) ?>"><?php echo $quote_author_type['id'] ?></a></td>
      <td><?php echo $quote_author_type['title'] ?></td>
      <td><?php echo AppConstants::getUser($quote_author_type['created_user_id'])->getUsername(); ?></td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author_type&id='.$quote_author_type['id'].'&field=is_top') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author_type['is_top']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author_type&id='.$quote_author_type['id'].'&field=is_featured') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author_type['is_featured']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author_type&id='.$quote_author_type['id'].'&field=is_active') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author_type['is_active']) ?>
        </a>
      </td>
      <td><?php echo $quote_author_type['published_at'] ?></td>
      <td><?php echo $quote_author_type['created_at'] ?></td>
      <td><?php echo $quote_author_type['updated_at'] ?></td>
      <td>
	    <a href="<?php echo url_for('quote_author_type/edit?id='.$quote_author_type['id']) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Засварлах</a>
		  <a href="<?php echo url_for('quote_author_type/delete?id='.$quote_author_type['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
	  </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php  if(count($quote_author_types) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('quote_author_type/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
<div class="text-center">
	<?php //echo pager_navigation($quote_author_types, 'quote_author_type/index'  ) ?>
  <?php echo html_entity_decode( $my_pager->getPagination(url_for('quote_author_type/index') ) ) ?>
</div>


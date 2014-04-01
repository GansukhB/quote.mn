<h1>Quote authors <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('quote_author/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<hr />
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Bio</th>
      <th>Link</th>
      <th>Author type</th>
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
    <?php foreach ($quote_authors as $quote_author): ?>
    <tr>
      <td><a href="<?php echo url_for('quote_author/edit?id='.$quote_author['id']) ?>"><?php echo $quote_author['id'] ?></a></td>
      <td>
        <?php echo $quote_author['title'] ?>
        <a href="<?php echo url_for('quote/list'). AppConstants::getFilterUrl('', array(), array('author_id' => $quote_author['id']) );  ?>" class="btn btn-block btn-xs btn-default">
          &nbsp;<i class="fa fa-filter"></i>&nbsp;
        </a>
      </td>
      <td><?php echo $quote_author['bio'] ?></td>
      <td><?php echo $quote_author['link'] ?></td>
      <td>
        <a href="<?php echo url_for('quote_author_type/edit?id='.$quote_author['author_type']) ?>" target="_blank">
          <?php echo AppConstants::getQuoteAuthorType($quote_author['author_type'])->getTitle(); ?>
        </a>
      </td>
      <td><?php echo AppConstants::getUser($quote_author['created_user_id'])->getUsername(); ?></td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author&id='.$quote_author['id'].'&field=is_top') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author['is_top']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author&id='.$quote_author['id'].'&field=is_featured') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author['is_featured']) ?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('system/changestate?model_name=quote_author&id='.$quote_author['id'].'&field=is_active') ; ?>" class="btn btn-default">
        <?php echo AppConstants::getBooleanIcon($quote_author['is_active']) ?>
        </a>
      </td>
      <td><?php echo $quote_author['published_at'] ?></td>
      <td><?php echo $quote_author['created_at'] ?></td>
      <td><?php echo $quote_author['updated_at'] ?></td>
      <td>
	    <a href="<?php echo url_for('quote_author/edit?id='.$quote_author['id']) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Засварлах</a>
		  <a href="<?php echo url_for('quote_author/delete?id='.$quote_author['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
	  </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php  if(count($quote_authors) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('quote_author/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
<div class="text-center">
	<?php //echo pager_navigation($quote_authors, 'quote_author/index'  ) ?>
  <?php echo html_entity_decode( $my_pager->getPagination(url_for('quote_author/index') ) ) ?>
</div>


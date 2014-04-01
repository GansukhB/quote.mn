<?php use_helper('Pagination') ?>
<?php use_helper('Custom') ?>
<h1>Мэдээ <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('post/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<hr />
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th style="min-width: 120px;">Ангилал</th>
      <th>Гарчиг</th>
      <th>Идэвхитэй эсэх</th>
      <th>Нүүрэнд онцлох</th>
      <th>Онцлох</th>
      <th>Нийтлэгч</th>
      <th>Нийтэлсэн огноо</th>
	  <th style="width: 140px;"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($posts as $post): ?>
    <tr>
      <td><a href="<?php echo url_for('post/edit?id='.$post->getId()) ?>"><?php echo $post->getId() ?></a></td>
      <td>
        <?php $categories = AppTools::getCategories('Post', $post->getId()); ?>
        <?php if(count($categories)): ?>
            <?php foreach($categories as $index => $category): ?>
                <a href="<?php echo url_for('post/index?category_id='.$category->getId()); ?>"><?php echo $category->getTitle(); ?></a>

                <?php if($index != count($categories) - 1) echo ',<br />'; ?>
            <?php endforeach; ?>
        <?php else: ?>
                <a href="<?php echo url_for('post/index?category_id=0'); ?>">Ангилалгүй</a>
        <?php endif; ?>
      
      </td>
      <td><?php echo $post->getTitle() ?></td>
      <td>
          <a href="<?php echo url_for('post/changestate?id='.$post->getId().'&field=is_active') ; ?>" class="btn btn-default">
          <?php echo AppConstants::getBooleanIcon($post->getIsActive()) ?>
          </a>
      </td>
      <td>
          <a href="<?php echo url_for('post/changestate?id='.$post->getId().'&field=is_top') ; ?>" class="btn btn-default">
            <?php echo AppConstants::getBooleanIcon($post->getIsTop()) ?>
          </a>
      </td>
      <td>
          <a href="<?php echo url_for('post/changestate?id='.$post->getId().'&field=is_featured') ; ?>" class="btn btn-default">
            <?php echo AppConstants::getBooleanIcon($post->getIsFeatured()) ?>
          </a>      
      </td>
      <td><?php echo $post->getUser()->getUsername(); ?></td>
      <td><?php echo $post->getPublishedAt() ?></td>
      <td>
        <a href="#" class="btn btn-primary btn-xs btn-block"><i class="fa fa-copy"></i> Харах</a> 
        <a href="#" class="btn btn-info btn-xs btn-block"><i class="fa fa-comment-o"></i> Сэтгэгдэл</a>
	<a href="<?php echo url_for('post/edit?id='.$post->getId()) ?>" class="btn btn-warning btn-xs btn-block"><i class="fa fa-edit"></i> Засварлах</a>
        <a href="<?php echo url_for('post/delete?id='.$post->getId()) ?>" class="btn btn-danger btn-xs btn-block" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
        
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php  if(count($posts) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('post/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
<div class="text-center">
	<?php echo pager_navigation($posts, 'post/index'  ) ?>
</div>


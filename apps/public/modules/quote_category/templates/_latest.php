<div class="panel panel-primary">
  <div class="panel-heading">
    Categories recently added
  </div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <?php foreach($categories as $category): ?>
      <li><a href="<?php echo url_for('@category_show?id='.$category->getId().'&slug='.PublicTools::url_slug($category->getTitle())); ?>" title="<?php echo $category->getTitle(); ?> quotes"><?php echo $category->getTitle(); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <a href="<?php echo url_for('quote_category/index'); ?>" class="btn btn-block btn-xs btn-default" title="See all categories">More</a>
  </div>
</div>
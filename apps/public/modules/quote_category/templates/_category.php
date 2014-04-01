<div class="panel panel-default">
  <div class="panel-heading">
    Quote categories
  </div>
  <div class="panel-body">
    <div class="row">
      <ul class="list-inline">
        <?php foreach($categories as $category): ?>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <li><a href="<?php echo url_for('@category_show?id='.$category->getId().'&slug='.PublicTools::url_slug($category->getTitle())); ?>" title="<?php echo $category->getTitle(); ?> quotes"><?php echo $category->getTitle(); ?></a></li>
        </div>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
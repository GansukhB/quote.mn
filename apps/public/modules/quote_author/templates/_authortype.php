<div class="panel panel-default">
  <div class="panel-heading">
    Author professions
  </div>
  <div class="panel-body">
    <div class="row">
      <ul class="list-unstyled">
      <?php foreach($author_types as $author_type): ?>
        <div class="col-sm-6 col-xs-6">
          <li><a href="<?php echo url_for('@quote_author_t?author_type='.$author_type->getId().'&slug='.PublicTools::url_slug($author_type->getTitle())) ?>" title="<?php echo $author_type->getTitle(); ?> list">
          <?php echo $author_type->getTitle(); ?></a></li>
        </div>
      <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
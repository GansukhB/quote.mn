<div class="panel panel-primary">
  <div class="panel-heading">
    Authors recently added
  </div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <?php foreach($authors as $author): ?>
      <li><a href="<?php echo url_for('@quote_author_show?id='.$author->getId().'&slug='.PublicTools::url_slug($author->getTitle())); ?>" title="<?php echo $author->getTitle(); ?> quotes"><?php echo $author->getTitle(); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <a href="<?php echo url_for('quote_author/index'); ?>" class="btn btn-block btn-xs btn-default" title="See all authors">More</a>
  </div>
</div>
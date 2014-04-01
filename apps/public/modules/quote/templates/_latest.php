<div class="panel panel-primary">
  <div class="panel-heading">
    Latest quotes
  </div>
  <div class="panel-body">
    <?php if($quotes_count > 0 ): ?>
      <?php foreach($quotes as $quote): ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <blockquote class="blockquote-reverse" style="margin-bottom: 0;">
            <a href="<?php echo url_for('@quote_show?id='.$quote['id'].'&slug='. PublicTools::url_slug(mb_substr(html_entity_decode($quote['body']), 0, 40, 'UTF-8') ) ); ?>" class="link-black" title="<?php echo $quote['body']; ?>">
            <?php echo $quote['body']; ?>
              
            </a>
            
            <footer>
              <cite title="Go to author page">
                <?php 
                  $author = AppConstants::getQuoteAuthor($quote['author_id']);
                ?>
                <a href="<?php echo url_for('@quote_author_show?id='.$author->getId().'&slug='.PublicTools::url_slug($author->getTitle())); ?>" title="View author <?php echo $author->getTitle(); ?>"><?php echo $author->getTitle(); ?></a>
              </cite> 
            </footer>
          </blockquote>
        </div>
      </div>
      <?php endforeach; ?>
    <a href="<?php echo url_for('quote/index'); ?>" class="btn btn-block btn-xs btn-default" title="See all quotes">More</a>
      <?php else: ?>
      <div class="alert alert-info">
        <i class="fa fa-warning"></i> Here is no quotes under your request.
      </div>
      <?php endif; ?>
  </div>
</div>
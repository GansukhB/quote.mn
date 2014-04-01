<?php if($quote): ?>
<div class="panel panel-default">
  <div class="panel-heading">
    Quote of the day
  </div>
  <div class="panel-body">
    <blockquote class="blockquote-reverse" style="margin-bottom: 0;">
      <a href="<?php echo url_for('@quote_show?id='.$quote->getId().'&slug='. PublicTools::url_slug(mb_substr(html_entity_decode($quote->getBody()), 0, 40, 'UTF-8') ) ); ?>" class="link-black" title="<?php echo $quote['body']; ?>">
      <?php echo $quote->getBody(); ?>

      </a>

      <footer>
        <cite title="Go to author page">
          <?php 
            $author = AppConstants::getQuoteAuthor($quote->getAuthorId());
          ?>
          <a href="<?php echo url_for('@quote_author_show?id='.$quote->getAuthorId().'&slug='.PublicTools::url_slug($author->getTitle())); ?>" title="View author <?php echo $author->getTitle(); ?>"><?php echo $author->getTitle(); ?></a>
        </cite> 
      </footer>
    </blockquote>
  </div>
</div>
<?php endif; ?>
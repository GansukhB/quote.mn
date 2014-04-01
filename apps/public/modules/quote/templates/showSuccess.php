<?php use_helper('My'); ?>
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-8 col-lg-7">
        <div class="panel panel-default">
          <div class="panel-body">
            <article>
            <blockquote class="blockquote-reverse" style="font-size: 150%;">
              <?php echo $quote->getBody(); ?>
              <footer>
                <cite title="Source Title">
                  <a href="<?php echo url_for('@quote_author_show?id='.$quote_author->getId().'&slug='.PublicTools::url_slug($quote_author->getTitle())); ?>">
                    <?php echo $quote_author->getTitle(); ?>
                  </a>
                </cite> <?php echo AppConstants::getQuoteAuthorType($quote_author->getAuthorType())->getTitle(); ?> 
              </
            </blockquote>
            </article>
            <hr>
            <div class="col-sm-6">
              <span class="text-muted">Category: </span>
              <a href="<?php echo url_for('@category_show?id='.$quote_category->getId().'&slug='.PublicTools::url_slug($quote_category->getTitle())); ?>" title="More from this category: <?php echo $quote_category->getTitle(); ?>" target="_blank">
                <?php echo $quote_category->getTitle() ?>
              </a><br />
              <span class="text-muted">
                Published at: 
                <time><?php echo $quote->getPublishedAt() ?></time>
              </span>
              
            </div>
            
            <div class="col-sm-6 text-right">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_google_plusone_share"></a>
                </div>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4de827332cfbe4db"></script>
                <!-- AddThis Button END -->
            </div>
             

            <script>
              $(function () {
                $('#navTab a:last').tab('show')
              })
            </script>
            
          </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-5">
      <?php include_component('quote_author', 'bio', array('author' => $quote_author)); ?>
      <?php include_partial('system/ads_chitka') ?>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php include_component('quote_category', 'category'); ?>
    </div>
  </div>
</div>
<?php slot('og') ?>
<meta property="og:title" content="<?php echo $sf_response->getTitle();  ?>" />
<meta property="og:description" content="<?php echo $quote->getBody(); //$sf_response->getMetas()->get('description')  ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo curPageURL(); ?>" />
<meta property="og:image" content="<?php echo curDomainURL(); ?>/images/og.jpg" />
<?php end_slot(); ?>
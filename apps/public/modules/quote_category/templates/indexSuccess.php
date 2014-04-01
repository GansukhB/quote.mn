<?php use_helper('My'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="page-header">Categories</h1>
    </div>
  </div>
  <div class="row">
    
    <div class="col-sm-12 ">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
          <?php foreach($quote_categorys as $quote_category): ?>
          <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
            <a href="<?php echo url_for('@category_show?id='.$quote_category['id'].'&slug='.PublicTools::url_slug($quote_category['title'])); ?>" title="<?php echo $quote_category['title']. ' quotes'; ?>">
              <?php echo $quote_category['title']; ?>
            </a>
          </div>
          <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php slot('og') ?>
<meta property="og:title" content="<?php echo $sf_response->getTitle();  ?>" />
<meta property="og:description" content="<?php echo $sf_response->getMetas()->get('description')  ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo curPageURL(); ?>" />
<meta property="og:image" content="<?php echo curDomainURL(); ?>/images/og.jpg" />
<?php end_slot(); ?>
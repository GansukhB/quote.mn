<?php use_helper('My'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-xs-12">
          <?php include_component('quote', 'top'); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <?php include_component('quote_category', 'latest', array('limit' => 20  )); ?>
        </div>
        <div class="col-sm-6">
          <?php include_component('quote_author', 'latest', array('limit' => 20  )); ?>
        </div>
        <div class="col-sm-12">
          <?php include_partial('system/ads_chitka') ?>
        </div>
        <div class="col-sm-12">
          <?php include_partial('global/fb_likebox') ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <?php include_component('quote', 'latest', array('per_page' => 8  )); ?>
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

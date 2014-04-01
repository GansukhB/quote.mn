<?php use_helper('My'); ?>
<?php use_helper('Pagination'); ?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php echo $page_title; ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-8 col-lg-7">
      <?php if($quotes_count > 0 ): ?>
      <?php foreach($quotes as $quote): ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <blockquote class="blockquote-reverse">
            <a href="<?php echo url_for('@quote_show?id='.$quote['id'].'&slug='. PublicTools::url_slug(mb_substr(html_entity_decode($quote['body']), 0, 40, 'UTF-8') ) ); ?>" class="link-black" title="<?php echo $quote['body']; ?>">
            <?php echo $quote['body']; ?>
              
            </a>
            
            <footer>
              <cite title="Go to author page">
                <a href="<?php echo url_for('@quote_author_show?id='.$quote['author_id'].'&slug='.PublicTools::url_slug($quote['quote_author_title'])); ?>" title="View author <?php echo $quote['quote_author_title']?>"><?php echo $quote['quote_author_title']; ?></a>
              </cite> 
            </footer>  
          </blockquote>
        </div>
        <div class="panel-heading">
          <div class="pull-left">
            <span class="text-muted">Category :</span> 
            <?php $quote_url = url_for('@quote_show?id='.$quote['id'].'&slug='. PublicTools::url_slug(mb_substr(html_entity_decode($quote['body']), 0, 40, 'UTF-8') ) ); ?>
            <a href="<?php echo $quote_url; ?>" title="<?php echo $quote['quote_category_title'] ?> quotes"><?php echo $quote['quote_category_title'] ?></a><br />
            <span class="text-muted">Published at : <time><?php echo $quote['published_at']; ?></time></span>
          </div>
          <div class="pull-right">
            <span class="text-muted">
              
              <div class="fb-like" data-href="<?php echo $quote_url;  ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
            </span>
            <?php if($sf_user->isAuthenticated()): ?>
            <a href="/manage.php/quote/edit?id=<?php echo $quote['id']; ?>">Edit</a>
            <?php endif; ?>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="text-center">
        <?php //echo html_entity_decode( $my_pager->getPagination(url_for('@category_show?id='.$sf_params->get('id').'&slug='.$sf_params->get('slug')) ) ); ?>
        <?php echo html_entity_decode( $my_pager->getPagination(url_for(html_entity_decode($page_route))) ) ; ?>
      </div>
      <?php else: ?>
      <div class="alert alert-info">
        <i class="fa fa-warning"></i> Here is no quotes under your request.
      </div>
      <?php endif; ?>
    </div>
    <div class="visible-sm visible-xs">
      <div class="clearfix"></div>
    </div>
    <div class="col-md-4 col-lg-5">
      <?php if($sf_params->get('module') == 'quote_author' && $sf_params->get('action') == 'show') include_component('quote_author', 'bio', array('author' => $author)) ?>
      <?php include_component('quote_author', 'latest', array('limit' => 20  )); ?>
      <?php include_partial('global/fb_likebox') ?>
      <?php include_component('quote_category', 'latest', array('limit' => 20  )); ?>
      <?php include_partial('system/ads_chitka') ?>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php if($sf_params->get('module') == 'quote_category' && $sf_params->get('action') == 'show' || $sf_params->get('module') == 'quote') include_component('quote_category', 'category'); ?>
    </div>
  </div>
</div>
<?php slot('og') ?>
<meta property="og:title" content="<?php echo $page_title;  ?>" />
<meta property="og:description" content="<?php echo $sf_response->getMetas()->get('description')  ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo curPageURL(); ?>" />
<meta property="og:image" content="<?php echo curDomainURL(); ?>/images/og.jpg" />
<?php end_slot(); ?>
<?php use_helper('My'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="page-header"><?php echo $page_title; ?></h1>
      <div class="row">
        <div class="col-sm-7">
          <div class="row">
            <?php if($quote_authors_count > 0):  ?>
            <ul class="list-inline">
            <?php foreach($quote_authors as $quote_author): ?>
            <div class="col-xs-6">
              <li><a href="<?php echo url_for('@quote_author_show?id='.$quote_author['id'].'&slug='.PublicTools::url_slug($quote_author['title'])); ?>" title="<?php echo $quote_author['title'] ?> quotes"><?php echo $quote_author['title'] ?></a></li>
            </div>
            <?php endforeach; ?>
            </ul>
            <div class="clearfix"></div>
            <div class="text-center">
            <?php echo html_entity_decode( $my_pager->getPagination(url_for(html_entity_decode($page_route))) ) ; ?>
            </div>
            <?php else:  ?>
            <div class="col-md-12">
            <div class="alert alert-info">
              <i class="fa fa-info"></i> Authors not found you requested.
            </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-sm-5">
          <?php include_component('quote_author', 'authortype'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="breadcrumb">
  <div class="container">
    <div class="row">
        <ol class="breadcrumb" style="margin-bottom: 0;">
        <li><a href="<?php echo url_for('@homepage'); ?>"><i class="fa fa-home"></i> Home</a></li>
        <?php if($sf_params->get('module') == 'quote_category'): ?>
        <li <?php echo $sf_params->get('action') == 'index' ? 'class="active"' : ''; ?>><a href="<?php echo url_for('quote_category/index'); ?>">Quote category</a></li>
          <?php if($sf_params->get('id') && $category = QuoteCategoryTable::getInstance()->find($sf_params->get('id'))): ?>
            
        <li><a href="<?php echo url_for('@category_show?id='.$category->getId().'&slug='.PublicTools::url_slug($category->getTitle())); ?>"><?php echo $category->getTitle(); ?></a></li>
            
          <?php endif; ?>
        <?php endif; ?>
        <?php if($sf_params->get('module') == 'quote'): ?>
        <li><a href="<?php echo url_for('quote/index'); ?>">Quotes</a></li>
        <?php endif; ?>
        <?php if($sf_params->get('module') == 'quote_author'): ?>
        <li><a href="<?php echo url_for('quote_author/index'); ?>">Authors</a></li>
        <?php endif; ?>
        </ol>
    </div>
  </div>
</div>
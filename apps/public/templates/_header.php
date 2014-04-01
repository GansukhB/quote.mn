<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo url_for('@homepage'); ?>">"mn</a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li <?php echo $sf_params->get('module') == 'system' && $sf_params->get('action') == 'index' ? 'class="active"' : ''; ?>><a href="<?php echo url_for('@homepage'); ?>">Home</a></li>
              <li <?php echo $sf_params->get('module') == 'quote' ? 'class="active"' : ''; ?>><a href="<?php echo url_for('quote/index'); ?>">Quotes</a></li>
              <li <?php echo $sf_params->get('module') == 'quote_category' ? 'class="active"' : ''; ?>><a href="<?php echo url_for('category/index'); ?>">Categories</a></li>
              <li <?php echo $sf_params->get('module') == 'quote_author' ? 'class="active"' : ''; ?>><a href="<?php echo url_for('quote_author/index'); ?>">Authors</a></li>
              
            </ul>
            
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </div>
    </div>
  </div>
</nav>
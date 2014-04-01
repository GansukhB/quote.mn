<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php include_stylesheets() ?>
    <?php include_slot('og'); ?>
  </head>
  <body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=696313780410353";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <?php include_partial('global/header'); ?>
    <?php include_partial('global/breadcrumb'); ?>
    <?php echo $sf_content ?>
    <?php include_partial('global/footer'); ?>
    <?php include_javascripts() ?>
    <?php include_partial('global/analytics'); ?>
  </body>
</html>

<?php foreach($urls as $url): ?>
  <url>
    <loc>http://quote.mn/<?php echo $type ?>/<?php echo $url->getId() ?>/<?php echo PublicTools::url_slug($url->getTitle()) ?></loc>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>

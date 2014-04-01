<?php use_helper('PageTree'); ?>

<h1>Үндсэн цэс / Хуудас <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('page/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<hr />
<style>

</style>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Үндсэн цэс
            </div>
            <div class="panel-body">
                <div class="box-menu-tree">
                    <?php
                        $page_tree = new PageTree();
                        echo $page_tree->getTree($pages_menu); 
                    ?>
                    
                    <?php 
                        $hidden_pages = $page_tree->getPagePut($pages_menu);
                        if(count($hidden_pages)):
                    ?>
                    <hr />
                    <h5>Үндэс цэс нь далдлагдсан</h5>
                    <div class="clearfix"></div>
                    <div class="box-menu-tree">
                    <?php foreach($hidden_pages as $page): ?>
                        <li><div class="box-menu-list"><?php echo $page->getTitle(); ?> <div class="pull-right"><a href="<?php echo url_for('module_page/edit?site_id='.$sf_params->get('site_id').'&id='.$page->getId()); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>Засварлах</a></div></div></li>
                    <?php endforeach;?>
                    </div>
                    <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Үндсэн цэсний архивлагдсан хуудсууд
            </div>
            <div class="panel-body">
                <div class="box-menu-tree">
                    <?php foreach($pages_menu_draft as $page): ?>
                        <li><div class="box-menu-list"><?php echo $page->getTitle(); ?> <div class="pull-right"><a href="<?php echo url_for('page/edit?id='.$page->getId()); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>Засварлах</a></div></div></li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Үндсэн цэснээс далдлагдан хуудсууд
            </div>
            <div class="panel-body">
                <div class="box-menu-tree">
                    <?php foreach($pages_hidden as $page): ?>
                        <li><div class="box-menu-list"><?php echo $page->getTitle(); ?> <div class="pull-right"><a href="<?php echo url_for('page/edit?id='.$page->getId()); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>Засварлах</a></div></div></li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Үндсэн цэснээс далдлагдан идэвхигүй хуудсууд
            </div>
            <div class="panel-body">
                <div class="box-menu-tree">
                    <?php foreach($pages_hidden_draft as $page): ?>
                        <li><div class="box-menu-list"><?php echo $page->getTitle(); ?> <div class="pull-right"><a href="<?php echo url_for('page/edit?id='.$page->getId()); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>Засварлах</a></div></div></li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
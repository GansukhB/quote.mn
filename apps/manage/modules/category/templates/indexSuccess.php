<?php use_helper('Custom'); ?>
<?php use_helper('CategoryTree'); ?>

<h1><?php echo $sf_params->get('model_name') == 'post' ? 'Мэдээний' : ''; ?> ангилал <small>Жагсаалт</small></h1>
<hr />
  <a href="<?php echo url_for('category/new?model_name=post') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<hr />
    <div class="row">
        <div class="col-sm-6">
                    
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ангилалууд
                </div>
                <div class="panel-body">
                    <div class="box-menu-tree">
                        <?php echo getModuleCategoryTree('post', $categorys); ?>
                    </div>
                    <i class="fa fa-check-square-o"></i> Идэвхитэй ангилал
                </div>
                    
            </div>
        </div>
        <?php 
            $category_array = array('edit', 'create', 'update', 'new');
            $form_show = in_array($sf_params->get('action'), $category_array);
        ?>
        <?php if($form_show): ?>
        <div class="col-sm-6">
                    
            <div class="panel panel-default">
                <div class="panel-heading">
                    Шинээр нэмэх
                </div>
                <div class="panel-body">
                    <?php include_partial('form', array('form' => $form)) ?>
                </div>
                    
            </div>
        </div>
        <?php endif; ?>
    </div>

<?php  if(count($categorys) == 0): ?>
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
    <a href="<?php echo url_for('category/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  </div>
<?php  endif; ?>
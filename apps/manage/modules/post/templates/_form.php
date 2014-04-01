  <a href="<?php echo url_for('post/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
  <a href="<?php echo url_for('post/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <hr />

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script>
    $(window).load(function(){
        
        $("#id_artist_id").chosen({
             allow_single_deselect: true
        });
        
            
    });
</script>
  
<form action="<?php echo url_for('post/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="table table-bordered table-striped">

    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      
      
      <tr>
        <th><?php echo $form['category']->renderLabel() ?></th>
        <td>
          <div class="form-group">  
            <?php echo $form['category']->renderError() ?>
            <?php echo $form['category']->render(array('class' => '')); ?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['front_image']->renderLabel() ?></th>
        <td>
            <?php 
                if($form->getObject()->getFrontImage()): 
                $front_image_path = sfConfig::get('sf_upload_dir').'/posts/'.AppTools::getYearMonthText($form->getObject()->getCreatedAt()).'/'.$form->getObject()->getFrontImage();
                
            ?>
            <img id="front_image_view" src="/<?php echo Image::open($front_image_path)->resize(300, null)->jpeg(); ?>" class="img-thumbnail img-responsive" alt="" />
            <?php else: ?>
            <img id="front_image_view" src="" class="img-thumbnail img-responsive" style="display: none;" alt="" />
            <?php endif; ?>
          <?php echo $form['front_image']->renderError() ?>
          <?php echo $form['front_image']->render(array('class' => '', 'onchange' => "readURL(this, 'front_image_view');")); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['short_body']->renderLabel() ?></th>
        <td>
          <?php echo $form['short_body']->renderError() ?>
          <?php echo $form['short_body']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['body']->renderLabel() ?></th>
        <td>
          <?php echo $form['body']->renderError() ?>
          <?php echo $form['body']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_active']->renderError() ?>
          <?php echo $form['is_active']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_commentable']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_commentable']->renderError() ?>
          <?php echo $form['is_commentable']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_featured']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_featured']->renderError() ?>
          <?php echo $form['is_featured']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_top']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_top']->renderError() ?>
          <?php echo $form['is_top']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['published_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['published_at']->renderError() ?>
          <?php echo $form['published_at']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <a href="<?php echo url_for('post/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', 'post/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?>
          <?php endif; ?>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Хадгалах</button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>


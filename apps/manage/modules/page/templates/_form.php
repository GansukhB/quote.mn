  <a href="<?php echo url_for('page/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
  <a href="<?php echo url_for('page/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <hr />

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('page/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="table table-bordered table-striped">

    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['parent_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['parent_id']->renderError() ?>
          <?php echo $form['parent_id']->render(array('class' => 'form-control')); ?>
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
          <?php echo $form['front_image']->renderError() ?>
          <?php echo $form['front_image']->render(array('class' => 'form-control')); ?>
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
        <th><?php echo $form['is_link']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_link']->renderError() ?>
          <?php echo $form['is_link']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['link']->renderLabel() ?></th>
        <td>
          <?php echo $form['link']->renderError() ?>
          <?php echo $form['link']->render(array('class' => 'form-control')); ?>
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
        <th><?php echo $form['is_in_menu']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_in_menu']->renderError() ?>
          <?php echo $form['is_in_menu']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <a href="<?php echo url_for('page/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', 'page/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?>
          <?php endif; ?>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Хадгалах</button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>

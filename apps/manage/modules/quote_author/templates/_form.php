  <a href="<?php echo url_for('quote_author/new') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <hr />

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('quote_author/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="table table-bordered table-striped">

    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['bio']->renderLabel() ?></th>
        <td>
          <?php echo $form['bio']->renderError() ?>
          <?php echo $form['bio']->render(array('class' => 'form-control')); ?>
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
        <th><?php echo $form['author_type']->renderLabel() ?></th>
        <td>
          <?php echo $form['author_type']->renderError() ?>
          <?php echo $form['author_type']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_user_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_user_id']->renderError() ?>
          <?php echo $form['created_user_id']->render(array('class' => 'form-control')); ?>
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
        <th><?php echo $form['is_featured']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_featured']->renderError() ?>
          <?php echo $form['is_featured']->render(array('class' => 'form-control')); ?>
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
        <th><?php echo $form['published_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['published_at']->renderError() ?>
          <?php echo $form['published_at']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <a href="<?php echo url_for('quote_author/index') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', 'quote_author/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?>
          <?php endif; ?>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Хадгалах</button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>

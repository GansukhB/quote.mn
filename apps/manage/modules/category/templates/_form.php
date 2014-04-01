<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('category/'.($form->getObject()->isNew() ? 'create' : 'update').'?model_name='.$sf_params->get('model_name').(!$form->getObject()->isNew() ? '&id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
        <th><?php echo $form['is_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_active']->renderError() ?>
          <?php echo $form['is_active']->render(array('class' => 'form-control')); ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', 'category/delete?id='.$form->getObject()->getId().'&model_name='.$sf_params->get('model_name'), array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?>
          <?php endif; ?>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Хадгалах</button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>

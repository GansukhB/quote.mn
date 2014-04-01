<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
  <a href="[?php echo url_for('<?php echo $this->getUrlForAction('new') ?>') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<?php else: ?>
  <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/new') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<?php endif; ?>
  <hr />

[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<?php $form = $this->getFormObject() ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
<?php else: ?>
<form action="[?php echo url_for('<?php echo $this->getModuleName() ?>/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?> : '')) ?]" method="post" [?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?]>
[?php if (!$form->getObject()->isNew()): ?]
<input type="hidden" name="sf_method" value="put" />
[?php endif; ?]
<?php endif;?>
  <table class="table table-bordered table-striped">

    <tbody>
<?php if (isset($this->params['non_verbose_templates']) && $this->params['non_verbose_templates']): ?>
      [?php echo $form ?]
<?php else: ?>
      [?php echo $form->renderGlobalErrors() ?]
<?php foreach ($form as $name => $field): if ($field->isHidden()) continue ?>
      <tr>
        <th>[?php echo $form['<?php echo $name ?>']->renderLabel() ?]</th>
        <td>
          [?php echo $form['<?php echo $name ?>']->renderError() ?]
          [?php echo $form['<?php echo $name ?>']->render(array('class' => 'form-control')); ?]
        </td>
      </tr>
<?php endforeach; ?>
<?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
<?php if (!isset($this->params['non_verbose_templates']) || !$this->params['non_verbose_templates']): ?>
          [?php echo $form->renderHiddenFields(false) ?]
<?php endif; ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
          <a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
<?php else: ?>
          <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index') ?]" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Жагсаалт руу буцах</a>
<?php endif; ?>
          [?php if (!$form->getObject()->isNew()): ?]
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
            [?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?]
<?php else: ?>
            [?php echo link_to('<i class="fa fa-trash-o"></i> Устгах', '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => 'Устгах уу?', 'class'=>'btn btn-danger')) ?]
<?php endif; ?>
          [?php endif; ?]
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Хадгалах</button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>

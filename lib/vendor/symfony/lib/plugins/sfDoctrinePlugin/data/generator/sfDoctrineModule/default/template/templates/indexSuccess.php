<h1><?php echo sfInflector::humanize($this->getPluralName()) ?> <small>Жагсаалт</small></h1>
<hr />
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
  <a href="[?php echo url_for('<?php echo $this->getUrlForAction('new') ?>') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<?php else: ?>
  <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/new') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
<?php endif; ?>
<hr />
<table class="table table-bordered table-striped">
  <thead>
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
      <th><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?></th>
<?php endforeach; ?>
      <th style="width: 180px;"></th>
    </tr>
  </thead>
  <tbody>
    [?php foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): ?]
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
<?php if ($column->isPrimaryKey()): ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
      <td><a href="[?php echo url_for('<?php echo $this->getUrlForAction(isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit') ?>', $<?php echo $this->getSingularName() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>['<?php echo $column->getPhpName() ?>'] ?]</a></td>
<?php else: ?>
      <td><a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/<?php echo isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit' ?>?<?php echo $this->getPrimaryKeys(1) ?>='.$<?php echo $this->getSingularName()."['".$this->getPrimaryKeys(1)."']" ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>['<?php echo $column->getPhpName() ?>'] ?]</a></td>
<?php endif; ?>
<?php else: ?>
      <td>[?php echo $<?php echo $this->getSingularName() ?>['<?php echo $column->getPhpName() ?>'] ?]</td>
<?php endif; ?>
<?php endforeach; ?>
      <td>
	    <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeys(1) ?>='.$<?php echo $this->getSingularName()."['".$this->getPrimaryKeys(1)."']" ?>) ?]" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Засварлах</a>
		  <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeys(1) ?>='.$<?php echo $this->getSingularName()."['".$this->getPrimaryKeys(1)."']" ?>) ?]" class="btn btn-danger btn-xs" onclick="return confirm('Устгах уу?');"><i class="fa fa-trash-o"></i> Устгах</a>
	  </td>
    </tr>
    [?php endforeach; ?]
  </tbody>
</table>
[?php  if(count($<?php echo $this->getPluralName() ?>) == 0): ?]
<div class="well">
  Агуулга бичигдээгүй байна. 
  <br /><br />
  <div class="clearfix"></div>
  <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
  <a href="[?php echo url_for('<?php echo $this->getUrlForAction('new') ?>') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <?php else: ?>
  <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/new') ?]" class="btn btn-success"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
  <?php endif; ?>
</div>
[?php  endif; ?]
<div class="text-center">
	[?php //echo pager_navigation($<?php echo $this->getPluralName() ?>, '<?php echo $this->getModuleName() ?>/index'  ) ?]
  [?php echo html_entity_decode( $my_pager->getPagination(url_for('<?php echo $this->getSingularName() ?>/index') ) ) ?]
</div>


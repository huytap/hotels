<?php
$this->breadcrumbs = array(
    'Promotions',
);
$this->menu=array(
	array('label'=>'Create new promotion', 'url'=>array('create')),
);?>
<div class="panel panel-default">
    <div class="panel-heading">Promotion Control</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
	</div>
</div>
<script type="text/javascript">
    $('table').addClass('table-bordered');
</script>
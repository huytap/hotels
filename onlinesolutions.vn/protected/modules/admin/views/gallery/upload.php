<?php
$this->breadcrumbs=array(
	'Photos' => array('admin')
);?> 
<div class="panel panel-default">
    <div class="panel-heading">Upload More</div>
    <div class="panel-body">
    	<?php
$form = $this->beginWidget('CActiveForm', array(
'id' => 'category-form',
'enableClientValidation' => true,
'htmlOptions' => array(
    'class' => 'no-margin',
    'enctype' => 'multipart/form-data',
    ),
));?>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">       
                <lebel>Photos</lebel>
                <input type="hidden" name="Gallery[id]" value="<?php echo $model['id']?>">
                <input multiple="" type="file" name="items[]" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-info" type="submit">
                <i class="icon-ok bigger-110"></i>
                Submit
            </button>
        </div>
    </div>
<?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->breadcrumbs = array(
    'Promotions',
);
?>
<div class="row">
	<div class="col-sm-12">
	  	<div class="pull-right">
	  		<div class="dropdown">
			  	<button class="btn btn-warning btn-block dropdown-toggle" type="button" data-toggle="dropdown" style="padding:7px 20px;">Add New Promotion
			  	<span class="caret"></span></button>
			  	<ul class="dropdown-menu">
			  	<?php
			  	$type = Yii::app()->params['promotion_type'];
			  	foreach($type as $key => $ty){
			  		echo '<li><a href="'.Yii::app()->createUrl('admin/promotion/create', array('type' => $key)).'">'.$ty.'</a></li>';
			  	}
			  	?>
			  	</ul>
			</div>
	  	</div>
	</div>
</div>
<style type="text/css">
	.panel-heading .accordion-toggle:after {
	    font-family: 'Glyphicons Halflings';
	    content: "\e114";
        position: absolute;
	    left: 15px;
	    top: 15px;
	    color: grey;
	}
	.panel.panel-default .panel-title a{
		margin-left: 25px;
	}
	.panel-heading .accordion-toggle.collapsed:after {
	    content: "\e080";
	}
</style>
<div class="panel panel-default">
    <div class="panel-heading">Promotion Control</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
	</div>
</div>
<script type="text/javascript">
    $('table').addClass('table-bordered');
</script>
<script type="text/javascript">
	function copy(){
		var id = $(this).parent().prev().find('.btn-xs').attr('data-id');
		if(id>0){
			$.ajax({
				url:'<?php echo Yii::app()->createUrl("admin/promotion/copy")?>',
				type:'post',
				dataType:'json',
				data:{id:id},
				beforeSend:function(){
					$('#loading').show();
				},
				success:function(data){
					$('#loading').hide();
					if(data==1){
						alert('Clone successful!!!');
					}else{
						alert('Can not clone')
					}
				}
			});
		}
	}
</script>
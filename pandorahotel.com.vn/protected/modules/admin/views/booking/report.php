<?php
$this->breadcrumbs = array(
    'Booking Control'=>array('admin'),
    'Report'
);
$this->menu=array(
	array('label'=>'Export Results to Excel File', 'url'=>'javascript:doExport()', 'linkOptions'=>array('style'=>'color:red;font-weight:bold;')),
);
?>
<div class="padding-md">
	<div class="panel panel-default">
        <div class="panel-heading">
            Booking Control
        </div>
		<div class="padding-md clearfix">
			<div class="panel-body">
				<form method="post" id="form_filter" class="form-horizontal">	
					<?php
						$status = array(''=>'All')+ExtraHelper::$bookingStatus;?>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-lg-5 control-label">From date</label>
								<div class="col-lg-7">
									<?php echo CHtml::textField('filter[fromDate]', $filter['fromDate'], array('class'=>'form-control datepicker'));?>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-lg-5 control-label">To date</label>
								<div class="col-lg-7">
									<?php echo CHtml::textField('filter[toDate]', $filter['toDate'], array('class'=>'form-control datepicker'));?>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-lg-5 control-label">Status</label>
								<div class="col-lg-7">
									<?php echo CHtml::dropDownlist('filter[status]', $filter['status'], $status, array('class'=>'form-control'));?>
								</div>
							</div>
						</div>
						<button class="btn btn-small btn-success" name="filterButton" type="submit">Filter</button>
						<input type="hidden" name="do_export" value="" id="do_export"/>
				</form>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php 
					if(count($datalist)>0){
						$dataProvider = new CArrayDataProvider($datalist);
						$dataProvider->setPagination(false);

						$this->widget('booster.widgets.TbJsonGridView', array(
						    'id'=>'grid',
						    'dataProvider'=>$dataProvider,
						    'filter'=>$model,
						    'htmlOptions' => array('class' => 'table table-bordered table-condensed table-hover table-striped'),
						    'columns'=>array(
								array('header' => 'Request Date', 'type'=>'raw', 'value'=>'$data[1]'),
								array('header' => 'Booking ID', 'type'=>'raw', 'value'=>'$data[3]'),
								array('header' => 'Full name', 'type'=>'raw', 'value'=>'$data[4]." ".$data[5]'),
								array('header' => 'Email', 'type'=>'raw', 'value'=>'$data[6]'),
								array('header' => 'Nationality', 'type'=>'raw', 'value'=>'$data[7]'),
								array('header' => 'Arrival', 'type'=>'raw', 'value'=>'$data[9]'),
								array('header' => 'Departure', 'type'=>'raw', 'value'=>'$data[10]'),
								array('header' => 'Room Nights', 'type'=>'raw', 'value'=>'$data[11]'),
								array('header' => 'Room Name', 'type'=>'raw', 'value'=>'$data[12]'),
								array('header' => 'Promotion', 'type'=>'raw', 'value'=>'$data[13]'),
								array('header' => 'Status', 'type'=>'raw', 'value'=>'$data[17]'),
								array('header' => 'Total (USD)', 'type'=>'raw', 'value'=>'$data[16]'),
							),
							'enableSorting' => false,
							'enablePagination' => false,
						    'summaryText' => '',
						)); 
					}else{
						echo '<div class="">Could not find data</div>';
					}?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function doExport() {
	$('#do_export').val('yes');
	$('#form_filter').submit();
}	
function prepareReport() {
	$('#do_export').val('');
	return true;
}
</script>
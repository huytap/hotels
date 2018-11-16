<?php
$this->breadcrumbs = array(
    'Requesting',
);
$this->menu=array(
	array('label'=>'Export Results to Excel File', 'url'=>'javascript:doExport()', 'linkOptions'=>array('style'=>'color:red;font-weight:bold;')),
);
/*$this->menu=array(
    array('label'=>'Report Requesting', 'url'=>array('report'))
);*/?>
<form method="post" id="form_filter">
<input type="hidden" name="do_export" value="" id="do_export"/>
</form>
<div class="padding-md">
	<div class="panel panel-default">
        <div class="panel-heading">
            Requesting Control
        </div>
        <div class="padding-md clearfix">
        	<form method="get" class="form-horizontal">	
				<?php
					$status = array(''=>'All')+ExtraHelper::bookingStatus();
					if(Yii::app()->session['hotel']==''){
						$hotel = Hotel::model()->getList2();?>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label class="col-md-3 col-sm-3 control-label">Hotel</label>
									<div class="col-lg-10">
										<?php echo CHtml::dropDownlist('filter[hotel]', $filter['hotel'], array('' => 'All') + $hotel, array('class'=>'form-control'));?>
									</div>
								</div>
							</div>
						</div>
					<?php }?>
					<div class="row" style="padding-bottom:20px;">
						<div class="col-md-3 col-sm-3">
							<label>Request date from</label>
							<div class="input-group">
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        <?php echo CHtml::textField('filter[request_date_from]', $filter['request_date_from'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Request date from'));?>
							</div>

						</div>
						<div class="col-md-3 col-sm-3">
							<label>Request time from</label>
							<?php
								$arr_time = array();
		                        for ($ii=0; $ii<24; ++$ii) {
		                            for ($jj=0; $jj<60; $jj+=5) {
		                                $tmp_time = sprintf("%02d:%02d", $ii, $jj);
		                                $arr_time[$tmp_time] = $tmp_time;
		                            }
		                        }
		                        echo CHtml::dropDownlist('filter[request_time_from]', $filter['request_time_from'], $arr_time, array('class'=>'form-control'));
	                        ?>
	                    </div>
						<div class="col-md-3 col-sm-3">
							<label>Request date to</label>
							<div class="input-date input-group">
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<?php echo CHtml::textField('filter[request_date_to]', $filter['request_date_to'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Request date to'));?>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Request time to</label>
							<?php
		                        echo CHtml::dropDownlist('filter[request_time_to]', $filter['request_time_to'], $arr_time, array('class'=>'form-control'));
	                        ?>
	                    </div>
		            </div>
		            <div class="row" style="padding-bottom:20px;">
						<div class="col-md-3 col-sm-3">
							<label>Check-in date</label>
							<div class="input-date input-group">
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<?php echo CHtml::textField('filter[fromDate]', $filter['fromDate'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Check-in date'));?>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Check-out date</label>
							<div class="input-date input-group">
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<?php echo CHtml::textField('filter[toDate]', $filter['toDate'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Check-out date'));?>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Requesting status</label>
							<?php echo CHtml::dropDownlist('filter[status]', $filter['status'], $status, array('class'=>'form-control'));?>
						</div>
						<div class="col-md-1 col-sm-1" style="padding:0">
							<label>&nbsp;</label>
							<button class="btn btn-small btn-success" name="filterButton" type="submit"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
			</form>
            <?php $this->renderPartial('_grid', compact(array('model','id','filter')));?>
        </div>
    </div>
</div>
<style type="text/css">
	select{width:auto;}
    .items.table > tbody >tr> td > a{
        position: relative;
    }
    .new{
        position: absolute;
        top: -18px;
        left: -35px;
        font-size: 11px;
        padding: 0px 2px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        vertical-align: middle;
        text-align: center;
        padding-top: 6px;
        text-shadow: 0 1px hsla(0, 0%, 0%, 0.25);
        border-width: 1px;
        border-style: solid;
        background-image: -webkit-linear-gradient(top, hsl(40, 95%, 76%), hsl(40, 95%, 61%));
        color: #fff;
    }
    .datepicker td.old, .datepicker td.new{display: none;}
</style>
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
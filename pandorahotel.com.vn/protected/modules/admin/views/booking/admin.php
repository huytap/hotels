<?php
$this->breadcrumbs = array(
    'Booking',
);
$this->menu=array(
    array('label'=>'Report Booking', 'url'=>array('report'))
);?>
<div class="padding-md">
	<div class="panel panel-default">
        <div class="panel-heading">
            Booking Control
        </div>
        <div class="padding-md clearfix">
        	<form method="post" id="form_filter" class="form-horizontal">	
				<?php
					$status = array(''=>'All')+ExtraHelper::$bookingStatus;
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
						<div class="col-md-11 col-sm-11" style="padding:0">
							<div class="col-md-3 col-sm-3">
								<div class="input-group">
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                        <?php echo CHtml::textField('filter[request_from_date]', $filter['request_from_date'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Book date from'));?>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="input-date input-group">
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<?php echo CHtml::textField('filter[request_date_to]', $filter['request_date_to'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Book date to'));?>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="input-date input-group">
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<?php echo CHtml::textField('filter[fromDate]', $filter['fromDate'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Check-in date from'));?>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="input-date input-group">
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<?php echo CHtml::textField('filter[toDate]', $filter['toDate'], array('class'=>'form-control datepicker','readonly'=>'readonly', 'placeholder'=>'Check-in date to'));?>
								</div>
							</div>
						</div>
						<div class="col-md-1 col-sm-1" style="padding:0"><button class="btn btn-small btn-success" name="filterButton" type="submit"><i class="fa fa-search"></i> Search</button></div>
					</div>
					<input type="hidden" name="do_export" value="" id="do_export"/>
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
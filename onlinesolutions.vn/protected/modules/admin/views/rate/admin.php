<?php
$this->breadcrumbs = array(
    'Rates',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Rate Control</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'grid',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'no-margin',
                'onSubmit' => 'return true;'
            ),
        ));?>
            <div class="row">
                <div class="col-lg-12" id="formSearch">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Room type</label>
                            <?php echo CHtml::dropDownlist('roomtype', $filter['type'], array('0' => '--Select roomtypes--') + Roomtype::model()->getList2(0, Yii::app()->session['hotel']), array('id' => 'roomType', 'class'=>'form-control'));?></div>
                        </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>From date</label>
                            <?php echo CHtml::textField('fromdate', $filter['fromdate'], array('class'=>'form-control datepicker'));?>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>To date</label>
                            <?php echo CHtml::textField('todate', $filter['todate'], array('class'=>'form-control datepicker'));?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" style="padding-top:22px;"><button class="btn btn-warning" type="submit" name="search" id="search">Search</button></div>
                    </div>
                </div>
            </div>
            
            <hr>
            <?php
            if($flag){?>
            <div class="row">
                <div class="col-lg-12" style="color:red;"><?php echo $flag;?></div>
            </div>
            <?php
            }
            if($filter['type'] > 0){?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        Enter Sell Inclusive Sales tax: 10.00 % Service charge: 5.00 % <strong>Currency USD</strong>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" name="save">Save changes</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Date</th>
                            <th style="text-align:center;">Day</th>
                            <th style="text-align:center;">Single</th>
                            <th style="text-align:center;">Double</th>
                            <!--th style="text-align:center;">Tripple</th-->
                            <th style="text-align:center;">Breakfast</th>
                            <th style="text-align:center;">Last update</th>
                        </tr>
                        <tr>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;">
                                <div class="col-md-6">Net Incl.<br></div>
                                <div class="col-md-6">
                                    Sell Incl
                                    <input type="text" name="single_sell" class="form-control"></td>
                                </div>
                            <td style="text-align:center;">
                                <div class="col-md-6">Net Incl.<br></div>
                                <div class="col-md-6">
                                    Sell Incl
                                    <input type="text" name="double_sell" class="form-control">
                                </div>
                            </td>
                            <!--td style="text-align:center;">
                                <div class="col-md-6">Net Incl.<br></div>
                                <div class="col-md-6">
                                    Sell Incl
                                    <input type="text" name="tripple_sell" class="form-control">
                                </div>
                            </td-->
                            <td style="text-align:center;">
                                <br>
                                <select name="breakfast" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Check All</option>
                                    <option value="0">Uncheck All</option>
                                </select>
                            </td>
                            <td>
                                <br>
                                <button type="submit" name="autofill" class="btn btn-primary">Auto Fill</button>
                            </td>
                        </div>
                        </tr>
                    </thead>   
                    <tbody>
                    	<?php
                        
                            foreach($Rates as $rate){?>
                                <tr>
                                    <td style="text-align:center;">
                                        <?php echo $rate['date']?>
                                        <?php //echo CHtml::hiddenField('date');?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $rate['day']?>
                                        <?php //echo CHtml::hiddenField('date');?>
                                    </td>
                                    <td style="text-align:center;">
                                        <div class="col-md-6">
                                            <?php echo CHtml::textField('Rates['.$rate['date'].'][single]', $rate['single'], array('style' => 'text-align:center;display:inline', 'disabled' => 'disabled', 'class'=>'form-control'));?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo CHtml::textField('Rates['.$rate['date'].'][single_sell]', $rate['single_sell'], array('style' => 'text-align:center;display:inline', 'class'=>'form-control'));?>
                                        </div>
                                    </td>
                                    <td style="text-align:center;">
                                        <div class="col-md-6">
                                            <?php echo CHtml::textField('Rates['.$rate['date'].'][double]', $rate['double'], array('style' => 'text-align:center;display:inline', 'disabled' => 'disabled', 'class'=>'form-control'));?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo CHtml::textField('Rates['.$rate['date'].'][double_sell]', $rate['double_sell'], array('style' => 'text-align:center;display:inline', 'class'=>'form-control'));?>
                                        </div>
                                    </td>
                                    <!--td style="text-align:center;">
                                        <div class="col-md-6">
                                            <?php //echo CHtml::textField('Rates['.$rate['date'].'][tripple]', $rate['tripple'], array('style' => 'text-align:center;display:inline', 'disabled' => 'disabled', 'class'=>'form-control'));?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php //echo CHtml::textField('Rates['.$rate['date'].'][tripple_sell]', $rate['tripple_sell'], array('style' => 'text-align:center;display:inline', 'class'=>'form-control'));?>
                                        </div>
                                    </td-->

                                    <td style="text-align:center;">
                                        <label class="label-checkbox inline">
                                            <?php echo CHtml::checkbox('Rates['.$rate['date'].'][breakfast]', $rate['breakfast']);?>
                                            <span class="custom-checkbox"></span> 
                                        </label>
                                    </td>
                                    <td><?php echo $rate['updated_date'];?></td>
                                </tr>
                            <?php
                            }?>
                    </tbody>
                </table> 
            </div>
            <?php
            }?>
        <?php $this->endWidget();?>
    </div>
</div>
<script type="text/javascript">
    $('#search').on('click', function(){
        if($('#roomType').val() <= 0){
            alert('Please select a rate');
            return false;
        }
    });
</script>
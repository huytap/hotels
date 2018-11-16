<?php
$this->breadcrumbs = array(
    'Rooms',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Room Control</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'grid',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'no-margin',
                'onSubmit' => 'return true;'
            ),
        ));
        ?>
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
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" name="save">Save changes</button>
                    </div>
                </div>
            </div>

            <div class="">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Date</th>
                            <th style="text-align:center;">Day</th>
                            <?php
                            if($filter['type'] > 0){
                                echo '<th style="text-align:center;">Use Total Allotment</th>';
                                echo '<th style="text-align:center;width:80px;">Available</th>';
                            }?>
                            <th style="text-align:center;">Close out regular allotment</th>
                            <th style="text-align:center;width:80px;">Auto top up</th>
                            <th style="text-align:center;">Last update</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;"><input type="text" class="form-control" name="available"></td>
                            <td style="text-align:center;width:150px;">
                                <select name="close" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Check All</option>
                                    <option value="0">Uncheck All</option>
                                </select>
                            </td>
                            <td style="text-align:center;"><input type="text" class="form-control" name="auto_fill"></td>
                            <td colspan="2" style="text-align:center;"><button type="submit" name="autofill" class="btn btn-small btn-primary">Auto Fill</button></td>
                        </tr>
                    </thead>   
                    <tbody>
                    	<?php
                        
                            foreach($Rooms as $room){?>
                                <tr>
                                    <td style="text-align:center;">
                                        <?php echo $room['date']?>
                                        <?php //echo CHtml::hiddenField('date');?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $room['day']?>
                                        <?php //echo CHtml::hiddenField('date');?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $room['used_total_allotments']?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo CHtml::textField('Rooms['.$room['date'].'][available]', $room['available'], array('class'=>'form-control'));?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php //echo $room['close']?>
                                        <label class="label-checkbox inline">
                                            <?php echo CHtml::checkbox('Rooms['.$room['date'].'][close]', $room['close']);?>
                                            <span class="custom-checkbox"></span> 
                                        </label>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo CHtml::textField('Rooms['.$room['date'].'][auto_fill]', $room['auto_fill'], array('class'=>'form-control'));?>
                                    </td>
                                    <td><?php echo $room['updated_date'];?></td>
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
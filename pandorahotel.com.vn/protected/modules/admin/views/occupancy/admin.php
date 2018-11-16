<?php
$this->breadcrumbs = array(
    'Occupancies',
);?>
<style type="text/css">
    th, td{text-align: center;}
</style>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'occupancy-form',
    //'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
    //'enctype' => 'multipart/form-data',
    ),
        ));
?>

<div class="row-fluid">
    <div class="span12">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</div>
<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="fa-icon-sitemap"></i><span class="break"></span>Occupancies</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Roomtype</th>
                        <th>Max. occupancy</th>
                        <th>Max. children</th>
                        <th>Max. extra beds</th>
                    </tr>
                </thead>   
                <tbody>
                	<?php 
                	$i=1;
                    $array = array(0,1,2,3);
                	foreach($roomtype as $key => $rt){
                        $check = Occupancy::model()->checkExists($key);?>
                		<tr>
                    		<td><?php echo $i ++ ;?></td>
                    		<td><?php echo $rt['name'];?></td>
                    		<td><?php echo CHtml::dropDownlist("Occupancy[".$key."][no_of_adult]", $check['no_of_adult'], $array);?></td>
                    		<td><?php echo CHtml::dropDownlist("Occupancy[".$key."][no_of_child]", $check['no_of_child'], $array);?></td>
                    		<td><?php echo CHtml::dropDownlist("Occupancy[".$key."][no_of_extrabed]", $check['no_of_extrabed'], $array);?></td>
                		</tr>
                	<?php
                	}?>
                </tbody>
            </table>            
        </div>
	</div>
</div>
<?php $this->endWidget();?>
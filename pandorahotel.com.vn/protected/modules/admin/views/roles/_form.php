<?php
$arrList= Yii::app()->params['all_roles'];
$arrRoles=array();
$arrAction=array();
foreach($arrList as $k => $v){	
	$arrRoles[$k]=$k;
}
$v2 = array();

foreach ($v as $val) {
	$v2[$val] = $val;
}?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('id' => 'RoleForm', 'onsubmit'=>'return true;', 'class'=>'no-margin'),
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Condition</h3>
        <hr>
		<div class="form-group">
			<?php echo $form->labelEx($model,'role_name'); ?>
			<?php echo $form->textField($model,'role_name', array('class'=>'form-control')); ?>
			<span class="help-inline"><?php echo $form->error($model,'users'); ?></span>
		</div>   
		<div class="form-group">
			<?php echo $form->labelEx($model,'remark'); ?>
			<?php echo $form->textField($model,'remark',array('class'=>'form-control')); ?>
			<span class="help-inline"><?php echo $form->error($model,'remark'); ?></span>
		</div>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>				
					<th>Modules</th>
					<th>Function</th>
					<th class="center"></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			foreach($arrList as $x=>$y):?>
	            <tr>
	              	<td width="150px" class="center">
	              		<?php echo $x;?>
	       		 	</td>
	              <td width="750px" class="list">     
	                <?php
					   	$arr_selected = array();
					   	$arrRoles = Role::model()->getNameRole();
	           			foreach ($arrRoles as $kk => $vv) {
	               			foreach ($vv as $ac) {
	                       		$arr_selected[] = "$kk" . "_" . $ac;
	                   		}
						} 
	                	for($j=0;$j<count($y);$j++){
	                        $checked = '';
	                        $ac_val = $x."_".$y[$j];
	                        if (in_array($ac_val, $arr_selected)) {
	                        	$checked = 'checked'; 
	                    	}?>
		                    <label class="labelEx-checkbox inline">
								<input class="check_act" type="checkbox" name="checkbox[]" value="<?php echo $ac_val; ?>" <?php echo $checked; ?>/>
								<span class="custom-checkbox"></span> <?php echo $y[$j] ?>
							</label>
	                	<?php }?>                         
	              	</td>
	              	<td width="150px">
	              		<label class="labelEx-checkbox inline">
							<input type="checkbox" class="chonhet" />
							<span class="custom-checkbox"></span> Check All
						</label>
	              	</td>  
	            	</tr>
	            <?php
	            endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
        <button class="btn btn-info" type="submit">
            <i class="icon-save bigger-110"></i>
            Lưu
        </button>
        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
            <i class="icon-undo bigger-110"></i>
            Hủy bỏ
        </button>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
$(document).ready(function(e) {
	$('#sample-table-1').find('tr').each(function(i, row){
		$(row).find(".chonhet").click(function(){
			var checked_status = '';
			if($(row).find(".chonhet").is(':checked')){
				checked_status = "checked";
			}else{
				checked_status = '';
			}
			$(row).find('.list').find("input[type=checkbox]").each(function() {
				$(row).find('.list').find("input[type=checkbox]").each(function(j, jrow){
					$(jrow).attr('checked', checked_status)
				})
	        });
			
		});
	})
   
});
</script>
</div><!-- form -->
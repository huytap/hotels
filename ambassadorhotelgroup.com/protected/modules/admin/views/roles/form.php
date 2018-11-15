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
<div class="row-fluid">
	<div class="span12">
		<!--PAGE CONTENT BEGINS-->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'role-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('id' => 'RoleForm', 'onsubmit'=>'return true;'),
		)); ?>
			<?php echo $form->errorSummary($model); ?>
			<div class="control-group">
				<?php echo $form->labelEx($model,'role_name'); ?>
				<div class="controls">
					<?php echo $form->textField($model,'role_name',array('size'=>33,'maxlegth'=>255)); ?>
					<span class="help-inline"><?php echo $form->error($model,'users'); ?></span>
				</div>
			</div>   
			<div class="control-group">
				<?php echo $form->labelEx($model,'remark'); ?>
				<div class="control-group">
					<?php echo $form->textField($model,'remark',array('rows'=>1, 'class'=>'span10;')); ?>
					<span class="help-inline"><?php echo $form->error($model,'remark'); ?></span>
				</div>
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
			                    <label>
									<input type="checkbox" id="check_val" name="checkbox[]" class="check_act" value="<?php echo $ac_val; ?>" <?php echo $checked; ?>>
									<span class="lbl"><?php echo $y[$j] ?></span>
								</label>
		                	<?php }?>                         
		              	</td>
		              	<td width="150px">
		              		<label>
								<input type="checkbox" class="chonhet" />
								<span class="lbl">Check All</span>
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
		<?php $this->endWidget(); ?>
	</div>
</div>
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
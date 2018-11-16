<!--basic scripts-->

<!--[if !IE]>-->

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->

<!--<![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<!--ace scripts-->
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/chosen.jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/fuelux/fuelux.spinner.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.knob.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.autosize-min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/bootstrap-tag.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/assets/js/ace.min.js"></script>
<!--inline scripts related to this page-->

<script type="text/javascript">
	function show_box(id) {
	 $('.widget-box.visible').removeClass('visible');
	 $('#'+id).addClass('visible');
	}
	if($('#id-input-file-2').length){
		$('#id-input-file-2').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
			//whitelist:'gif|png|jpg|jpeg'
			//blacklist:'exe|php'
			//onchange:''
			//
		});
	}
	if($('#id-input-file-3').length){
		$('#id-input-file-3').ace_file_input({
			style:'well',
			btn_choose:'Drop files here or click to choose',
			btn_change:null,
			no_icon:'icon-cloud-upload',
			droppable:true,
			thumbnail:'small'
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}

		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
	}
	if($('.date-picker').length){
		$('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function(){
	        $(this).prev().focus();
	    });
	}
    if($('#id-date-range-picker-1').length){
    	$('#id-date-range-picker-1').daterangepicker({
	        format:'DD/MM/YYYY'
	    }).prev().on(ace.click_event, function(){
	        $(this).next().focus();
	    });
    }
    if($('.timepicker1').length){
	    $('.timepicker1').timepicker({
	        minuteStep: 1,
	        showSeconds: true,
	        showMeridian: false
	    });
	}
</script>
<?php include 'customjs.php'; ?>
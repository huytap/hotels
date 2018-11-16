<?php
$this->breadcrumbs = array(
    'Slider Control' => array('admin'),
    'View'
);
$this->menu=array(
    array('label'=>'Upload more', 'url'=>array('slideshow/upload/id/'.$gallery['id'])),
);
?>
<div class="panel panel-default">
    <div class="panel-heading">Slider Control: <?php echo $gallery['name'];?>. Drag photo to sort order</div>
    <div class="panel-body wrapper-content" id="items">

        <?php //$this->renderPartial('_grid', compact(array('model','gallery')));

        	$data = Item::model()->getListByGallery($gallery['id']);
        	foreach($data->getData() as $dt){
        		echo '<div class="col-md-2" data-id="'.$dt['id'].'">';
        			echo '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/slide/'.$dt['name'].'&h=150&w=150">';
        			echo '<div class="description">';
        				echo '<div class="col-md-6" style="cursor:pointer;">';
        					echo '<span class="fa fa-pencil" onclick="showPopupUpdate('.$dt['id'].',\''.Yii::app()->baseUrl.'/uploads/slide/'.$dt['name'].'\', this)"></span>';
        					$description=json_decode($dt['description'], true);
        					$title = json_decode($dt['title'], true);
        					if(is_array($title) && count($title)>0){
        						echo '<span class="title_en" style="display:none;">'.$title['en'].'</span>';
	        					echo '<span class="title_vi" style="display:none;">'.$title['vi'].'</span>';
	        					echo '<span class="title_ja" style="display:none;">'.$title['ja'].'</span>';
	        					echo '<span class="title_ko" style="display:none;">'.$title['ko'].'</span>';
        					}
        					if(is_array($description) && count($description)>0){
	        					echo '<span class="des_en" style="display:none;">'.$description['en'].'</span>';
	        					echo '<span class="des_vi" style="display:none;">'.$description['vi'].'</span>';
	        					echo '<span class="des_ja" style="display:none;">'.$description['ja'].'</span>';
	        					echo '<span class="des_ko" style="display:none;">'.$description['ko'].'</span>';
	        				}
        					echo '</div>';
        				echo '<div class="col-md-6" style="text-align:right;cursor:pointer;"><span class="fa fa-times" onclick="deleteItem('.$dt['id'].', this)"></span></div>';
        			echo '</div>';
        		echo '</div>';
        	}

        ?>
    </div>
</div>
<div class="modal fade" id="altPhoto" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Cập nhật thông tin hình ảnh</h4>
            </div>
            <div class="modal-body ">
            	<div class="row">
	            	<div class="col-xs-12 p-none mb20" id="photoAlt">
	                    <img src="" class="img-responsive">
	                </div>
	            </div>
	            <div class="row">
		            <div class="panel panel-default">
		                <?php
		                $language = Yii::app()->params['language_config'];?>
		                <div class="panel-tab clearfix">
		                    <ul class="tab-bar">
		                        <?php
		                        $i=0; 
		                        foreach($language as $key => $lang){
		                            $class='';
		                            if($i==0){
		                                $class="active";
		                            }
		                            $i++;
		                            echo '<li class="'.$class.'"><a href="#'.$key.'" data-toggle="tab"> '.$lang.'</a></li>';
		                        }?>
		                    </ul>
		                </div>
		                <div class="panel-body">
		                    <div class="tab-content">
		                        <?php
		                        $i=0; 
		                        foreach($language as $key => $lang){
		                            $class='';
		                            if($i==0)
		                                $class='active';?>
		                            <div class="tab-pane fade in <?php echo $class?>" id="<?php echo $key?>">
		                                <div class="form-group">
		                                    <label>Title</label>
		                                    <?php echo CHtml::textField("title[$key]", '', array('class' => 'form-control', 'placeholder' => 'Title')); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Description</label>
		                                    <?php echo CHtml::textArea("description[$key]", '', array('class' => 'form-control', 'rows'=>'6', 'placeholder' => 'Description')); ?>
		                                </div>
		                            </div>
		                        <?php $i++;
		                        }?>
		                    </div>
		                </div>
		            </div><!-- /panel -->
		        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancelAlt">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveAlt">Lưu</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
$(function(){
	var second_id = start=0;
	var arrItem = {}
	$.each($('#items').find('.col-md-2'), function(i, row){
				arrItem[$(row).attr('data-id')] = i+1;
			});console.log(arrItem)

	$('#items').sortable({
		start: function(event, ui) {
	        var tg2 = $(ui.item);
	        start = ui.item.index();
	       	second_id = parseInt(tg2.attr('data-id'));
	        console.log(arrItem)
	    },
		update: function( event, ui ) {
	        var $target = $(ui.item);
		    // Extract the PK of the item just dragged
		    var itemId = parseInt($target.attr('data-id'));
		    var galleryId = <?php echo $gallery['id']?>;
		    // Display order is 1-based in my database so add 1
		    var index = $target.index() + 1;
		    // Send REST call to server to update new display order
		    var url = "<?php echo Yii::app()->createUrl('admin/ajax/update_photo_order')?>";
		    //url += "?id="+ itemId.toString() + "&order=" + index.toString()+"&start="+start;
			$.each($('#items').find('.col-md-2'), function(i, row){
				arrItem[$(row).attr('data-id')] = i+1;
			});console.log(arrItem)
	        $.ajax({
		        url: url,
		        type: "post",
		        data:{arrItem: arrItem, id:itemId, neworder: index.toString(), gallery:galleryId, oldorder:(start+1)},
		        beforeSend: function(){
					$('#loading').show();
				},
		        dataType:'json',			        
		        success:function (data){
		            $('#loading').hide()
		        }
		    });
	    }
	});
    $( "#image-upload-list" ).disableSelection();
});
</script>
<script type="text/javascript">
	function showPopupUpdate(id, Linkimg, object){
		var description = $(object).parent().find('.des').html();
		$('#altField').val(description)
		$('#altPhoto').show();
		$('#altPhoto').addClass('in');
		$('#altField').val(description);
		$('#photoAlt').find('img').attr('src', Linkimg);
		
		$('#title_en').val($(object).parent().find('.title_en').html());
		$('#title_vi').val($(object).parent().find('.title_vi').html());
		$('#title_ja').val($(object).parent().find('.title_ja').html());
		$('#title_ko').val($(object).parent().find('.title_ko').html());

		$('#description_en').val($(object).parent().find('.des_en').html());
		$('#description_vi').val($(object).parent().find('.des_vi').html());
		$('#description_ja').val($(object).parent().find('.des_ja').html());
		$('#description_ko').val($(object).parent().find('.des_ko').html());


		$('#saveAlt').click(function(){
			var title_en = $('#title_en').val();
			var title_vi = $('#title_vi').val();
			var title_ja = $('#title_ja').val();
			var title_ko = $('#title_ko').val();

			var des_en = $('#description_en').val();
			var des_vi = $('#description_vi').val();
			var des_ja = $('#description_ja').val();
			var des_ko = $('#description_ko').val();
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("admin/slideshow/updateitem");?>',
				type: 'post',
				dataType: 'json',
				data:{id: id, title_ko:title_ko, title_en:title_en,title_vi:title_vi,title_ja:title_ja,des_en:des_en,des_vi:des_vi,des_ja:des_ja,des_ko:des_ko},
				beforeSend: function(){
					$('#loading').show();
				},
				success: function(data){
					$('#loading').hide()
					location.reload();
				}
			})
		});
		$('#cancelAlt, .close').click(function(){
			$('#altPhoto').hide();
			$('#altPhoto').removeClass('in');
			$('#altField').val('')
		})
	}

	function deleteItem(id, object){
		if(confirm('Are you sure you want to delete this photo?'))
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("admin/slideshow/deleteItem");?>',
			type: 'post',
			dataType: 'json',
			data:{id: id},
			beforeSend: function(){
				$('#loading').show()
			},
			success: function(data){
				$(object).parent().parent().parent().remove();
				$('#loading').hide()
			}
		})
	}
</script>
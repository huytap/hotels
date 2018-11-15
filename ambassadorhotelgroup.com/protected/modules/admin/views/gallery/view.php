<?php
$this->breadcrumbs = array(
    'Album Control' => array('admin'),
    'View'
);
$this->menu=array(
    array('label'=>'Upload more', 'url'=>array('gallery/upload/id/'.$gallery['id'])),
);
?>
<div class="panel panel-default">
    <div class="panel-heading">Slider Control: <?php echo $gallery['name'];?>. Drag photo to sort order</div>
    <div class="panel-body wrapper-content" id="items">
    	<?php
		                $language = Yii::app()->params['language_config'];?>
        <?php //$this->renderPartial('_grid', compact(array('model','gallery')));

        	$data = Item::model()->getListByGallery($gallery['id']);
        	if($data && count($data->getData()))
        	foreach($data->getData() as $dt){
        		echo '<div class="col-md-2" data-id="'.$dt['id'].'">';
        			echo '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/gallery/'.$dt['name'].'&h=150&w=150">';
        			echo '<div class="description">';
        				echo '<div class="col-md-6" style="cursor:pointer;">';
        					echo '<span class="fa fa-pencil" onclick="showPopupUpdate('.$dt['id'].',\''.Yii::app()->baseUrl.'/uploads/gallery/'.$dt['name'].'\', this)"></span>';
        					$description=json_decode($dt['description'], true);
        					$title = json_decode($dt['title'], true);
        					$url = json_decode($dt['url'], true);
        					foreach($language as $key => $lang){
	        					if(is_array($title) && count($title)>0){
	        						echo '<span class="title_'.$key.'" style="display:none;">'.$title[$key].'</span>';
	        					}
	        					if(is_array($description) && count($description)>0){
		        					echo '<span class="des_'.$key.'" style="display:none;">'.$description[$key].'</span>';
		        				}
		        				if(is_array($url) && count($url)>0){
		        					echo '<span class="url_'.$key.'" style="display:none;">'.$url[$key].'</span>';
		        				}
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
		                                <div class="row">
								            <div class="col-md-12">
							                    <div class="form-group">
							                        <label>Url</label>
							                        <?php echo CHtml::textField("url[$key]", '', array('class' => 'form-control', 'placeholder' => 'Link url')); ?>
							                    </div>
							            	</div>
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
		<?php foreach($language as $key => $lang){?>
			$('#title_<?php echo $key?>').val($(object).parent().find('.title_<?php echo $key?>').html());
			$('#url_<?php echo $key?>').val($(object).parent().find('.url_<?php echo $key?>').html());
			$('#description_<?php echo $key?>').val($(object).parent().find('.des_<?php echo $key?>').html());
		<?php 
		}?>

		$('#saveAlt').click(function(){
			var data = {id:id}
			<?php foreach($language as $key => $lang){?>
				data['title_<?php echo $key?>'] = $('#title_<?php echo $key?>').val();
				data['des_<?php echo $key?>'] = $('#description_<?php echo $key?>').val();
				data['url_<?php echo $key?>'] = $('#url_<?php echo $key?>').val();
			<?php }?>
			console.log(data)
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("admin/slideshow/updateitem");?>',
				type: 'post',
				dataType: 'json',
				data:data,
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
			url: '<?php echo Yii::app()->createUrl("admin/gallery/deleteItem");?>',
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
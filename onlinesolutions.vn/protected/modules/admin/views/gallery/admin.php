<div class="section col-xs-12 p-none">
    <?php
        $roomtypes = Roomtype::model()->getList(0, Yii::app()->session['hotel']);
    ?>
        <div class="panel-tab clearfix">
            <ul class="tab-bar" id="tab-bar">
                <?php
                foreach($roomtypes->getData() as $key => $rt){
                    $class='';
                    if($key==0){
                        $class="active";
                    }
                    echo '<li class="'.$class.'" data-roomtype="'.$rt['id'].'"><a href="#data'.$rt['id'].'" data-toggle="tab"> '.$rt['name'].'</a></li>';
                }?>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <?php
                $i=0; 
                foreach($roomtypes->getData() as $key => $rt){
                    $gallery = Gallery::model()->getGalleryByType(1, $rt['hotel_id'], $rt['id']);
                    $class='';
                    if($key==0)
                        $class='active';
                    echo '<div class="tab-pane fade in '.$class.'" id="data'.$rt['id'].'">';
                        $this->renderPartial('view', array('gallery' => $gallery, 'roomtype_id' => $rt['id']));
                    echo '</div>';
                }?>
            </div>
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
	$('#tab-bar').find('li').each(function(i, row){
		$(row).find('a').click(function(){
			drag($(row).attr('data-roomtype'));
		})
	})
	drag();
});
function drag(tab=''){
	var second_id = start=0;
	var arrItem = {}
	$.each($('.items').find('.col-md-2'), function(i, row){
		arrItem[$(row).attr('data-id')] = i+1;
	});
	var object='.items';
	if(tab){
		object = '#data'+tab;
	}
	$(object).sortable({
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
		    var galleryId = $(this).attr('data-id');
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
}
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
				url: '<?php echo Yii::app()->createUrl("admin/gallery/updateitem");?>',
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
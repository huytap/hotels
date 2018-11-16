<?php 
if(Yii::app()->controller->action->id == 'view'){
	$this->breadcrumbs=array(
		'Photos' => array('admin'),
		'View Detail'
	);
}?>
<div class="panel panel-default">
    <div class="panel-heading">Photos: <?php echo $model['name'];?>. Drag photo to sort order</div>
    <div class="panel-body wrapper-content items" id="items<?php echo $gallery['id'];?>" data-id="<?php echo $gallery['id'];?>">
        <?php
        if($gallery){
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
        }
        	echo '<div class="col-md-2" data-id="'.$dt['id'].'">';
        	if($gallery){
    			echo '<a href="'.Yii::app()->createUrl('admin/gallery/upload', array('id'=>$gallery['id'])).'" style="text-align: center;height: 142px;display: block;border: 1px dotted;vertical-align: middle;"><span style="display: block;padding-top: 55px;" class="fa fa-upload"></span> Upload More</a>';
        	}else{
        		echo '<a href="'.Yii::app()->createUrl('admin/gallery/create', array('roomtype_id' => $roomtype_id)).'" style="text-align: center;height: 142px;display: block;border: 1px dotted;vertical-align: middle;"><span style="display: block;padding-top: 55px;" class="fa fa-upload"></span> Upload Photo</a>';
        	}
    		echo '</div>';

        ?>
    </div>
</div>
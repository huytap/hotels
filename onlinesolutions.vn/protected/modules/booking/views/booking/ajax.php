<div class="panel-body" id="search">
    <?php
    foreach($available as $room){
        $photo = explode(',', $room['photos']);
        if(isset($room['promos']) && $room[1]>0 && 
            $room['available'] > 0){
            $rowspan = count($room['promos']);
            $max = 2;
            $this->renderPartial('_item4', compact(array('max', 'params','room', 'photo')));
        }else{
            $this->renderPartial('_item_not_available', compact(array('j', 'max', 'params','loop','room', 'photo')));
        }
    }
    ?>
    
</div>

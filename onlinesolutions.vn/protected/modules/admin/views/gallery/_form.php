<?php
$form = $this->beginWidget('CActiveForm', array(
'id' => 'category-form',
'enableClientValidation' => true,
'htmlOptions' => array(
    'class' => 'no-margin',
    'enctype' => 'multipart/form-data',
    ),
));?>
    <div class="row">
    <?php
       if(isset($_GET['roomtype_id']) && Yii::app()->controller->action->id=='create'){
        $roomtype = Roomtype::model()->findByPk($_GET['roomtype_id']);?>
        <div class="col-lg-4">
            <label>Roomtype: <?php echo $roomtype['name']?></label>
        </div>
        <?php
            
            echo '<input type="hidden" name="Gallery[name]" value="'.$roomtype['name'].'">';
            echo '<input type="hidden" name="Gallery[description]" value="'.$roomtype['name'].'">';
            echo '<input type="hidden" name="Gallery[roomtype_id]" value="'.$_GET['roomtype_id'].'">';
        }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">       
                <lebel>Photos</lebel>
                <input multiple="" type="file" name="items[]" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-info" type="submit">
                <i class="icon-ok bigger-110"></i>
                Submit
            </button>
        </div>
    </div>
<?php $this->endWidget(); ?>
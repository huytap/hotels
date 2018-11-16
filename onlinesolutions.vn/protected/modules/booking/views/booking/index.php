<?php $lang = Yii::app()->session['_lang'];?>
<?php if (isset($params['fromDate'])) { ?>
    <script type="text/javascript" charset="utf-8">
        var fromDate = "<?php echo date('d M Y', strtotime($params['fromDate'])) ?>";
        var toDate = "<?php echo date('d M Y', strtotime($params['toDate'])) ?>";
    </script>
<?php }
?>
<div style="padding-top: 40px;">
<div class="col-md-3 col-sm-3 col-xs-12 <?=$class?>" style="background: #fff;">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'grid',
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'class' => 'form-book',
        ),
    ));?>
        <!--div class="container"-->
            <input type="hidden" value="<?php if($_GET['chain_id']) echo $_GET['chain_id'];?>" id="FormBook_chain">
            <div class="row form-bk">
                <?php
                if(isset($_GET['chain_id']) && $_GET['chain_id']){
                    $hotels = Hotel::model()->getListByChain($_GET['chain_id']);  
                    if(count($hotels)>1)  {
                ?>
                <div class="col-sm-12">
                    <div class="form-groups">
                        <label>Hotels</label>
                        <div class="date"><?php echo $form->dropDownList($model, 'hotel', $hotels, array('class' => 'form-control'));?></div>
                    </div>
                </div>
                <?php
                    }
                }                
                ?>
                <div class="col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'checkin');?></label>
                        <div class="date" id="dpIn">
                            <?php echo $form->textField($model, 'checkin', array('class'=>'form-control datepicker', 'id' => 'check-in-date'));?>
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'checkout');?></label>
                        <div class="date" id="dpOut">
                            <?php echo $form->textField($model, 'checkout', array('class'=>'form-control datepicker', 'id' => 'check-out-date'));?>
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'adult');?></label>
                        <div class="date">
                            <?php echo $form->dropDownlist($model, 'adult', array(1=>1,2,3,4,5,6), array('class'=>'form-control'));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'children');?></label>
                        <div class="date">
                            <?php echo $form->dropDownlist($model, 'children', array(0,1,2), array('class'=>'form-control'));?>
                        </div>
                    </div>
                </div>
                <div id="children1" class="col-sm-6 col-xs-6 col-md-6 room-item" <?php if(isset($_GET['children']) && $_GET['children']>0) echo 'style="display:block";';else echo 'style="display:none;"';?>>
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'Ages of children');?></label>
                        <div class="date">
                            <?php echo CHtml::dropDownlist('children_age', $_GET['children_age'], ExtraHelper::makeNumberArray(11)+array(12=>'11+'), array('class' => 'form-control'));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-6 col-md-6 room-item" id="children2" <?php if(isset($_GET['children']) && $_GET['children']>1) echo 'style="display:block";';else echo 'style="display:none;"';?>>
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'Ages of children');?></label>
                        <div class="date">
                            <?php echo CHtml::dropDownlist('children_age1', $_GET['children_age1'], ExtraHelper::makeNumberArray(11)+array(12=>'11+'), array('class' => 'form-control'));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'display_rate');?></label>
                        <div class="date"><?php echo CHtml::dropDownList('currency', $params['currency'], ExtraHelper::$currency, array('class' => 'form-control'));?></div>
                    </div>
                </div> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-groups">
                        <label>&nbsp;</label>
                        <div>
                            <button class="btn btn-booking" type="submit"><?php echo Yii::t('lang', 'Search');?></button>
                            <?php
                            if(Yii::app()->session['_hotel']){
                                $hotel = Yii::app()->session['_hotel'];
                            }else{
                                $hotel = Hotel::model()->getHotelByHotelID($_GET['hotel_id'], $_GET['chain_id']);
                            }
                            ?>
                            <a class="btn btn-link" href="<?php echo Yii::app()->baseUrl.'/booking/login/'.$hotel['hotel_id'].'/'.$hotel['chain_id']?>">Modify/Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        <!--/div-->
    <?php $this->endWidget();?>
</div>


    <div class="col-md-9 col-sm-9 col-xs-12 booking-list" role="main">
        <div class="panel panel-default">            
            <div id="search">
                <div class="col-xs-12"><h2 class="select-date-room">SELECT DATE &amp; ROOMS</h2></div>
                <?php 
                if(count($packages)>0){
                    foreach($packages as $package){
                        $short = json_decode($package['short_description'], true);
                        $full = json_decode($package['full_description'], true);
                        echo '<div class="panel-body">';
                            $this->renderPartial('_pkage', compact(array('package', 'short', 'full', 'params')));
                        echo '</div>';
                        ?>
                    <?php }
                }?>
                <?php
                if(count($available)>0){?>        
                    <?php
                    if($params['rtype_pr']){
                        echo '<div class="panel-body">';
                            $this->renderPartial('_item_pr', compact(array('params','available')));
                        echo '</div>';
                    }else{
                        foreach($available as $room){
                            echo '<div class="panel-body">';
                            $photo = explode(',', $room['photos']);
                            //if(isset($room['promos']) && $room[1]>0 && 
                                //$room['available'] > 0){
                                $rowspan = count($room['promos']);
                                $max = 2;
                                $this->renderPartial('_item4', compact(array('max', 'params','room', 'photo')));
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
            
        </div>                
    </div>

</div>
<?php
Yii::app()->clientScript->registerScript('children', '
    $(function(){
        if($("#FormBook_children").length){
            $("#FormBook_children").change(function(){
                if($(this).val()>0){
                    $("#children1").show();
                    $("#children1").attr("name", "FormBook[children_age]");
                }else{
                    $("#children1").hide();
                    $("#children1").attr("name", "");
                }
                
                if($(this).val()>1){
                    $("#children2").show();
                    $("#children2").attr("name", "FormBook[children_age1]");
                }else{
                    $("#children2").hide();
                    $("#children2").attr("name", "");
                }
            })
        }
    })', CClientScript::POS_END);
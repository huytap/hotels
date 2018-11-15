<article class="ar-bookings wow fadeInUp">
    <div class="container">
        <div class="booksNow">
            <div class="booking-form">
                <h2 class="tle-booking">Đặt phòng</h2>
                <?php 
                $lang = Yii::app()->language;
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'ajax-reservation-form',
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'class' => 'form-horizontal',
                        'onSubmit'=>'return true'
                    )
                ));?>                     
                    <div class="form-group">
                        <div class="col-xs-12"> 
                            <select>
                                <option><?php echo Yii::t('lang', 'select_a_hotel');?></option>
                                <?php
                                foreach($hotels->getData() as $hotel){
                                    echo '<option value="#">'.$hotel->name.'</option>';    
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6"> 
                            <label><?php echo Yii::t('lang', 'checkin');?></label>
                            <?php echo $form->textField($model, 'checkin', array('id'=>'dpd1', 'class'=>'datepicker form-control'));?>
                        </div>
                        <div class="col-xs-6"> 
                            <label><?php echo Yii::t('lang', 'checkout');?></label>
                            <?php echo $form->textField($model, 'checkout', array('id'=>'dpd2', 'class'=>'datepicker form-control'));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label><?php echo Yii::t('lang', 'no_room');?></label>
                            <?php echo $form->dropDownlist($model, 'no_room', array(1=>1, 2,3,4,5));?>
                        </div>
                        <div class="col-xs-4">
                            <label><?php echo Yii::t('lang', 'adult');?></label>
                            <?php echo $form->dropDownlist($model, 'adult', array(1=>1, 2=>2, 3=>3));?>
                        </div>
                        <div class="col-xs-4">
                            <label><?php echo Yii::t('lang', 'children');?></label>
                            <?php echo $form->dropDownlist($model, 'children', array(0=>0,1=>1, 2=>2));?>
                        </div>
                    </div>
                    <div class="form-group form-btn"> 
                        <div class="col-xs-12">
                            <button type="submit"><?php echo Yii::t('lang', 'check_avaibility');?></button>
                        </div>
                    </div>
                <?php $this->endWidget();?>
            </div>
        </div>
    </div>
</article>
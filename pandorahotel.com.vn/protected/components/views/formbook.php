<article class="ar-bookings wow fadeInUp">
    <div class="container">
        <div class="booksNow">
            <?php 
            $lang = Yii::app()->language;
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'ajax-reservation-form',
                'enableClientValidation' => true,
                'htmlOptions' => array(
                    'class' => 'booking-form',
                    'onSubmit'=>'return true'
                )
            ));?>                        
                <div class="form-group">
                    <div class="col-xs-12"> 
                        <label><?php echo Yii::t('lang', 'checkin');?></label>
                        <?php echo $form->textField($model, 'checkin', array('id'=>'dpd1', 'class'=>'datepicker'));?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12"> 
                        <label><?php echo Yii::t('lang', 'checkout');?></label>
                        <?php echo $form->textField($model, 'checkout', array('id'=>'dpd2', 'class'=>'datepicker'));?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label><?php echo Yii::t('lang', 'adult');?></label>
                        <?php echo $form->dropDownlist($model, 'adult', array(1=>1, 2=>2, 3=>3));?>
                    </div>
                    <div class="col-xs-6">
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
</article>
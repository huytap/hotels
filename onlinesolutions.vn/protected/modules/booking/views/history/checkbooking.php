<h1>Modify/Cancel</h1>
<div class="col-sm-3">&nbsp;</div>
<div class="col-sm-6">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'class' => 'form-horizontal'
	),
)); ?>
<div class="panel panel-default">
  <div class="panel-body" style="background:#fff;">
	<div class="row">
		<div class="form-group">
			<?php echo $form->labelEx($model,'email', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model,'email', array('class' => 'form-control')); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<?php echo $form->labelEx($model,'bookingid', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model,'bookingid', array('class' => 'form-control')); ?>
				<?php echo $form->error($model,'bookingid'); ?>
			</div>
		</div>
	</div>
	<?php if(Yii::app()->user->hasFlash('error')): ?>
		<div class="row">
			<div class="col-sm-12">
				<p class="errorMessage"><?php echo Yii::app()->user->getFlash('error'); ?></p>
			</div>
		</div>
	<?php endif;?>
	<div class="row buttons">
		<div class="col-sm-12 center">
			<button class="btn btn-primary" type="submit" id="checkReser">Check Reservation</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			Please enter the email address which you used to make your reservation, 
and also the Booking ID (ex. 56DB9UIZ99) which you will find on your confirmation email.
		</div>
	</div>
	
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="col-sm-3">&nbsp;</div>
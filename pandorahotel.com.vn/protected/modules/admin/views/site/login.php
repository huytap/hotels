<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo Yii::app()->theme->baseUrl?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php echo Yii::app()->theme->baseUrl?>/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Perfect -->
	<link href="<?php echo Yii::app()->theme->baseUrl?>/css/app.min.css" rel="stylesheet">

  </head>

  <body>
	<div class="login-wrapper">
		<div class="text-center">
			<h2 class="fadeInUp animation-delay8" style="font-weight:bold">
				<span class="text-success">Hotel</span> <span style="color:#ccc; text-shadow:0 1px #fff">Administrator</span>
			</h2>
		</div>
		<div class="login-widget animation-delay1">	
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<div class="pull-left">
						<i class="fa fa-lock fa-lg"></i> Login
					</div>
				</div>
				<div class="panel-body">
					<?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class' => 'form-login'
                        ),
                    ));?>
						<div class="form-group">
							<label>Username</label>
							<?php echo $form->textField($model, 'username', array('class' => 'form-control input-sm bounceIn animation-delay2', 'placeholder'=>'Username'));?>
							<?php echo $form->error($model, 'username');?>
						</div>
						<div class="form-group">
							<label>Password</label>
							<?php echo $form->passwordField($model, 'password', array('class'=>'form-control input-sm bounceIn animation-delay4', 'placeholder'=>"Password"));?>
							<?php echo $form->error($model, 'password');?>
						</div>

						<hr/>
						<button class="btn btn-success btn-sm bounceIn animation-delay5 login-link pull-right"><i class="fa fa-sign-in"></i> Login</button>
					<?php $this->endWidget();?>
				</div>
			</div><!-- /panel -->
		</div><!-- /login-widget -->
	</div><!-- /login-wrapper -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <!-- Jquery -->
	<script src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="<?php echo Yii::app()->theme->baseUrl?>/js/bootstrap/bootstrap.min.js"></script>
   
	<!-- Modernizr -->
	<script src='<?php echo Yii::app()->theme->baseUrl?>/js/modernizr.min.js'></script>
   
    <!-- Pace -->
	<script src='<?php echo Yii::app()->theme->baseUrl?>/js/pace.min.js'></script>
   
	<!-- Popup Overlay -->
	<script src='<?php echo Yii::app()->theme->baseUrl?>/js/jquery.popupoverlay.min.js'></script>
   
    <!-- Slimscroll -->
	<script src='<?php echo Yii::app()->theme->baseUrl?>/js/jquery.slimscroll.min.js'></script>
   
	<!-- Cookie -->
	<script src='<?php echo Yii::app()->theme->baseUrl?>/js/jquery.cookie.min.js'></script>
  </body>
</html>

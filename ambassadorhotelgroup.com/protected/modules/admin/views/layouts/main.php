<?php
$this->widget('CssWidget');?>
<body>
<div id="wrapper" class="preload">
	<?php $this->widget('HeaderWidget');?>
	<?php $this->widget('MenuWidget');?>
	<div id="main-container">
		<div class="padding-md">
			<div id="breadcrumb">		
				<?php 
					if(isset($this->breadcrumbs) && count($this->breadcrumbs)> 0){
						$this->widget('ext.CBreadcrumbs.Cbreadcrumbs', array(
							'links'=>$this->breadcrumbs,
						));
					}
				?>
			</div>
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>null,
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'mini-nav pull-right'),
				));
				$this->endWidget();
			?>
			<?php echo $content;?>
		</div>
	</div>
</div>
<div id="loading">
	<img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" width="50px">
</div>
<?php
$this->widget('FooterWidget');?>
<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main2'); ?>

    	<div class="head clearfix">
    		<div style="float:right;">
    		<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>null,
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'mini-nav'),
				));
				$this->endWidget();
			?>
			</div>
			<div style="float:left;padding:3px 5px 5px 0px;">
        <?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?>
		<?php endif?>
			</div>
			<div class="clearfix"></div>
        </div>
		<?php echo $content; ?>
	
<?php $this->endContent(); ?>
<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<!--PAGE CONTENT BEGINS-->

			<div class="error-container">
				<div class="well">
					<h1 class="grey lighter smaller">
						<span class="blue bigger-125">
							<i class="icon-sitemap"></i>
							404
						</span>
						Page Not Found OR You have not permision
					</h1>

					<hr />
					<h3 class="lighter smaller">We looked everywhere but we couldn't find it!</h3>

					<div>
						<form class="form-search" />
							<span class="input-icon">
								<i class="icon-search"></i>

								<input type="text" class="input-medium search-query" placeholder="Give it a search..." />
							</span>
							<button class="btn btn-small" onclick="return false;">Go!</button>
						</form>

						<div class="space"></div>
						<h4 class="smaller">Try one of the following:</h4>

						<ul class="unstyled spaced inline bigger-110">
							<li>
								<i class="icon-hand-right blue"></i>
								Re-check the url for typos
							</li>

							<li>
								<i class="icon-hand-right blue"></i>
								Read the faq
							</li>

							<li>
								<i class="icon-hand-right blue"></i>
								Tell us about it
							</li>
						</ul>
					</div>

					<hr />
					<div class="space"></div>

					<div class="row-fluid">
						<div class="center">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/default/admin');?>" class="btn btn-grey">
								<i class="icon-arrow-left"></i>
								Go Back
							</a>

							<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/default/admin');?>" class="btn btn-primary">
								<i class="icon-dashboard"></i>
								Dashboard
							</a>
						</div>
					</div>
				</div>
			</div><!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->
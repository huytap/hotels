<?php
	$lang = Yii::app()->language;
	$hotels = Hotel::model()->getList();
?>
<!DOCTYPE html>
<html lang="vi-vn" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<meta name="medium" content="mult" />
<meta name="video_height" content="480"></meta>
<meta name="video_width" content="640"></meta>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="shortcut icon" type="image/png" href="images/favicon.ico">

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap.css" type="text/css" media="all">
<link type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap-datepicker.css" type="text/css" media="all">

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/clients.css?v=001" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bxslider.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/filter.css" type="text/css" media="all">

<!--[if !IE]><!-->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-2.1.1.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.11.1.min.js"></script>
<![endif]-->
<!--[if gt IE 8]>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-2.1.1.min.js"></script>
<![endif]-->
<body>
	<?php echo $content;?>
	<?php
	if(isset($_GET['hotel'])){
		$hotel = Hotel::model()->getHotelBySlug($_GET['slug']);?>
		<style type="text/css">
			.tripadvisor .bx-controls.bx-has-pager{
				padding-top: 20px;
			}
		</style>
		<section class="sc-feedbacks-group">
			<div class="container">
				<div class="row">
					<div class="col-xs-5 sendmail">
						<?php echo Yii::t('lang', 'Register to special offer:');?>
		                <form class="form-inline subcribe-form" role="form">
		                    <input type="email" class="form-control" id="email" placeholder="<?php echo Yii::t('lang','Enter your email');?>">
		                    <button type="submit" class="btn btn-default"></button>
		                </form>
					</div>
					<div class="col-xs-7 tripadvisor">
						<h2><?php echo Yii::t('lang', 'Review from customers');?></h2>
	            		<?php
	            		$trips = Trip::model()->getList($hotel['id']);
	            		if($trips && count($trips->getData())>0){?>

						<ul class="bxslider-trip">
							<?php
							foreach($trips->getData() as $kt=>$trip){
								echo '<li>'.$trip['comment'].$trip['author'].'</li>';
							}?>
						</ul>
						<?php }?>
					</div>
				</div>
			</div>
		</section>
	<?php }
	?>
<section class="sc-footers">
	<div class="container">
		<div class="row">
			<div class="col-xs-4 col-first">
				<a href="<?php echo Yii::app()->baseUrl?>/"><img src="<?php echo Yii::app()->baseUrl?>/images/Ambassador_group_footer.png" alt="" /></a>
				<div class="txtcopyright">
					Copyright © <?php echo date('Y');?> <h1>Ambassador Hotel Group</h1>.<br>
					All rights reversed.
				</div>
				<div class="social">
					<a href="#" title="facebook"><img src="<?php echo Yii::app()->baseUrl?>/images/facebook.png" alt="facebook"/></a>
					<a href="#" title="twitter"><img src="<?php echo Yii::app()->baseUrl?>/images/twitter.png" alt="twitter"/></a>
					<a href="#" title="youtube"><img src="<?php echo Yii::app()->baseUrl?>/images/youtube.png" alt="youtube"/></a>
					<a href="#" title="Google Plus"><img src="<?php echo Yii::app()->baseUrl?>/images/gplus.png" alt="Google Plus"/></a>
					<a href="#" title="Tripadvisor"><img src="<?php echo Yii::app()->baseUrl?>/images/tripadvisor.png" alt="Tripadvisor"/></a>
				</div>
			</div>
			<div class="col-xs-2 col-two">
				<ul>
					<h2><?php echo Yii::t('lang', 'About Ambassador');?></h2>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/about.html"><?php echo Yii::t('lang', 'About us');?></a></li>
					<!-- <li><a href="<?php echo Yii::app()->params['link'].$lang?>/gallery"><?php echo Yii::t('lang', 'Gallery');?></a></li> -->
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/services.html"><?php echo Yii::t('lang', 'Services');?></a></li>
					<!-- <li><a href="<?php echo Yii::app()->params['link'].$lang?>/destination"><?php echo Yii::t('lang', 'Destination');?></a></li> -->
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/contact.html"><?php echo Yii::t('lang', 'Contact');?></a></li>
				</ul>
			</div>
			<div class="col-xs-2 col-three">
				<ul>
					<h2><?php echo Yii::t('lang', 'Services');?></h2>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/special-offers.html"><?php echo Yii::t('lang', 'Special Offers');?></a></li>
					<!-- <li><a href="<?php echo Yii::app()->params['link'].$lang?>/rooms"><?php echo Yii::t('lang', 'Rooms & Suites');?></a></li> -->
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/services.html"><?php echo Yii::t('lang', 'Services & Facilities');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/tours.html"><?php echo Yii::t('lang', 'Tours');?></a></li>
					<!--<li><a href="<?php //echo Yii::app()->params['link'].$lang?>/services/spa"><?php //echo Yii::t('lang', 'Spa');?></a></li>-->
				</ul>
			</div>
			
			<div class="col-xs-4 col-four">
				<h2><?php echo Yii::t('lang', 'Information');?></h2>
				<div class="panel-group accord-ourhotel" id="accordion">
					<?php
					foreach($hotels->getData() as $hotel){
						$add = json_decode($hotel['address'], true);
						$city = json_decode($hotel['city'], true);
						$country = json_decode($hotel['country'], true);
						?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $hotel['slug']?>" aria-expanded="true" aria-controls="collapseOne"><?php echo $hotel['name']?></a>
							</div>
							<div id="<?php echo $hotel['slug']?>" class="panel-collapse collapse <?php if($hotel['display_order'] == 1) echo 'in';?>" role="tabpanel" aria-labelledby="headingOne">
								<p class="abr-map"><?php echo $add[$lang].', '.$city[$lang].', '.$country[$lang]?></p>
								<p class="abr-fone"><?php echo Yii::t('lang', 'Tel')?>: <?php echo $hotel['tel']?></p>
								<p class="abr-email">Email: <a href="mailto:<?php echo $hotel['email_sales']?>"><?php echo $hotel['email_sales']?></a></p>
							</div>
						</div>
					<?php }?>
				</div>
			</div>		
		</div>
	</div>
</section>
<a href="#" id="back-to-top" title="Back to top"></a>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/bootstrap.min.js"></script>	
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/menu.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/onscroll.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.carousel.js"></script>
<script type="text/javascript"  src="<?php echo Yii::app()->baseUrl?>/js/filter.js"></script>
<script src="<?php echo Yii::app()->baseUrl?>/js/backTop.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/main.js"></script>

<script>
	var rootUrl='<?php echo Yii::app()->params["link"]?>';
</script>
<script type="text/javascript">
    
    /*$(document).ready(function () {
        var current_page_link = document.location.href;
        $('#navigate li').each(function (a,b) {

            var link_loop = $(b).find('a').attr("href");
            
            if (link_loop === current_page_link) {
                $(b).addClass('selected');
            }
        });
    });*/
</script>
</body>
</html>
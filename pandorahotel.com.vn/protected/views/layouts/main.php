<!DOCTYPE html>
<html lang="vi-vn">
<head>
	<!--[if !IE]><!-->
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-2.1.1.min.js"></script>
	<!--<![endif]-->
	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.11.1.min.js"></script>
	<![endif]-->
	<!--[if gt IE 8]>
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-2.1.1.min.js"></script>
	<![endif]-->
	<title>Pandora Hotel & Residences</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<meta name="medium" content="mult" />
	<meta name="video_height" content="480"></meta>
	<meta name="video_width" content="640"></meta>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link rel="shortcut icon" type="image/png" href="<?php echo Yii::app()->baseUrl?>/images/favicon.ico">

	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap.css" type="text/css" media="all">
	<link type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/jquery-ui.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap-datepicker.css?v=001" type="text/css" media="all">

	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/carino.css?v=003" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/bxslider.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/lightcase.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/filter.css?v=001" type="text/css" media="all">
	<style type="text/css">
		.tlePortlets {
		    padding: 0 10% 25px;
		}
		.wp-maps:before{
			border:0;
		}
	</style>
</head>
<body>
<?php echo $content;?>
<?php 
$lang = Yii::app()->language;
$hotel = Hotel::model()->find();
?>
<section class="sc-contacts-home">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', '<span>Contact</span> Us');?></font>
            <?php 
            if(Yii::app()->controller->action->id =='contact'){
                $contact = json_decode(Settings::model()->getSetting('contact'), true);
                echo $contact[$lang];
            }else{
                $contact = json_decode(Settings::model()->getSetting('contact1'), true);
                echo $contact[$lang];
            }
             ?>
        </h3>
        <span class="txt-hots">Hotline:</span>
        <span class="info-hotline"><?php echo $hotel['hotline']?></span>
        <span class="txt-gap"><?php echo Yii::t('lang', 'Or');?></span>
        <a class="btn-sendEmail" href="<?php echo Yii::app()->baseUrl .'/'.$lang?>/contact"><?php echo Yii::t('lang', 'Send Email');?></a>
        <p style="padding-top:15px;">
        <?php 
            /*$contacts = json_decode(Settings::model()->getSetting('contact3'), true);
            echo $contacts[$lang];*/
        ?>
        </p>
    </div>
</section>
<section class="sc-footers">
	<div class="container">
		<div class="row">
			<div class="col-xs-4 col-first">
				<img src="<?php echo Yii::app()->baseUrl?>/images/logofooter.png" alt="" />
				<div class="txtcopyright">
					Copyright © <?php echo date('Y');?> <h1>PANDORA Hotel</h1>.<br>
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
					<h2><?php echo Yii::t('lang', 'About');?></h2>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/about"><?php echo Yii::t('lang', 'About us');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/gallery"><?php echo Yii::t('lang', 'Gallery');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/services"><?php echo Yii::t('lang', 'Services');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/destination"><?php echo Yii::t('lang', 'Destination');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/contact"><?php echo Yii::t('lang', 'Contact');?></a></li>
				</ul>
			</div>
			<div class="col-xs-2 col-three">
				<ul>
					<h2><?php echo Yii::t('lang', 'Services');?></h2>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/special-offers"><?php echo Yii::t('lang', 'Special Offers');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/rooms"><?php echo Yii::t('lang', 'Rooms & Suites');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/services/restaurant"><?php echo Yii::t('lang', 'Restaurant');?></a></li>
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/services/meeting--conference-rooms"><?php echo Yii::t('lang', 'Meeting & Conference');?></a></li>
					<!--<li><a href="<?php //echo Yii::app()->params['link'].$lang?>/services/spa"><?php //echo Yii::t('lang', 'Spa');?></a></li>-->
				</ul>
			</div>
			<?php
			$add = json_decode($hotel['address'], true);
			$city = json_decode($hotel['city'], true);
			$country = json_decode($hotel['country'], true);
			?>
			<div class="col-xs-4 col-four">
				<h2><?php echo Yii::t('lang', 'Information');?></h2>
				<p class="abr-map"><?php echo $add[$lang].', '.$city[$lang].', '.$country[$lang]?></p>
				<p class="abr-fone"><?php echo Yii::t('lang', 'Tel')?>: <?php echo $hotel['tel']?></p>
				<p class="abr-email">Email: <a href=""><?php echo $hotel['email_sales']?></a></p>
			</div>
		</div>
	</div>
</section>
<a href="#" id="back-to-top" title="Back to top"></a>


<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/bootstrap.min.js"></script>	
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/menu.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/onscroll.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.carousel.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/lightcase.js"></script>
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
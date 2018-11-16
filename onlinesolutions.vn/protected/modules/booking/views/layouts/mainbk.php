<?php
$checkDevice = ExtraHelper::checkDevice();
if($checkDevice){
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/bootstrap-material-design.min.css");
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/bootstrap-material-datetimepicker.css");
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/ripples.min.css");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-material-datetimepicker.js', CClientScript::POS_END, array('defer' => 'defer'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/ripples.min.js', CClientScript::POS_END, array('defer' => 'defer'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/material.min.js', CClientScript::POS_END, array('defer' => 'defer'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/mobile-datepicker.js', CClientScript::POS_END, array('defer' => 'defer'));
}else{
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/bootstrap-datepicker.css");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-datepicker.min.js', CClientScript::POS_END, array('defer'=>'defer'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/desk-datepicker.js', CClientScript::POS_END, array('defer' => 'defer'));
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/custom.js?ver=004', CClientScript::POS_END, array('defer'=>'defer'));
?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery-1.12.0.min.js"></script>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="NOINDEX,NOFOLLOW" />
    <meta name="description" content="Booking Engine, Booking Engine, Thiet ke web dat phong">
    <meta name="author" content="Online Solutions">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo Yii::app()->baseUrl?>/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo Yii::app()->baseUrl?>/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Yii::app()->baseUrl?>/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Yii::app()->baseUrl?>/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->baseUrl?>/images/favicon-16x16.png">
    <title>Booking Engine | Online Booking Engine | Web Đặt Phòng Online | Hotel Booking Engine</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/style.css?v=002">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/toastr.min.css">
    <?php
    if(isset($_GET['hotel_id']) && isset($_GET['chain_id']) || Yii::app()->session['_hotel']){
        $hotel = Hotel::model()->getHotelByHotelID($_GET['hotel_id'], $_GET['chain_id']);
        if(Yii::app()->session['_hotel']){
            $hotel = Yii::app()->session['_hotel'];
        }
        if($hotel){
            if($hotel['private_link_css'])
                echo '<link rel="stylesheet" type="text/css" href="'.$hotel['private_link_css'].'">';
            elseif($hotel['private_local_css']){
                echo '<link rel="stylesheet" type="text/css" href="'. Yii::app()->theme->baseUrl.'/css/'.$hotel['private_local_css'].'">';
            }
        }
        $background_email_setting = Settings::model()->getSetting('background_email', $hotel['id']);
        $background_email = '';
        if($background_email_setting){
            $background_email = 'padding:15px 0; background:'.$background_email_setting;
            echo'<style>.header{
                    '.$background_email.'
                }
                </style>';
        }
    }
    ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-87680691-1', 'auto');
      ga('send', 'pageview');

    </script>
</head>
<body>
<div id="wrapper" class="mobile">
    <?php
    if($_SERVER['SERVER_NAME'] == Yii::app()->params['domain']){?>
    <?php
    if(Yii::app()->session['_hotel']){
        $hotel = Yii::app()->session['_hotel'];
    }else{
        $hotel = Hotel::model()->getHotelByHotelID($_GET['hotel_id'], $_GET['chain_id']);
    }
	$show_header_footer = Settings::model()->getSetting('show_header_footer', $hotel['id']);
    if($hotel['logo1']){
	
    if($show_header_footer){
    ?>
        <div class="header">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-12 col-xs-12 logo text-center">
                    <?php 
                    if($hotel['website']){
                        echo '<a target="_blank" href="'. $hotel['website'].'">';
                    }else{
                        echo '<a href="'. Yii::app()->params['link'].'booking/'.$hotel['hotel_id'].'/'.$hotel['chain_id'].'">';
                        
                    }
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$hotel['logo1'].'">';?></a>
                    </div>
                    <?php $lang = Yii::app()->session['_lang'];?>
                    <!-- <div class="col-md-9 col-xs-12">
                        <div class="info">
                            <ul>
                                <li><a href="<?php //echo $hotel['website']?>">Home</a></li>
                                <li><a href="<?php //echo Yii::app()->baseUrl.'/booking/login/'.$hotel['hotel_id'].'/'.$hotel['chain_id']?>">Modify</a></li>
                            </ul>
                        </div>                    
                    </div> -->
                </div>
                
            </div>
        </div>
    <?php }
	}
    }?>
    <?php 
    if(isset($_GET['booking']) && $_GET['booking']=='change'){
        ?>
    <?php
    }elseif(isset($_GET['booking'])){?>
        <div class="step" id="step">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="booking-step <?php if(Yii::app()->controller->action->id == 'index' || Yii::app()->controller->action->id == 'option'){ echo 'current';}?> col-xs-4 no-padding">
                            <span class="number-circle">1</span><span class="text">ROOM & RATE</span>
                        </div>
                        <div class="booking-step <?php if(Yii::app()->controller->action->id=="payment"){ echo 'current';}?> col-xs-4 no-padding">
                            <span class="number-circle">2</span><span class="text">FILLING INFORMATION</span>
                        </div>
                        <div class="booking-step <?php if(Yii::app()->controller->action->id=="thankyou"){ echo 'current';}?> col-xs-4 no-padding">
                            <span class="number-circle">3</span><span class="text">BOOKING CONFIRMATION</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
    <?php 
    /*if(Yii::app()->controller->id == 'booking' && Yii::app()->controller->action->id == 'index'){
        if(isset($_GET['adult'])){
            $adult=$_GET['adult'];
        }else{
            $adult=2;
        }
        if(isset($_GET['children'])){
            $children = $_GET['children'];
        }else{
            $children = 0;
        }
        if(isset($_GET['hotel_id'])){
            $hotel = $_GET['hotel_id'];
        }else{
            $hotel = '';
        }
        
    }*/?>
    <div class="content">
        <div class="container">
            <div class="row">
                <?php echo $content;?>
            </div>
        </div>
    </div>
<?php if($show_header_footer){?>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12 f-info">
                    <!-- <div class="social">
                        FOLLOW US
                        <ul>
                            <li><a class="fb" target="_blank" href="https://www.facebook.com/tapnguyenit"></a></li>
                            <li><a class="gg" href=""></a></li>
                            <li><a class="sk" href="skype:huytap_vp?chat"></a></li>
                        </ul>
                    </div> -->
                    <div class="card-type">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/rapidssl_ssl_certificate.gif">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/payment-card.jpg"></div>
                </div>

            </div>
            <div class="copyright"><i class="fa fa-copyright" aria-hidden="true"></i> <?php echo date('Y')?> Copyright by onlinesolutions.vn. All rights reserved.</div>
        </div>
    </div>
<?php }?>
</div>
<div id="loading"><span></span></div>
<a href="#" id="back-to-top" title="Back to top" class="show"><span class="fa fa-angle-up"></span></a>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.downCount.js" defer="defer"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.magnific-popup.min.js" defer="defer"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/moment.min.js" defer="defer"></script>
<script type="text/javascript" defer="defer">
    jQuery(function(){
        jQuery('#mapcanvas').height(jQuery('.special-offers').height())
    })
    <?php
    if(isset($_GET['hotel_id']) && isset($_GET['chain_id'])){
     ?>
     var searchUrl = '<?php echo Yii::app()->params["booking"]?>booking/<?php echo $_GET["hotel_id"]?>/<?php echo $_GET["chain_id"]?>/';
     <?php   
    }?>
    var locate = '<?php echo Yii::app()->language;?>';
    var rootUrl='<?php echo Yii::app()->params["link"]?>';
</script>
<script type="text/javascript" defer="defer" src="<?php echo Yii::app()->theme->baseUrl?>/js/main.js"></script>
<script type="text/javascript" defer="defer" src="<?php echo Yii::app()->theme->baseUrl?>/js/lang.js"></script>
</body>
</html>
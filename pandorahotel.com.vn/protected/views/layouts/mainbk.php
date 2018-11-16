<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="NOINDEX,NOFOLLOW" />
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo Yii::app()->theme->baseUrl?>/images/favicon.ico">
    <title>Carino Saigon Hotel Booking</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/bootstrap-material-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/ripples.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/bk/css/toastr.min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/jquery.downCount.js"></script>
    <!-- <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-76560919-1', 'auto');
      ga('send', 'pageview');

    </script> -->
</head>
<body>
<?php //$this->widget('TagmanagerWidget');?>
<div id="wrapper" class="mobile">
    <div class="header">
        <div class="container"> 
            <div class="row">
                <div class="col-md-3 col-xs-12 logo">
                    <a href="<?php echo Yii::app()->params['link'].Yii::app()->session['_lang']?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/logo.png"></a>
                </div>
                
                <div class="col-md-9 col-xs-12 step">
                    <div class="booking-step <?php if(isset($_GET['booking']) && $_GET['booking']=="search"){ echo 'current';}?> col-xs-4 no-padding">
                        <span class="number-circle">1</span><span class="text">SELECT DATE & ROOM</span>
                    </div>
                    <div class="booking-step <?php if(isset($_GET['booking']) && $_GET['booking']=="payment"){ echo 'current';}?> col-xs-4 no-padding">
                        <span class="number-circle">2</span><span class="text">FILLING INFORMATION</span>
                    </div>
                    <div class="booking-step <?php if(isset($_GET['booking']) && $_GET['booking']=="thankyou"){ echo 'current';}?> col-xs-4 no-padding">
                        <span class="number-circle">3</span><span class="text">BOOKING CONFIRMATION</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container  <?php if(isset($_GET['booking']) && $_GET['booking']=="thankyou") echo 'thankyou';?>">
            <div class="row">           
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="glyphicon glyphicon-home"></i> <a href="<?php echo Yii::app()->params['link']?>/<?=Yii::app()->session['_lang']?>">Home</a>
                        </li>
                        <li class="active">Carino Saigon Hotel Booking</li>
                    </ol>
                </div>
            </div>
            <?php if(isset($_GET['booking']) && $_GET['booking']=="search"){?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 specials">
                        <div class="panel panel-default promotion">
                            <div class="panel-heading bg">CARINO SAIGON HOTEL OFFERS</div>

                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                                    <?php
                                        $lang = Yii::app()->session['_lang'];
                                        $hotel = Hotel::model()->getHotelBySlug($_GET['hotel']);
                                        $special = json_decode($hotel['special_offer'], true);
                                        echo $special[$lang];
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php echo $content;?>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 f-logo"><a href="index.html"><img src="<?=Yii::app()->theme->baseUrl?>/images/logo.png"></a></div>
                <div class="col-md-8 col-xs-12 f-info">
                    <div class="social">
                        FOLLOW US
                        <ul>
                            <li><a class="fb" href=""></a></li>
                            <li><a class="gg" href=""></a></li>
                            <li><a class="sk" href=""></a></li>
                        </ul>
                    </div>
                    <div class="card-type">
                        <div id="thawteseal" style="text-align:center;" title="Click to Verify - This site chose Thawte SSL for secure e-commerce and confidential communications.">
                            <div><script type="text/javascript" src="https://seal.thawte.com/getthawteseal?host_name=booking.aristosaigonhotel.com&amp;size=S&amp;lang=en"></script></div>
                            <div><a href="http://www.thawte.com/ssl-certificates/" target="_blank" style="color:#000000; text-decoration:none; font:bold 10px arial,sans-serif; margin:0px; padding:0px;">ABOUT SSL CERTIFICATES</a></div>
                            </div>
                            <img src="<?=Yii::app()->theme->baseUrl?>/bk/images/payment-card.jpg"></div>
                </div>

            </div>
            <div class="copyright">© 2016 Copyright by CARINO SAIGON Hotel. All rights reserved.<br><span style="font-size:10px;">Made by <a href="https://onlinesolutions.vn" target="_blank">Online Solutions Co., Ltd.</a></span></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var locate = '<?php echo Yii::app()->session["_lang"];?>';
</script>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/ripples.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/material.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/toastr.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/lang.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/custom.js?ver=001"></script>
<!--<script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl?>/bk/js/addtocart.js"></script>-->

<script type="text/javascript">
    jQuery(function(){
        jQuery('#mapcanvas').height(jQuery('.special-offers').height())
    })

    var rootUrl = '<?php echo Yii::app()->params["booking"]?>';
</script>
</body>
</html>
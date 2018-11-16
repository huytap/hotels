<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="NOINDEX,NOFOLLOW" />
    <meta name="description" content="Demo Booking Engine, Booking Engine, Thiet ke web dat phong">
    <meta name="author" content="nghuytap@gmail.com">
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
    <title>Demo Booking Engine | Web Đặt Phòng Online | Online Booking Engine</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/bootstrap-material-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/ripples.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/toastr.min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.downCount.js"></script>
</head>
<body>
<div id="wrapper" class="mobile">
    <div class="header">
        <div class="container"> 
            <div class="row">
                <div class="col-md-3 col-xs-12 logo">
                    <h1><a href="<?php echo Yii::app()->params['link'].Yii::app()->session['_lang']?>"><?php 
                    $hotel = Hotel::model()->find();
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$hotel['logo1'].'">';
                    ?></a></h1>
                </div>
                <?php $lang = Yii::app()->session['_lang'];?>
                <div class="col-md-9 col-xs-12 step">
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
                <!--<div class="col-md-9 right">
                    <div class="language">
                        <?php //echo Yii::t('lang', 'language')?>:
                        <?php
                            /*$languages = Yii::app()->params['language_configs'];
                            $html_language = '';
                            $html_active = '';
                            $lang = Yii::app()->session['_lang'];
                            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            foreach($languages as $lg => $lname){
                                if(!strpos($actual_link,'/'.$lang)){
                                    $html_language .= '<a href="'.$actual_link.$lg.'"><img src="'. Yii::app()->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'"> '.$lname.'</a>';
                                }else{
                                    $html_language .= '<a href="'.str_replace('/'.$lang, '/'.$lg, $actual_link).'"><img src="'. Yii::app()->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'">'.$lname.'</a>';
                                }
                            }
                            echo $html_active.$html_language;*/
                        ?>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
    <?php 
    if(Yii::app()->controller->action->id == 'index'){
        if(isset($_GET['adult'])){
            $adult=$_GET['adult'];
        }else{
            $adult=2;
        }
        if(isset($_GET['children'])){
            $children = $_GET['children'];
        }else{
            $children = 0;
        }?>
        <div class="bk-bg">
            <div class="form-book">
                <div class="container">
                    <!--<form method="post" action="<?php echo Yii::app()->baseUrl?>/booking" class="form-bk">-->
                    <div class="row form-bk">
                        <div class="col-sm-2 col-xs-6">
                            <div class="form-group">
                                <label><?php echo Yii::t('lang', 'checkin');?></label>
                                <div class="date" id="dpIn">
                                    <input type="text" id="check-in-date" name="FormBook[checkin]" class="form-control datepicker">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                            <div class="form-group">
                                <label><?php echo Yii::t('lang', 'checkout');?></label>
                                <div class="date" id="dpOut">
                                    <input type="text" id="check-out-date" name="FormBook[checkout]" class="form-control datepicker">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 col-xs-6">
                            <div class="form-group">
                                <label><?php echo Yii::t('lang', 'adult');?></label>
                                <div class="date">
                                    <?php echo CHtml::dropDownlist('FormBook[adult]', $adult, array(1=>1, 2=>2, 3=>3), array('class'=>'form-control'));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 col-xs-6">
                            <div class="form-group">
                                <label><?php echo Yii::t('lang', 'children');?></label>
                                <div class="date">
                                    <?php echo CHtml::dropDownlist('FormBook[children]', $children, array(0,1,2), array('class'=>'form-control'));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-booking" type="button"><?php echo Yii::t('lang', 'check_avaibility');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</form>-->
                </div>
            </div>
        </div>
    <?php }?>
    <div class="content">
        <div class="container  <?php if(Yii::app()->controller->id->action=="index") echo 'thankyou';?>">
            
                <!--<div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 specials">
                        <div class="panel panel-default promotion">
                            <div class="panel-heading bg">SPECIAL OFFERS</div>

                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                                    <?php
                                        $lang = Yii::app()->session['_lang'];
                                        $hotel = Hotel::model()->find();
                                        $special = json_decode($hotel['special_offer'], true);
                                        echo $special[$lang];
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            <?php echo $content;?>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 f-logo"><!-- <a href="index.html"><img src="<?=Yii::app()->baseUrl?>/images/logo.png"></a> --></div>
                <div class="col-md-8 col-xs-12 f-info">
                    <div class="social">
                        FOLLOW US
                        <ul>
                            <li><a class="fb" target="_blank" href="https://www.facebook.com/tapnguyenit"></a></li>
                            <li><a class="gg" href=""></a></li>
                            <li><a class="sk" href="skype:huytap_vp?chat"></a></li>
                        </ul>
                    </div>
                    <div class="card-type"><img src="<?=Yii::app()->baseUrl?>/images/payment-card.jpg"></div>
                </div>

            </div>
            <div class="copyright">© 2016 Copyright by Webkhachsan.net. All rights reserved.</div>
        </div>
    </div>
</div>
<div id="loading"><span></span></div>
<a href="#" id="back-to-top" title="Back to top" class="show"><span class="fa fa-angle-up"></span></a>
<script type="text/javascript">
    var locate = '<?php echo Yii::app()->session["_lang"];?>';
    var rootUrl='Yii::app()->params["link"]';
</script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/ripples.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/material.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/toastr.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/lang.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/backTop.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/custom.js?ver=001"></script>
<!--<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl?>/bk/js/addtocart.js"></script>-->

<script type="text/javascript">
    jQuery(function(){
        jQuery('#mapcanvas').height(jQuery('.special-offers').height())
    })

    var rootUrl = '<?php echo Yii::app()->params["booking"]?>';
</script>
</body>
</html>
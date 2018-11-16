<?php
$room_charge = $book["rate_vnd"]*$book['booked_nights']*$book['no_of_room'];
    $extras=0;

    if(isset($book['pickup_price']) && $book['pickup_price']>0){
        $extras += $book['pickup_price'];
    }
    if(isset($book['dropoff_price']) && $book['dropoff_price']>0){
        $extras += $book['dropoff_price'];
    }
    if(isset($book['extrabed'])){
        $extra = json_decode($book['extrabed'], true);
        for($l=0;$l<count($extra);$l++){
            $extras += $extra[$l+1]*$book['booked_nights'];    
        }                
    }elseif(isset($book['children_extrabed'])){
        $extras += $book['children_extrabed'];
    }

    $packages = BookPackage::model()->getList($book['id']);
    if(count($packages->getData())>0){
        $pack_pr = explode(',', $book->promotion->packages);
        foreach($packages->getData() as $pk){
            if(in_array($pk['package_id'], $pack_pr)){
            }else{
                if($pk->package->is_book)
                    $extras += ($pk->package->rate_child*$pk->child+$pk->package->rate*$pk->adult)*$book['booked_nights']*$pk->exchange_rate;
                else
                    $extras += ($pk->package->rate_child*$pk->child+$pk->package->rate*$pk->adult)*$pk->exchange_rate;
            }
        }
    }
    $vat = $sc = 0;
    $vat_setting = Settings::model()->getSetting('include_vat', $book['hotel_id']);
    if($vat_setting == 'false'){
        $vat += ($room_charge+$extras)*0.1;
        $sc += ($vat + $room_charge+$extras)*0.05;
    }
    
    $total += ($room_charge+$extras+$vat+$sc);

    $promotion_name = json_decode($book['promotion']['name'], true);
    $GA_Items = "ga('ecommerce:addItem', {".
        "'id': '".$book['short_id']."',".
        "'name': '".$book['roomtype']['name']."',".
        "'sku': '".$book['promotion_id']."',".//promotion
        "'category': '".$promotion_name[$lang]."',".
        "'price': '".$room_charge."',".
        "'quantity': '".$book['no_of_room']."',".
        "'currency': 'VND'".
        "});";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="NOINDEX,NOFOLLOW" />
    <meta name="description" content="Booking Engine, Booking Engine, Thiet ke web dat phong">
    <meta name="author" content="Online Solutions Co, Ltd">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo Yii::app()->theme->baseUrl?>/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo Yii::app()->theme->baseUrl?>/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Yii::app()->theme->baseUrl?>/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Yii::app()->theme->baseUrl?>/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->theme->baseUrl?>/images/favicon-16x16.png">
    <title>Booking Engine | Online Booking Engine | Web Đặt Phòng Online | Hotel Booking Engine</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/font-awesome.min.css">
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl?>/css/bootstrap-material-design.min.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/bootstrap-datepicker.css">
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl?>/css/ripples.min.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/toastr.min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.downCount.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.magnific-popup.min.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-87680691-1', 'auto');
      ga('send', 'pageview');

    </script>
    <script type="text/javascript">
        ga('require', 'ecommerce');

        ga('ecommerce:addTransaction', {
          'id': '<?php echo $book["short_id"]?>',
          'affiliation': 'Booking',
          'revenue': '<?php echo ExtraHelper::roundMoney2("VND", $total);?>',
          'shipping':'<?php echo ExtraHelper::roundMoney2("VND", $sc);?>',
          'tax':'<?php echo ExtraHelper::roundMoney2("VND", $vat);?>',
          'currency':'VND'
        });

        ga('ecommerce:addItem', {
          'id': '<?php echo $book["short_id"]?>',                     // Transaction ID. Required.
          'name': '<?php echo $book["roomtype"]["name"];?>',    // Product name. Required.
          'sku': '<?php echo $book["promotion_id"]?>',                 // SKU/code.
          'category': '<?php echo $promotion_name[$lang];?>',         // Category or variation.
          'price': '<?php echo ExtraHelper::roundMoney2("VND", $room_charge);?>',                 // Unit price.
          'quantity': '<?php echo $book["no_of_room"];?>',                   // Quantity.
          'currency': 'VND'
        });

        <?php //echo $GA_Items;?>

        ga('ecommerce:send');
    </script>
</head>
<body>
<div id="wrapper" class="mobile">
<?php
    $show_header_footer = Settings::model()->getSetting('show_header_footer', $hotel['id']);
    if($show_header_footer){
	$background_email_setting = Settings::model()->getSetting('background_email', $hotel['id']);
        $background_email = '';
        if($background_email_setting){
            $background_email = 'background:'.$background_email_setting;
        }
    ?>


    <div class="header" style="<?php echo $background_email;?>">
        <div class="container"> 
            <div class="row">
                <div class="col-md-3 col-xs-12 logo">
                <?php
		$hotel = Hotel::model()->findByPk($book['hotel_id']);
                if($hotel['website']){
                    echo '<a href="'. $hotel['website'].'">';
                }else{
                    echo '<a href="'. Yii::app()->params['link'].'booking/'.$hotel['hotel_id'].'/'.$hotel['chain_id'].'">';
                    
                }
                    
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$hotel['logo1'].'"></a>';
                    ?>
                </div>
                <?php $lang = Yii::app()->session['_lang'];?>
                <div class="col-md-9 col-xs-12">
                    <div class="info">
                        <ul>
                            <li><a href="<?php echo $hotel['website']?>">Home</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl.'/booking/login/'.$hotel['hotel_id'].'/'.$hotel['chain_id']?>">Modify</a></li>
                        </ul>
                    </div>                    
                </div>
            </div>
            
        </div>
    </div>
<?php }?>

    <div class="step" id="step">
        <div class="container"> 
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="booking-step col-xs-4 no-padding">
                        <span class="number-circle">1</span><span class="text">ROOM & RATE</span>
                    </div>
                    <div class="booking-step col-xs-4 no-padding">
                        <span class="number-circle">2</span><span class="text">FILLING INFORMATION</span>
                    </div>
                    <div class="booking-step current col-xs-4 no-padding">
                        <span class="number-circle">3</span><span class="text">BOOKING CONFIRMATION</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $lang = Yii::app()->session['_lang'];?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div id="alerts-main-container">
                            <div class="alert am-fade alert-success" style="display: block;">
                              <button type="button" class="close">×</button>
                              <span>Thank you! Your reservation has been confirmed. We are looking forward to your visit.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="review-reference-number">
                            <h4 class="reference-number-header">Reference Number</h4>
                            <span class="reference-number-txt"><?php echo $book->short_id;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading bg">1. <?php echo Yii::t('lang', 'contact_detail') ?></div>
                            <div class="panel-body white">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php echo Yii::t('lang', 'full_name') ?>: <strong><?=$book['title']?> <?=$book['first_name'].' '. $book['last_name']?></strong>
                                    </div>
                                    <div class="col-sm-6">
                                        Email: <strong><?=$book['email']?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                <?php 
                                if($book['phone']){?>
                                    <div class="col-sm-6">
                                        <?php echo Yii::t('lang', 'phone') ?>: <strong><?php echo $book['phone'] ?></strong>
                                    </div>
                                <?php }?>
                                    <div class="col-md-6">
                                        <?php echo Yii::t('lang', 'nationality') ?>: <strong><?php echo $book['country']; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading bg">2. <?php echo Yii::t('lang', 'payment_detail') ?></div>
                            <div class="panel-body white">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php echo Yii::t('lang', 'card_type') ?>: 
                                            
                                            <?php 
                                                if(isset($book['card_type'])){
                                                    echo '<strong>'.ExtraHelper::$cartType[$book['card_type']].'</strong><br>';
                                                }
                                                echo Yii::t('lang', 'card_no').': <strong>XXX-XXX-XXX-'.$book->four .'</strong>';
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading bg">4. <?=Yii::t('lang','room_detail')?></div>
                            <?php $promotion = json_decode($book['promotion']['name'], true);?>
                            <div class="panel-body white">                    
                                <div class="row">
                                    <div class="col-sm-3"><?=$i.'. '. ExtraHelper::date_2_show($book['checkin']);?> <?=Yii::t('lang', 'to');?> <?=ExtraHelper::date_2_show($book['checkout'])?></div>
                                    <div class="col-sm-4"><?=$book['roomtype']['name'] .' - '. $promotion[$lang]?></div>
                                    <div class="col-sm-3"><?=$book['no_of_room'].' ' .Yii::t('lang', 'room').'&nbsp;&nbsp;&nbsp;'.$book['no_of_adults']*$book['no_of_room'].' ' .Yii::t('lang', 'adult').'&nbsp;&nbsp;&nbsp;'.$book['no_of_child']*$book['no_of_room'].' ' .Yii::t('lang', 'children')?></div>
                                    <div class="col-sm-2 right">VND <?=ExtraHelper::roundMoney3('VND',$book['rate_vnd']*$book['no_of_room']*$book['booked_nights']);?></div>
                                    <?php $total = $book['rate_vnd']*$book['no_of_room']*$book['booked_nights'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading bg">5. <?=Yii::t('lang','room_extras')?></div>
                            <?php $promotion = json_decode($book['promotion']['name'], true);?>
                            <div class="panel-body white">
                                <?php if($book['pickup_vehicle']){?>
                                    <div class="row">
                                        <div class="col-xs-12"><b><?=Yii::t('lang', 'arrival_airport_3')?></b></div>
                                    </div>
                                    <div class="row">
                                            <div class="col-xs-12">
                                                <?=Yii::t('lang', 'arrival_flight');?>: <strong><?=$book['pickup_flight']?></strong>, 
                                                <?=Yii::t('lang', 'date_flight');?>: <strong><?=$book['pickup_date']?></strong>, 
                                                <?=Yii::t('lang', 'airport_pickup_fee');?>:
                                                <strong>
                                                    <?php
                                                        if ($book['pickup_price'] == 0) {
                                                            echo 'Free pick up';
                                                        } else {
                                                            $total += $book['pickup_price'];
                                                            echo 'VND '.    ExtraHelper::roundMoney3('VND',$book['pickup_price']);
                                                        }
                                                    ?>
                                                </strong>, 
                                                <?=Yii::t('lang', 'vehicle_type')?>: <strong><?=str_replace('_','-', $book['pickup_vehicle']);?></strong>
                                            </div>
                                    </div>
                                <?php }?>
                                <?php if($book['dropoff_vehicle']){?>
                                    <div class="row"><div class="col-xs-12"><b><?=Yii::t('lang', 'departure_airport_3')?></b></div></div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?=Yii::t('lang', 'departure_flight');?>: <strong><?=$book['dropoff_flight']?></strong>, 
                                            <?=Yii::t('lang', 'date_flight');?>:
                                            <strong><?=$book['dropoff_date']?></strong>, 
                                            <?=Yii::t('lang', 'airport_drop_fee')?>: 
                                            <strong>
                                            <?php
                                                if ($book['dropoff_price'] == 0) {
                                                    echo 'Free drop-off';
                                                } else {
                                                    $total += $book['dropoff_price'];
                                                    echo 'VND '.ExtraHelper::roundMoney3('VND',$book['dropoff_price']);
                                                }
                                            ?>
                                            </strong>, 
                                            <?=Yii::t('lang', 'vehicle_type')?>: 
                                            <strong><?=str_replace('_','-', $book['dropoff_vehicle'])?></strong>
                                        </div>
                                    </div>
                                <?php }?>
                                <?php if($book['no_of_extrabed']>0){
                                    $total += $book['no_of_extrabed']*$book['extrabed_price']*$book['booked_nights'];?>
                                <hr>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <b><?=Yii::t('lang', 'extrabed_4')?>: </b><?php echo $book['no_of_extrabed'];?>, <?php echo Yii::t('lang', 'fee')?>: <?php echo 'VND '.ExtraHelper::roundMoney3('VND',$book['extrabed_price']*$book['booked_nights']*$book['no_of_extrabed']);?>
                                        </div>
                                    </div>
                                <?php
                                }?>
                                <?php
                                $packages = BookPackage::model()->getList($book['id']);
                                if(count($packages->getData())>0){?>
                                <hr>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <b><?=Yii::t('lang', 'packages')?>: </b>
                                        </div>
                                    </div>

                                <?php
                                $pack_pr = explode(',', $book->promotion->packages);
                                foreach($packages->getData() as $pk){?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?php echo $pk->package->name;?>, <?php echo $pk['adult'] .' '. Yii::t('lang', 'adult').': VND ';
                                            if(in_array($pk['package_id'], $pack_pr)){
                                                echo '0.00';
                                                $price='0.00';
                                            }else{
                                                if($pk->package->is_book){
                                                    $total += ($pk->package->rate_child*$pk->child+$pk->package->rate*$pk->adult)*$book['booked_nights']*$pk->exchange_rate;
                                                    $price=ExtraHelper::roundMoney3('VND',$pk->package->rate_child*$pk->child*$pk->exchange_rate*$book['booked_nights']);
                                                    echo ExtraHelper::roundMoney3('VND',$pk->package->rate*$pk->adult*$pk->exchange_rate*$book['booked_nights']);
                                                }
                                                else{
                                                    $total += ($pk->package->rate_child*$pk->child+$pk->package->rate*$pk->adult)*$pk->exchange_rate;
                                                    $price=ExtraHelper::roundMoney3('VND',$pk->package->rate_child*$pk->child*$pk->exchange_rate);
                                                    echo ExtraHelper::roundMoney3('VND',$pk->package->rate*$pk->adult*$pk->exchange_rate);
                                                }
                                                
                                            }?>
                                            <?php 
                                            
                                            if($pk['child']>0){
                                                echo ', '.$pk['child'] .' ' .Yii::t('lang', 'children').': ';
                                                echo $price;
                                            }?>
                                        </div>
                                    </div>
                                <?php
                                }
                                }?>
                            </div>
                        </div>
                    </div>
                    <div class="row total-text">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <?php
                            if($vat_setting=='false'){?>
                            <div class="col-md-6">Total:</div>
                            <div class="col-md-6"><?=ExtraHelper::roundMoney3('VND',$total);?> VND</div>
                            
                            <div class="col-md-6">VAT(10%):</div>
                            <div class="col-md-6"><?php $vat = $total*10/100;echo ExtraHelper::roundMoney3('VND',$vat);?>  VND</div>
                            <div class="col-md-6">Services Charges(5%):</div>
                            <div class="col-md-6"><?php $sc = ($vat+$total)*5/100; echo ExtraHelper::roundMoney3('VND',$sc);?> VND</div>
                            <?php }?>
                            <div class="col-md-6"><strong>GRAND TOTAL:</strong></div>
                            <div class="col-md-6"><strong><?=ExtraHelper::roundMoney3('VND',ExtraHelper::roundMoney2('VND', $total+$vat+$sc));?> VND</strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 information">
                    <div class="panel panel-default">
                        <div class="panel-heading bg heading-title up"><?=Yii::t('lang', 'contact_info');?></div>
                        <div class="panel-body">
                            <div class="hotel-details">
                                <?php
                                    $address = json_decode($book->hotel->address, true);
                                    $city = json_decode($book->hotel->city, true);
                                    $country = json_decode($book->hotel->country, true);
                                ?>
                                <h5><?php echo $book->hotel['name'];?></h5>
                                <p>
                                  <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                                  <span><?php echo $address[$lang].', '. $city[$lang].', '.$country[$lang];?></span>
                                </p>

                                <p>
                                  <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                                  <span><a href="tel:<?php echo $hotel['tel']?>"><?php echo $book->hotel['tel']?></a></span>
                                  <span><?php echo $book->hotel['fax']?></span>
                                </p>

                                <p>
                                  <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                  <span class="details-contact-txt"><a href="mailto:<?php echo $book->hotel['email_sales']?>"><?php echo $book->hotel['email_sales']?></a></span>
                                </p>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    if($show_header_footer){
    ?>
    <div class="footer" style="<?php echo $background_email;?>">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12 f-info">
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
<script type="text/javascript">
    var locate = '<?php echo Yii::app()->session["_lang"];?>';
    var rootUrl='<?php echo Yii::app()->params["link"]?>';
</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/bootstrap-datepicker.min.js"></script>
<!--<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/ripples.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/material.min.js"></script>-->

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/toastr.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/lang.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/backTop.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/custom.js?ver=001"></script>
<!--<script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl?>/bk/js/addtocart.js"></script>-->

<script type="text/javascript">
    jQuery(function(){
        jQuery('#mapcanvas').height(jQuery('.special-offers').height())
    })
    <?php
    if(isset($_GET['hotel_id']) && isset($_GET['chain_id'])){
     ?>
     var searchUrl = '<?php echo Yii::app()->params["booking"]?>booking/<?php echo $_GET["hotel_id"]?>/<?php echo $_GET["chain_id"]?>/';
     <?php   
    }?>
    //var rootUrl = '<?php echo Yii::app()->params["booking"].$_GET["hotel"]?>/';
</script>
</body>
</html>
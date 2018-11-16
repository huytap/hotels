<?php
if(Yii::app()->session['_lang'] == 'ja' || Yii::app()->session['_lang'] == 'cn'){
    $lang = 'en';
}else{
    $lang=Yii::app()->session['_lang'];
}
$address = json_decode($hotel['address'], true);
$city = json_decode($hotel['city'], true);
$country = json_decode($hotel['country'], true);
$special_offers = json_decode($hotel['special_offer'], true);?>
<table style="font-size:12px;font-family:arial,sans-serif;width: 98%;" border="0" cellspacing="0" cellpadding="0" >
    <tr style="height:19.95pt;background: #0b1317;color: #fff;">
        <td valign=top style="padding: 10px;height:19.95pt;font-size:12px;">
            <h1 style="font-size:18px;font-family:arial,sans-serif;margin:0;">
                <a style="text-decoration:none;color:#fff;" href="<?php echo Yii::app()->params['link']?>">
                <img src="http://aristosaigonhotel.com/themes/aristosaigonhotel/images/logo_email.jpg?>" alt="<?php echo $hotel['name']?>"></a>
            </h1>
        </td>
        <td style="line-height: 20px;padding:10px;height:19.95pt;font-size:12px;" valign="top">
            <span style="font-family:arial,sans-serif;font-size:12px;"><?php echo Yii::t('lang', 'address_3')?>: <?php echo $address[$lang].', '.$city[$lang].', '.$country[$lang]; ?></span>
            <br>
            Website: <u><span style="color:blue">
            <a target="_blank" style="color:#fff;" href="http://aristosaigonhotel.com">aristosaigonhotel.com</a>
        </span></u> <br> 
        Email: <u><span>
                <a style="color:#fff;" href="mailto:<?php echo $hotel['email_info'] ?>"><?php echo $hotel['email_info']; ?></a></span></u><br>
        <?php echo Yii::t('lang', 'tel')?>: <?php echo $hotel['tel'];?><br>
        <?php
        if ($hotel['hotline'] !== '') {
            echo 'Hotline: ' . $hotel['hotline'];
        }
        ?>
    </td></tr>
</table>

<table style="width: 98%;border-collapse: collapse;" border="1" cellpadding="0" cellspacing="0">
    <tr><td align="center" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;">
            <h2 style="margin-top: 10px;text-align: center;">RESERVATION LETTER</h2></td></tr>
    <tr><td align="right" valign="middle" style="padding:10px;font-size:12px;font-family:arial,sans-serif">
            Booking ID: <strong><?php echo strtoupper($booked['short_id']); ?></strong><br>
            Request Date: <?php echo date('d M y H:m:i', strtotime($booked->request_date)); ?> Ho Chi Minh City Time</td></tr>
    <tr><td valign="middle">
            <table width="100%" border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0"><tr>
                    <td align="left" width="150px" style="padding:10px;font-size:12px;font-family:arial,sans-serif">Booker:</td>
                    <td align="left" style="padding:10px;font-size:12px;font-family:arial,sans-serif">
                        <?php echo ucfirst($booked['first_name']); ?> 
                        <?php echo ucfirst($booked['last_name']); ?></td></tr>
                <tr><td align="left" width="150px" style="padding:10px;font-size:12px;font-family:arial,sans-serif">Email:</td>
                    <td align="left" style="padding:10px;font-size:12px;font-family:arial,sans-serif">
                        <a href="mailto:<?php echo $booked['email']; ?>" target="_blank">
                            <?php echo $booked['email']; ?></a>
                    </td></tr></table>
        </td></tr>
    <tr>
        <td valign="middle">
            <table style="border-collapse:collapse;width:100%" border="1" cellpadding="10" cellspacing="0">
                <tbody>
                    <tr>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'guestname');?></strong></td>
                        
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'promtion');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'no_room');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'no_adult');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'no_of_child');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'checkin');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'checkout');?></strong></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong><?=Yii::t('lang', 'rate_per_night');?> (<?php echo $booked['currency']?>)</strong></td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif">
                            <?php echo $booked['first_name'].' '.$booked['last_name'];?>
                        </td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif">
                            <?php echo $booked['roomtype']['name']; ?><br>
                            <?php 
                                $promotion = json_decode($booked['promotion']['name'], true);

                                echo $promotion[$lang];
                            ?>
                        </td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><?php echo $booked['no_of_room']; ?></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><?php echo $booked['no_of_adults']; ?></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><?php echo $booked['no_of_child'];?></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><?php echo date('d M Y', strtotime($booked['checkin'])); ?></td>
                        <td align="center" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><?php echo date('d M Y', strtotime($booked['checkout'])); ?></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;"><?php echo number_format($booked['rate_vnd'], 2); ?></td>
                    </tr>
                    <?php if($booked['notes']):?>        
                        <tr>
                            <td align="left" style="padding:10px;font-size:12px;font-family:arial,sans-serif"><strong>Notes</strong></td>
                            <td align="left" colspan="8" style="word-wrap:break-word;width:78%;padding:10px;font-size:12px;font-family:arial,sans-seriftext-align:left;">
                                <?php echo $booked['notes']; ?>
                            </td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </td>
    </tr>
    
    <tr>
        <td valign="middle" style="border-collapse:collapse;border:1px solid #000000;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody>

                    <tr>
                        <?php if($booked['pickup_price']>0):?>
                            <td align="left" valign="middle" style="padding:10px;font-size:12px;font-family:arial,sans-serifwidth: 10%;border:1px soild #000;"><strong>Arrival airport:</strong></td>
                            <td align="left" style="border-right:1px soild #000;word-wrap:break-word;padding:10px;font-size:12px;font-family:arial,sans-serifwidth: 30%" valign="middle">
                                <?php echo $booked['pickup_flight'] .' - ' . $booked['pickup_time'].' '.$booked['pickup_date'].' - '.number_format($booked['pickup_price'],2);?> VND
                            </td>
                        <?php endif;?>
                        <?php
                        if($booked['dropoff_price']>0):?>
                            <td align="left" valign="middle" style="padding:10px;font-size:12px;font-family:arial,sans-serifwidth: 15%"><strong>Departure see off:</strong></td>
                            <td align="left" style="font-size:12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;width: 30%;border-right:1px soild #000;">
                                <?php echo $booked['dropoff_flight'] .' - ' . $booked['dropoff_time'].' '.$booked['dropoff_date'].' - '.number_format($booked['dropoff_price'],2);?> VND
                            </td>
                        <?php endif;?>
                    </tr>
                    <tr><td colspan="4" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px soild #000;">
                            For information, please contact: <strong><?php echo $hotel['email_info'];?></strong> Tel <strong><?php echo $hotel['tel'];?></strong><br></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="middle" style="padding:10px;font-size:12px;font-family:arial,sans-serif;border:1px solid #000000;">
            <strong>Total to be paid in VND (include VAT & Service Charge Rate): <?php echo number_format($booked['total_vnd'], 2) ?></strong> (~ <?php echo number_format($booked['total']/$booked['change_currency_rate'],2);?> USD)
        </td>
    </tr>
    <?php
    if(is_array($special_offers)):?>
        <tr>
            <td valign="middle" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000;">
                <?php
                    echo $special_offers[$lang];
                ?>
            </td>
        </tr>
    <?php endif;?>
    <tr>
        <td valign="middle" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000;">
            <p>Notes: kindly be informed that your booking has not been paid yet. Credit card verification and/or full payment should be requested in 7 days before check-in date.</p>
        </td>
    </tr>
    <tr>
        <td valign="middle" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000;">
            Any cancellations received less than 168 hours (07 days) before 12.00 pm of arrival date will be subject to a cancellation fee, equal to the amount of 01 night room charge. Failure to arrive at your hotel will incur 100% of total amount of the booking.
        </td>
    </tr>
    <tr>
        <td style="padding:10px;font-size:12px;font-family:arial,sans-serif">
            <h3>Terms & Conditions</h3>
            <?php $condition = Yii::app()->params['condition'];echo $condition;?>
        </td>
    </tr>
</table>
<table style="font-size:12px;font-family:arial,sans-serif;" border="0" cellspacing="0" cellpadding="0" >
    <tr style="height:19.95pt">
        <!-- <td style="padding: 10px;font-size:12px;font-family:arial,sans-serif;width: 180px;">
            <a href="">Hai Long 5 Hotel</a>
        </td> -->

        <td valign=top style="padding: 10px;height:19.95pt;font-size:12px;">
            <h1 style="font-size:18px;font-family:arial,sans-serif;margin:0;">
                <a style="text-decoration:none;color:#000;" href="<?php echo Yii::app()->params['link']?>/.html">
                <img src="http://www.hailong5hotel.com/images/logo2.png" alt="Hai Long 5 Hotel"></a>
            </h1>
            <span style="font-family:arial,sans-serif;font-size:12px;">Address: <?php echo $hotel['address'].' '.$hotel['city'].' '.$hotel['country']; ?></span>
            <br>
            Website: <u><span style="color:blue">
            <a target="_blank" href="http://www.hailong5hotel.com">www.hailong5hotel.com</a>
        </span></u> <br> 
        Email: <u><span style="color:blue">
                <a href="mailto:<?php echo $hotel['email_info'] ?>"><?php echo $hotel['email_info']; ?></a></span></u><br>
        Tel: <?php echo $hotel['tel'];?><br>
        <?php
        if ($hotel['hotline'] !== '') {
            echo 'Hotline: ' . $hotel['hotline'];
        }
        ?>
    </td></tr>
</table>

<table style="width: 98%;border-collapse: collapse;" border="1" cellpadding="0" cellspacing="0">
    <tr><td align="center" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;">
            <h2 style="margin-top: 10px;text-align: center;">RESERVATION FORM</h2></td></tr>
    <tr><td align="right" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
            Booking ID: <strong><?php echo $booked['short_id']; ?></strong><br>
            Request Date: <?php echo date('d M y H:m:i', strtotime($booked->request_date)); ?> Saigon Time</td></tr>
    <tr><td valign="middle">
            <table width="100%" border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0"><tr>
                    <td align="left" width="150px" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">Booker:</td>
                    <td align="left" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
                        <?php echo ucfirst($booked['first_name']); ?> 
                        <?php echo ucfirst($booked['last_name']); ?></td></tr>
                <tr><td align="left" width="150px" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">Email:</td>
                    <td align="left" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;;border-collapse:collapse;">
                        <a href="mailto:<?php echo $booked['email']; ?>" target="_blank">
                            <?php echo $booked['email']; ?></a>
                    </td></tr></table>
        </td></tr>
    <tr><td valign="middle" style="border-collapse:collapse;border:1px solid #000000;">
            <table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;">
                <tbody><tr>
                        <!-- <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:4%;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong><?php //echo ucfirst(Yii::t('lang', 'no')); ?></strong></td> -->
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:19%;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Guest stay</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:19%;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Roomtype</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:27%;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>No. Adults</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:4%"><strong>No. Rooms</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:4%"><strong>Extrabed</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:4%"><strong>Check-in</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:4%"><strong>Check-out</strong></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:0;border-left:0"><strong>Rate per room per night (VND)</strong></td>
                    </tr>

                    <tr>
                        <!-- <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php //echo $order; ?></td> -->
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                            <?php echo $booked['first_name'].' '.$booked['last_name'];?>
                        </td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                            <?php echo $booked['roomtype']['name']; ?><br>
                            <?php echo $booked['promotion']['name']; ?></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $booked['no_of_adults']; ?></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $booked['no_of_room']; ?></td>->
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                            <?php echo $booked['no_of_extrabed'];?>
                        </td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo date('d M Y', strtotime($booked['checkin'])); ?></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo date('d M Y', strtotime($booked['checkout'])); ?></td>
                        <td align="center" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;"><?php echo number_format($booked['rate_vnd'], 2); ?></td>
                    </tr>
                            
                    <tr>
                        <td align="left" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;"><strong>Notes</strong></td>
                        <td align="left" colspan="7" style="word-wrap:break-word;width:78%;font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;text-align:left;">
                            <?php echo $booked['notes']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    
    <tr>
        <td valign="middle" style="border-collapse:collapse;border:1px solid #000000;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody>

                    <tr>
                        <?php if(isset($booked['pickup_price'])):?>
                            <td align="left" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;width: 10%;border:1px soild #000;"><strong>Arrival airport:</strong></td>
                            <td align="left" style="border-right:1px soild #000;word-wrap:break-word;font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;width: 30%" valign="middle">
                                <?php echo $booked['pickup_flight'] .' - ' . $booked['pickup_time'].' '.$booked['pickup_date'].' - '.number_format($booked['pickup_price'],2);?> VND
                            </td>
                        <?php endif;?>
                        <?php
                        if(isset($booked['dropoff_price'])):?>
                            <td align="left" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;width: 15%"><strong>Departure see off:</strong></td>
                            <td align="left" style="font-size:12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;width: 30%;border-right:1px soild #000;">
                                <?php echo $booked['dropoff_flight'] .' - ' . $booked['dropoff_time'].' '.$booked['dropoff_date'].' - '.number_format($booked['dropoff_price'],2);?> VND
                            </td>
                        <?php endif;?>
                    </tr>
                    <tr><td colspan="4" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;">
                            For information, please contact: <strong><?php echo $hotel['email_info'];?></strong> Tel <strong><?php echo $hotel['tel'];?></strong><br></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border:1px solid #000000;">
            <strong>Total to be paid in VND (include VAT & Service Charge Rate): <?php echo number_format($booked['total_vnd'], 2);?></strong> 
            <?php if($booked['currency'] !== 'VND'):?>
                (~ <?php echo number_format($booked['total'], 2) ?> <?php echo $booked['currency'];?>)
            <?php endif;?>
        </td>
    </tr>
    <!-- <tr>
            <td valign="middle" style="font-size:12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border:1px solid #000000;" align="left">
                <strong>All rates:</strong>
                included daily buffet breakfast (breakfast is not applied for Deluxe-room only, and Premier Deluxe-room only), WIFI , Mineral water , tea , coffee daily in room
            </td>
        </tr>    
    -->
    <?php
    if(Yii::app()->params['special_offers']):?>
        <tr>
            <td valign="middle" align="left" style="padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000;">
                <?php
                    echo Yii::app()->params['special_offers'];
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
</table>
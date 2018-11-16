<table border="0" cellpadding="10" cellspacing="0" width="600">
    <tr>
        <td>
            <a style="font-size:18px;font-family:Verdana, Arial;margin-top:13px;text-transform:uppercase;color:#000;text-decoration:none;" href="<?php echo Yii::app()->params['link'] ?>/" target="_blank">
                <img src="<?php echo Yii::app()->params['link'];?>/images/<?php echo $hotel['logo1']?>" alt="<?php echo $hotel['name']?>">
            </a>
        </td>
    </tr>
    <tr>
        <td height="20" style="font-family: arial, tahoma;font-size:12px;">
            Contact from website <?php echo Yii::app()->params['link'];?>
        </td>
    </tr>
    <tr>
        <td style="font-family: arial, tahoma;font-size:12px;line-height:20px;">
            <p>Name: <?=$model['name']?></p>
            <?php if(isset($model['phone'])):?>
                <p>Phone: <?=$model['phone']?>.</p>
            <?php endif;?>
            <p>Email: <?=$model['email']?></p>
            <p>Message: <?=$model['body']?>.</p>
        </td>
    </tr>
</table>
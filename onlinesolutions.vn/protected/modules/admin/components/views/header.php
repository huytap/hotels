<?php
    /*if(Yii::app()->session['hotel']){
        $getHotel = Hotel::model()->getHotel(Yii::app()->session['hotel']);
    }
    if($user->hotel_id !== 0 && 
        $user->hotel_id !== ''){
        $hid = explode(',', $user->hotel_id);
        foreach($hid as $h){
            $ht = Hotel::model()->findByPk($h);
            echo '<li><a onclick="getHotel('.$ht['id'].')" href="javascript:void(0);">'.$ht['name'].'</a></li>';     
        }
    }else{
        if(isset($user['chain_id'])){
            $hotels = Hotel::model()->getListByChain($user['chain_id']);
        }elseif(Yii::app()->user->id==1){
            $hotels = Hotel::model()->getList2();
        }else{
            header("Location:".Yii::app()->createUrl('admin/site/logout'));
        }

        foreach ($hotels as $key => $value) {
            echo '<li><a onclick="getHotel('.$key.')" href="javascript:void(0);">'.$value.'</a></li>';
        }
    }*/

?>
<div id="top-nav" class="fixed skin-6">
    <a href="#" class="brand">
        <span>Hotel</span>
        <span class="text-toggle"> Administrator</span>
    </a><!-- /brand -->                 
    <button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php 
    /*if(Yii::app()->user->getState('hotel_id') !== 0 || count(Hotel::model()->findAll())<2){
        if(Yii::app()->session['hotel']){
            $getHotel = Hotel::model()->getHotel(Yii::app()->session['hotel']);
            echo '<ul class="nav-notification clearfix" style="display:inline-block;float:left;">';
            echo '<li><a class="dropdown-toggle" href="#">'.$getHotel['name'].'</a></li>';
            echo '</ul>';
        }
    }else{*/?>
    <form id="form-hotel" method="post" style="display:inline-block">
        <ul class="nav-notification clearfix">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php
                    $getHotel = Hotel::model()->getHotel(Yii::app()->session['hotel']);
                    ?>
                    <strong><?php echo $getHotel['name'];?></strong>
                    <?php
                    if(count($hotels)>1){?>
                        <span><i class="fa fa-chevron-down"></i></span>
                    <?php }?>
                </a>
                <?php
                if(count($hotels)>1){?>
                    <ul class="dropdown-menu message dropdown-1">
                        <?php
                        foreach ($hotels as $key => $value) {
                            echo '<li><a onclick="getHotel('.$key.')" href="javascript:void(0);">'.$value.'</a></li>';
                        }?>                
                    </ul>
                <?php }?>
            </li>
        </ul>
    </form>
    <?php
    //}?>
    <ul class="nav-notification clearfix">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-lg"></i>
                <span class="notification-label bounceIn animation-delay6"><?php echo count($noti_booking);?></span>
            </a>
            <?php if(count($noti_booking) >0):?>
                <ul class="dropdown-menu notification dropdown-3">
                    <li><a href="#">Lasted Booking Records</a></li>     
                    <?php foreach ($noti_booking as $key => $value) {
                        if($value->status == 'confirmed'){?>
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('admin/booking/view', array('id'=>$value->id));?>">
                                    <!-- <span class="notification-icon bg-success">
                                        <i class="fa fa-usd"></i>
                                    </span> -->
                                    <span class="m-left-xs">
                                        <span style="color:#ff0000;text-transform: uppercase;">
                                            <?php echo $value['short_id']?>
                                        </span> 
                                        <?php echo $value->roomtype->name;?>
                                    </span>

                                    <span class="time text-muted"><?php echo ExtraHelper::expiry_time_2_show($value->request_date);?></span>
                                    </span>
                                    <span class="m-left-xa" style="display:block;color:blue">New Booking</span>
                                </a>
                            </li>
                    <?php
                        }elseif($value->status == 'amended'){?>
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('admin/booking/view', array('id'=>$value->id));?>">
                                    <span class="notification-icon bg-danger">
                                        <i class="fa fa-usd"></i>
                                    </span>
                                    <span class="m-left-xs">Amended Booking.</span>
                                    <span class="time text-muted"><?php echo ExtraHelper::expiry_time_2_show($value->request_date);?></span>
                                </a>
                            </li>
                    <?php
                        }elseif($value->status == 'cancelled'){?>
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('admin/booking/view', array('id'=>$value->id));?>">
                                    <span class="notification-icon bg-danger">
                                        <i class="fa fa-usd"></i>
                                    </span>
                                    <span class="m-left-xs">Cancelled Booking.</span>
                                    <span class="time text-muted"><?php echo ExtraHelper::expiry_time_2_show($value->request_date);?></span>
                                </a>
                            </li>
                    <?php
                        }elseif($value->status == 'failed'){?>
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('admin/booking/view', array('id'=>$value->id));?>">
                                    <span class="notification-icon bg-warning">
                                        <i class="fa fa-usd"></i>
                                    </span>
                                    <span class="m-left-xs">Failed Booking.</span>
                                    <span class="time text-muted"><?php echo ExtraHelper::expiry_time_2_show($value->request_date);?></span>
                                </a>
                            </li>
                    <?php
                        }
                    }?>
                    <li><a href="<?php echo Yii::app()->createUrl('admin/booking/admin');?>">See all booking records</a></li>                   
                </ul>
            <?php endif;?>
        </li>
        <li class="profile dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <strong><?php echo $user['fullname'];?></strong>
                <span><i class="fa fa-chevron-down"></i></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="clearfix" href="#">
                        <img src="<?php echo Yii::app()->theme->baseUrl?>/img/<?php echo $user['gender']?>.png" alt="User Avatar">
                        <div class="detail">
                            <strong><?php echo $user['fullname'];?></strong>
                            <p class="grey"><?php echo $user['email'];?></p> 
                        </div>
                    </a>
                </li>
                <li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('admin/default/changepassword', array('id' => Yii::app()->user->id))?>" class="main-link"><i class="fa fa-edit fa-lg"></i> Change password</a></li>
                <!-- <li><a tabindex="-1" href="gallery.html" class="main-link"><i class="fa fa-picture-o fa-lg"></i> Photo Gallery</a></li>
                <li><a tabindex="-1" href="#" class="theme-setting"><i class="fa fa-cog fa-lg"></i> Setting</a></li> -->
                <li class="divider"></li>
                <li><a tabindex="-1" class="main-link logoutConfirm_open" href="<?php echo Yii::app()->createUrl('admin/site/logout')?>"><i class="fa fa-lock fa-lg"></i> Log out</a></li>
            </ul>
        </li>
    </ul>
</div><!-- /top-nav-->
<script type="text/javascript">
    function getHotel(id){
        jQuery('#form-hotel').append('<input type="hidden" name="_hotel" value="' + id + '" >');
        jQuery('#form-hotel').submit();
        return false;
    }
</script>
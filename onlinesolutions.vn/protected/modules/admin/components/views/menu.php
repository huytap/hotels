<aside class="fixed skin-6">
    <div class="sidebar-inner scrollable-sidebar">
        <div class="size-toggle">
            <a class="btn btn-sm" id="sizeToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="btn btn-sm pull-right logoutConfirm_open"  href="<?php echo Yii::app()->baseUrl?>/admin/site/logout">
                <i class="fa fa-power-off"></i>
            </a>
        </div>
        <div class="user-block clearfix">
            <img style="background: #fff" src="<?php echo Yii::app()->theme->baseUrl?>/img/<?php echo $user['gender']?>.png" alt="User Avatar">
            <div class="detail">
                <strong><?php echo $user['fullname']?></strong><!-- <span class="badge badge-danger m-left-xs bounceIn animation-delay4">4</span> -->
                <ul class="list-inline">
                    <!-- <li><a href="inbox.html" class="no-margin">Inbox</a></li> -->
                </ul>
            </div>
        </div><!-- /user-block -->
        <div class="search-block">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="search here...">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /search-block -->
        <div class="main-menu">
            <ul>
                <?php
                if(Yii::app()->session['hotel'] && Yii::app()->user->id>1){
                    $hotel = Hotel::model()->findByPk(Yii::app()->session['hotel']);?>
                    <li class>
                        <a href="<?php echo Yii::app()->baseUrl.'/admin/hotel/view/hotelid/'.$hotel['hotel_id'].'/chainid/'.$hotel['chain_id']?>">
                            <span class="menu-icon">
                                <i class="fa fa-building-o fa-lg"></i> 
                            </span>
                            <span class="text">
                                Property Info
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li class="openable">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa fa-pencil-square-o fa-lg"></i> 
                            </span>
                            <span class="text">
                                Website Content
                            </span>
                            <span class="menu-icon">
                                <i class="fa fa-angle-down fa-lg"></i> 
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo Yii::app()->createUrl('admin/roomtype/admin');?>"><span class="submenu-label">Roomtype</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/gallery/admin');?>"><span class="submenu-label">Photos</span></a></li>
                        </ul>
                    </li>
                    <li class="openable">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa fa-money fa-lg"></i> 
                            </span>
                            <span class="text">
                                Rooms & Rate
                            </span>
                            <span class="menu-icon">
                                <i class="fa fa-angle-down fa-lg"></i> 
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            
                            <li><a href="<?php echo Yii::app()->createUrl('admin/room/admin');?>"><span class="submenu-label">Room control</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/rate/admin');?>"><span class="submenu-label">Rate Control</span></a></li>
                            <!-- <li><a href="<?php //echo Yii::app()->createUrl('admin/promotioncode/admin');?>"><span class="submenu-label">Promotion Code Control</span></a></li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/promotion/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-tag fa-lg"></i> 
                            </span>
                            <span class="text">
                                Promotions
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/package/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-puzzle-piece fa-lg"></i> 
                            </span>
                            <span class="text">
                                Add Services
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/booking/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart fa-lg"></i> 
                            </span>
                            <span class="text">
                                Bookings
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/settings/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-cog fa-lg"></i> 
                            </span>
                            <span class="text">
                                Settings
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                <?php }else{
                        ?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/booking/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart fa-lg"></i> 
                            </span>
                            <span class="text">
                                Bookings Control
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li class="openable">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa fa-tag fa-lg"></i> 
                            </span>
                            <span class="text">
                                Hotel Setting
                            </span>
                            <span class="menu-icon">
                                <i class="fa fa-angle-down fa-lg"></i> 
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo Yii::app()->createUrl('admin/chain/admin');?>"><span class="submenu-label">Chain Management </span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/hotel/admin');?>"><span class="submenu-label">Hotel Management</span></a></li>
                        </ul>
                    </li>
                    <li class="openable">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa fa-money fa-lg"></i> 
                            </span>
                            <span class="text">
                                Room Setting
                            </span>
                            <span class="menu-icon">
                                <i class="fa fa-angle-down fa-lg"></i> 
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo Yii::app()->createUrl('admin/roomtype/admin');?>"><span class="submenu-label">Roomtype</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/room/admin');?>"><span class="submenu-label">Room control</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/rate/admin');?>"><span class="submenu-label">Rate Control</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/promotion/admin');?>"><span class="submenu-label">Promotion Control</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/package/admin');?>"><span class="submenu-label">Package Control</span></a></li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/package/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-picture-o fa-lg"></i> 
                            </span>
                            <span class="text">
                                Add Services
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/gallery/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-picture-o fa-lg"></i> 
                            </span>
                            <span class="text">
                                Gallery
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            <li></li>
                        </ul>
                    </li>
                    <li class="openable">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa fa-user fa-lg"></i> 
                            </span>
                            <span class="text">
                                Users
                            </span>
                            <span class="menu-icon">
                                <i class="fa fa-angle-down fa-lg"></i> 
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo Yii::app()->createUrl('admin/user/admin');?>"><span class="submenu-label">Users</span></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('admin/roles/admin');?>"><span class="submenu-label">Roles</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/settings/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-cog fa-lg"></i> 
                            </span>
                            <span class="text">
                                Settings
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <?php }?>
                    <li>
                        <a target="_blank" href="<?php echo Yii::app()->createUrl('file/Guide.pdf');?>">
                            <span class="menu-icon">
                                <i class="fa fa-question-circle fa-lg"></i> 
                            </span>
                            <span class="text">
                                Guider
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>    
            </ul>
        </div><!-- /main-menu -->
    </div><!-- /sidebar-inner -->
</aside>
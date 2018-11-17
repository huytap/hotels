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
                <li class>
                    <a href="<?php echo Yii::app()->baseUrl?>/admin/hotel/admin">
                        <span class="menu-icon">
                            <i class="fa fa-th-large"></i> 
                        </span>
                        <span class="text">
                            Hotel Control
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>
                <?php
                if(Yii::app()->session['hotel']){?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/roomtype/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-th-large"></i> 
                            </span>
                            <span class="text">
                                Roomtype
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/cms/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-th-large"></i> 
                            </span>
                            <span class="text">
                                Content Control
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/special/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-th-large"></i> 
                            </span>
                            <span class="text">
                                Sepcial Offers
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('admin/trip/admin');?>">
                            <span class="menu-icon">
                                <i class="fa fa-th-large"></i> 
                            </span>
                            <span class="text">
                                Trip Advisor
                            </span>
                            <span class="menu-hover"></span>
                        </a>
                    </li>
                <?php
                }?>
                <li class="openable">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-th-large"></i> 
                        </span>
                        <span class="text">
                            Gallery
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?php echo Yii::app()->createUrl('admin/gallery/admin');?>">Gallery</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('admin/slideshow/admin/type/1');?>">Sliders</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('admin/slideshow/admin/type/2');?>">Banner Pages</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('admin/settings/admin');?>">
                        <span class="menu-icon">
                            <i class="fa fa-th-large"></i> 
                        </span>
                        <span class="text">
                            Settings
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>
            </ul>
        </div><!-- /main-menu -->
    </div><!-- /sidebar-inner -->
</aside>
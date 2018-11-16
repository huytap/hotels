<article class="ar-header">
    <div class="container">
        <a class="logo" href="<?php echo Yii::app()->baseUrl.'/'.Yii::app()->language;?>"><img src="<?php echo Yii::app()->baseUrl?>/images/carino.png" alt="Carino SaiGon Hotel"></a>
        <div class="boxrights">
            <div class="topright"><?php echo Yii::t('lang', 'Language');?> 
                <?php
                //$languages = array('vi' => 'Tiếng Việt','en' => 'English','ja' => '日本語', 'cn' => '简体中文');
                $languages = array('vi' => 'Tiếng Việt','en' => 'English');
                $html_language = '';
                $html_active = '';
                $lang = Yii::app()->session['_lang'];
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                foreach($languages as $lg => $lname){ 
                    if(!strpos($actual_link,'/'.$lang)){
                        $html_language .= '<a href="'.$actual_link.$lg.'"><img src="'. Yii::app()->theme->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'"></a>';
                    }else{
                        $html_language .= '<a href="'.str_replace('/'.$lang, '/'.$lg, $actual_link).'"><img src="'. Yii::app()->theme->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'"></a>';
                    }
                }
                echo $html_active.$html_language;
                ?>
            </div>

            <div class="material-menu-button"><span></span><span></span><span></span></div>
            <div class="material-menu navCarino">
                <ul class="navbar-nav">
                    <li><a class="selected" href="<?php echo Yii::app()->params['link'].$lang?>"><?php echo Yii::t('lang', 'Home');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/about"><?php echo Yii::t('lang', 'About us');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/gallery"><?php echo Yii::t('lang', 'Gallery');?></a></li>
                    <li>
                        <a href="<?php echo Yii::app()->params['link'].$lang?>/rooms"><?php echo Yii::t('lang', 'Rooms & Suites');?>
                            <span class="glyphicon glyphicon-menu-down" ></span>
                        </a>
                        <ul>
                            <?php
                                $rooms = Roomtype::model()->getList(0);
                                foreach($rooms->getData() as $room){
                                    echo '<li><a href="'.Yii::app()->params['link'].$lang.'/rooms/'.$room['slug'].'">'.$room['name'].'</a></li>';
                                }
                            ?>
                        </ul>
                    </li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/special-offers"><?php echo Yii::t('lang', 'Special Offers');?></a></li>
                    <li>
                        <a href="<?php echo Yii::app()->params['link'].$lang?>/services">
                            <?php echo Yii::t('lang', 'Services & Facilities');?>
                            <!-- <span class="glyphicon glyphicon-menu-down" ></span> -->
                        </a>
                        <!-- <ul>
                            <li><a href="<?php //echo Yii::app()->params['link'].$lang?>/services/dining"><?php //echo Yii::t('lang', 'Dinings');?></a></li>
                            <li><a href="<?php //echo Yii::app()->params['link'].$lang?>/services/conferences"><?php //echo Yii::t('lang', 'Events & Conferences');?></a></li>
                            
                        </ul> -->
                    </li>
                    <!--<li><a href="<?php //echo Yii::app()->params['link'].$lang?>/services/spa"><?php //echo Yii::t('lang', 'Spa');?></a></li>-->
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/destination"><?php echo Yii::t('lang', 'Destination');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/contact"><?php echo Yii::t('lang', 'Contact');?></a></li>
                </ul>
            </div>
        </div>
    </div>
</article>
<article class="ar-header">
    <div class="topheader">
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <div class="header-left">
                    </div>  
                </div>
                <div class="col-xs-4">
                    <a class="logo" href="<?php echo Yii::app()->params['link']?>"><img src="<?php echo Yii::app()->baseUrl?>/images/Ambassador_group.png" alt="Ambassador Hotel"></a>    
                </div>
                <div class="col-xs-4">
                    <div class="topright dropdown">
                    <?php
                        $languages = array('vi' => 'Tiếng Việt','en' => 'English');
                        $html_language = '';
                        $html_active = '';
                        if(isset($languages[$lang])){
                            $html_active ='<img src="'. Yii::app()->baseUrl.'/images/'.$lang.'.jpg" alt="'.$languages[$lang].'">'.$languages[$lang];
                        }
                        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        foreach($languages as $lg => $lname){ 
                            if(!strpos($actual_link,'/'.$lang)){
                                $html_language .= '<li><a href="'.$actual_link.$lg.'"><img src="'. Yii::app()->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'">'.$lname.'</a></li>';
                            }else{
                                $html_language .= '<li><a href="'.str_replace('/'.$lang, '/'.$lg, $actual_link).'"><img src="'. Yii::app()->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'">'.$lname.'</a></li>';
                            }
                        }
                        ?>
                        <a href="" class="dropdown-toggle" id="dropdown-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php echo $html_active;?>
                        </a>
                        <ul class="dropdown-menu" id="dropdown-lg">
                            <?php echo $html_language;?>
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-navAmbassador">
        <div class="container">
            <div class="material-menu-button"><span></span><span></span><span></span></div>
            <div class="material-menu navAmbassador">
                <ul class="navbar-nav">
                    <li><a class="selected" href="<?php echo Yii::app()->params['link'].$lang?>"><?php echo Yii::t('lang', 'Home');?></a></li>
                    <li>
                        <a href="home.html">
                            <?php echo Yii::t('lang', 'Our hotels');?>
                            <span class="glyphicon glyphicon-menu-down" ></span>
                        </a>
                        <ul>
                           <?php
                            foreach($hotels->getData() as $hotel){
                                echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/'.$hotel->slug.'.html">'.$hotel->name.'</a></li>';    
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/about.html"><?php echo Yii::t('lang', 'About us');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/special-offers.html"><?php echo Yii::t('lang', 'Special Offers');?></a></li>
                    <li>
                        <a href="<?php echo Yii::app()->params['link'].$lang?>/services.html">
                            <?php echo Yii::t('lang', 'Services & Facilities');?>
                            <!-- <span class="glyphicon glyphicon-menu-down" ></span> -->
                        </a>
                    </li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/tours.html"><?php echo Yii::t('lang', 'Tours');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link'].$lang?>/contact.html"><?php echo Yii::t('lang', 'Contact');?></a></li>
                </ul>
            </div>
        </div>
    </div>
</article>
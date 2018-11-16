
<div class="header">	
	<div class="container">		
		<a class="logo" href="<?php echo Yii::app()->params['link']?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/logo.png"></a>
		<div class="language">
			Language:
			<?php
                $languages = array('en' => 'English','vi' => 'Tiếng Việt','ja' => '日本語', 'cn' => '简体中文');
                $html_language = '';
                $html_active = '';
                $lang = Yii::app()->session['_lang'];
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                foreach($languages as $lg => $lname){                                    
                    /*if($lang == $lg && strpos($actual_link,'/'.$lang)){
                        $html_active = '<a href="'.str_replace('/'.$lang, '/'.$lg, $actual_link).'">';
                        $html_active .= '<img src="'. Yii::app()->theme->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'">';
                        $html_active .= '</a>';
                    }else{*/
                        if(!strpos($actual_link,'/'.$lang)){
                            $html_language .= '<a href="'.$actual_link.$lg.'"><img src="'. Yii::app()->theme->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'"></a>';
                        }else{
                            $html_language .= '<a href="'.str_replace('/'.$lang, '/'.$lg, $actual_link).'"><img src="'. Yii::app()->theme->baseUrl.'/images/'.$lg.'.jpg" alt="'.$lname.'"></a>';
                        }
                    //}
                }
                echo $html_active.$html_language;
            ?>
		</div>
		<div class="Armenu">
			<div class="material-menu-button"><span></span><span></span><span></span></div>
			<div class="material-menu">	
				<ul id="navigate">
					<li><a href="<?php echo Yii::app()->params['link'].$lang?>/">Aristo</a></li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/gallery';?>"><?php echo Yii::t('lang', 'gallery');?></a></li>
                    <!-- <li><a href="<?php //echo Yii::app()->params['link'].$lang.'/promotion';?>"><?php //echo Yii::t('lang', 'promotion');?></a></li> -->
                    <li>
                        <a href="<?php echo Yii::app()->params['link']. $lang.'/rooms';?>"><?php echo Yii::t('lang', 'rooms');?></a>
                        <ul>
                            <?php
                                $rooms = Roomtype::model()->getList(0);
                                foreach($rooms->getData() as $room){
                                    echo '<li><a href="'.Yii::app()->params['link'].$lang.'/rooms/'.$room['slug'].'">'.$room['name'].'</a></li>';
                                }
                            ?>
                        </ul>
                    </li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/dining';?>"><?php echo Yii::t('lang', 'dining');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/conferences';?>"><?php echo Yii::t('lang', 'conference');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/spa';?>"><?php echo Yii::t('lang', 'A Spa');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/activities';?>"><?php echo Yii::t('lang', 'activities');?></a></li>
                    
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/destination';?>"><?php echo Yii::t('lang', 'destination');?></a></li>
                    <li><a href="<?php echo Yii::app()->params['link']. $lang.'/contact';?>"><?php echo Yii::t('lang', 'contact');?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
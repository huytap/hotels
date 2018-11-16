<?php
class SliderWidget extends CWidget{
	public function init(){
		$cms = 'home';
		if(isset($_GET['cms'])){
			$cms = $_GET['cms'];
		}elseif(isset($_GET['room'])){
			$cms = $_GET['room'];
		}elseif(isset($_GET['cms'])){
			$cms = 'galleryslide';
		}elseif(isset($_GET['spa'])){
			$cms = $_GET['spa'];
		}elseif(isset($_GET['special'])){
			$cms = $_GET['special'];
		}
		$sliders = Gallery::model()->getListbytype($cms);
		$this->render('slider', compact(array('sliders')));
	}
}
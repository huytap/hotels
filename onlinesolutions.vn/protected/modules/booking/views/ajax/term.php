<div class="ajax-rooms white-popup-block">
	<?php
		$condition = Yii::app()->params['condition'];
		echo $condition;
	?>
</div>
<style>
	.ajax-rooms {
		max-width:800px; margin: 20px auto; 
		background: #FFF; padding: 15px; line-height: 0;
		position: relative;
	}
	p{
	    line-height: 20px;
	}
	.ajax-rooms h2,
	.ajax-rooms h3{
		font-weight: bold;
		margin: 0 0 5px 0;
		font-size: 16px;
	}
	.ajax-rooms h3{
		font-size: 14px;
	}
	.ajax-rooms:before,
	.ajax-rooms:after,
	#pop-pager:before,
	#pop-pager:after{
		content:'';
		clear: both;
		display: block;
	}
	.ajcol-l {
		width: 60%; float:left;
	}
	.ajcol-r {
		width: 38%;
        float: right;
		padding: 10px;
		box-sizing: border-box;
		line-height: 18px;
		font-size: 13px;
	}
	.ajcol-r p {
		margin-bottom: 0;
	}
	#pop-pager img {
		width: 100%; height: auto;
	}
	#rooms-pop-slider li{
		padding: 5px;
		box-sizing: border-box;
		overflow: hidden;
	}
	#rooms-pop-slider img{
		width: 100%;
		height: auto;
	}
	.ajcol-r .des{
		margin-bottom: 15px;
	}
	#pop-pager a{
		width: 20%;
		float: left;
		padding: 5px;
		box-sizing: border-box;
	}
	.ajcol-r .amenity{
		margin: 0;
		padding: 0;
	}
	.ajcol-r .amenity li{
		float: left;
	    padding: 0 3px;
	    margin: 1px 0;
	}
	.ajcol-r .amenity li:nth-of-type(2n){
		background-color: #ddd;
	}

	    
	@media all and (max-width:640px) {
		.ajcol-r,
		.ajcol-l{ 
			width: 100%;
			float:none;
		}
	}
</style>
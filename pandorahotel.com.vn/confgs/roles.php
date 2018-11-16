<?php
return array(
	'booking' => array('admin','delete','view', 'showcard', 'report', 'cancel'),
	'hotel' => array('admin', 'create', 'update', 'delete'),
	'roomtype' => array('admin', 'create', 'update', 'delete', 'deletephoto'),
	'room' => array('admin'),
	'rate' => array('admin'),
	'promotion' => array('admin', 'create', 'update', 'delete'),
	'cms' => array('admin', 'create', 'update', 'delete'),
	'special' => array('admin', 'create', 'update', 'delete'),
	'gallery' => array('admin', 'create', 'upload', 'update_order', 'deleteItem', 'view', 'update', 'delete'),
	'gallerycategory' => array('admin','create','update', 'delete'),
	'slideshow' => array('admin', 'create', 'delete', 'update', 'updateItem', 'view', 'upload','deleteItem'),
	'settings' => array('admin','create','update', 'delete'),
	'user' => array('admin', 'create', 'update', 'delete'),
	'roles' => array('admin', 'create', 'update', 'delete'),
	'categoryspa' => array('admin', 'create', 'update', 'delete'),
	'itemspa' => array('admin', 'create', 'update', 'delete'),
);
?>
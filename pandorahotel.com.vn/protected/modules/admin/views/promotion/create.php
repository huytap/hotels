<?php
$this->breadcrumbs = array(
    'Promotions' => array('admin'),
    'Create new promotion'
);
$this->renderPartial('_form', compact(array('model', 'roomtype','Promotion')));
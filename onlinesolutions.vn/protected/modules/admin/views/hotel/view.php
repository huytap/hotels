<?php
/* @var $this HotelController */ 
/* @var $model Hotel */ 

$this->breadcrumbs=array( 
    'Hotels'=>array('index'), 
    $model->name, 
);

$this->menu=array( 
    array('label'=>'Update Hotel', 'url'=>array('update', 'hotelid'=>$model->hotel_id,'chainid' => $model->chain_id)), 
); 
?> 

<h1>Hotel Information</h1> 

<?php $this->widget('zii.widgets.CDetailView', array( 
    'data'=>$model, 
    'attributes'=>array( 
        'hotel_id',
        'chain_id',
        'name',
        array(
            'name' => 'logo1', 
            'type' => 'html',
            'header' => 'Logo',
            'value' => function($model){                
                if($model->logo1){  
                    return '<img width="150" src="'.Yii::app()->baseUrl.'/images/'.$model->logo1.'">';
                }return'';
            }
        ),
        /*array(
            'name' => 'logo2', 
            'type' => 'html',
            'value' => function($model){     
                if($model->logo2){           
                    return '<img width="150" src="'.Yii::app()->baseUrl.'/images/'.$model->logo2.'">';
                }
                return;
            }
        ),
        'display_order',
        'graded_star',*/
        'email_info',
        'email_sales',
        'hotline',
        'tel',
        'fax',
        'no_of_rooms',
        array(
            'name' => 'address', 
            'type' => 'html',
            'value' => function($model){
                $address = json_decode($model['address'], true);
                return $address['en'];
            }
        ),
        array(
            'name' => 'city', 
            'type' => 'html',
            'value' => function($model){
                $city = json_decode($model['city'], true);
                return $city['en'];
            }
        ),
        array(
            'name' => 'country', 
            'type' => 'html',
            'value' => function($model){
                $country = json_decode($model['country'], true);
                return $country['en'];
            }
        ),
        
        /*array(
            'name' => 'short_description', 
            'type' => 'html',
            'value' => function($model){
                $short_description = json_decode($model['short_description'], true);
                return $short_description['en'];
            }
        ),
        array(
            'name' => 'description', 
            'type' => 'html',
            'value' => function($model){
                $des = json_decode($model['description'], true);
                return $des['en'];
            }
        ),*/
        array(
            'name' => 'term_condition', 
            'type' => 'html',
            'value' => function($model){
                $term_condition = json_decode($model['term_condition'], true);
                return $term_condition['en'];
            }
        ),
        /*
        'facilities',
        'sports',
        'location',
        //'cover_photo',
        
        'lat',
        'lng',*/
        'website'        
    ), 
)); ?> 
<?php
class SlideshowController extends AdminController
{
    public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>RoleHelper::GetRole(),//array('create','update','admin'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin($type=1){
        $model=new Gallery('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Gallery'])){
            $model->attributes=$_GET['Gallery'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid_2', compact(array('model', 'type')));
            Yii::app()->end();
        }

        $this->render('admin',array(
            'model'=>$model,
            'type' => $type
        ));
    }

    public function actionCreate($type){
        $model = new Gallery();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            $model->hotel_id=Yii::app()->session['hotel'];
            ExtraHelper::update_tracking_data($model, 'create');
            $model->type = 1;
            $model->save();
            $gallery_id = $model->id;
            $image = CUploadedFile::getInstancesByName('items');
            if (isset($image) && count($image) > 0) {
                $i = 0;
                foreach ($image as $key => $value) {
                    $i++;
                    $gallery_item = new Item();
                    $gallery_item->display_order = $i;
                    $gallery_item->gallery_id = $gallery_id;
                    $gallery_item->file_ext = $value->type;
                    $gallery_item->old_name = $value->name;
                    $gallery_item->name = date("Y-m-d-H-i-s") . '-' . str_replace(' ', '', $value->name);
                    $gallery_item->url = Yii::app()->basePath . "/../uploads/slide/";
                    if ($i == 1) {
                        $gallery_item['thumb_nails'] = 1;
                        $gallery_item['cover_image'] = 1;
                    } else {
                        $gallery_item['thumb_nails'] = 0;
                        $gallery_item['cover_image'] = 0;
                    }

                    $gallery_item->save();
                    $value->saveAs(Yii::app()->basePath . "/../uploads/slide/$gallery_item->name");
                }
                //$this->redirect(Yii::app()->createAbsoluteUrl('admin/slideshow/admin'));
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/slideshow/view', array('id'=>$gallery_id)));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id){
        $model = Gallery::model()->findByPk($id);
        $type = $model['type'];
        if($model['hotel_id'] == Yii::app()->session['hotel']){
            if(isset($_POST['Gallery'])){
                $model->attributes = $_POST['Gallery'];
                $model->hotel_id = Yii::app()->session['hotel'];
                if($model->update()){
                    $this->redirect(Yii::app()->createUrl('admin/slideshow/admin/type/'.$type ));
                }
            }
            $this->render('update', compact('model'));
        }else{
            $this->render('../site/error');
        }
    }

    public function actionUpload($id){
        $gallery = Gallery::model()->with('items')->findByPk($id);
        if (isset($_POST['Gallery'])) {
            $image = CUploadedFile::getInstancesByName('items');
            $last = Item::model()->getLastItem($id);
            if (isset($image)) {
                $i = 0;
                foreach ($image as $key => $value) {
                    $i++;
                    $gallery_item = new Item();
                    $gallery_item->gallery_id = $id;
                    $gallery_item->file_ext = $value->type;
                    $gallery_item->old_name = $value->name;
                    $gallery_item->display_order = ++$last;
                    $gallery_item->name = date("Y-m-d-H-m-i") . '-' . str_replace(' ', '-',$value->name);
                    $gallery_item->url = Yii::app()->basePath . "/../uploads/slide/";
                    $gallery_item->save();
                    $value->saveAs(Yii::app()->basePath . "/../uploads/slide/$gallery_item->name");
                }
            }
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/slideshow/view', array('id'=>$id)));
        }
        $this->render('upload', array('model' => $gallery));
    }

    public function actionUpdateItem(){
        $this->layout=false;
        if (isset($_POST['id'])) {
            $model = $this->loadItemModel($_POST['id']);
            //$model->description = $_POST['description'];

            $languages = Yii::app()->params['language_config'];
            $title = $description = array();
            foreach($languages as $key => $lang){
                if(isset($_POST['des_'.$key]) && !$_POST['des_'.$key]){
                    $description[$key]=$_POST['des_en'];
                }else{
                    $description[$key]=$_POST['des_'.$key];
                }

                if(isset($_POST['title_'.$key]) && !$_POST['title_'.$key]){
                    $title[$key]=$_POST['title_en'];
                }else{
                    $title[$key]=$_POST['title_'.$key];
                }
            }
            
            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            //$model->hotel_id = Yii::app()->session['hotel'];
            if($model->update()){
                echo json_encode(1);
            }else{
                echo json_encode(0);
            }
        }
    }

    public function actionView($id){
        $gallery=Gallery::model()->findByPk($id);
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Item'])){
            $model->attributes=$_GET['Item'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('view', compact(array('model', 'gallery')));
    }

    public function loadItemModel($id){
        $item=Item::model()->findByPk($id);
        return $item;
    }

    public function actionDelete($id){
        $items = Item::model()->getListByGallery($id);
        if ($items) {
            foreach ($items->getData() as $key => $value) {
                $file_image = Yii::app()->basePath . "/../uploads/slide/" . $value->name;
                if (file_exists($file_image)) {
                    unlink($file_image);
                }
                $value->delete();
            }
        }

        $gallery = Gallery::model()->findByPk($id);
        if ($gallery->delete()){
            echo json_encode(1);
        }
    }

    public function actionDeleteItem(){
        if(isset($_POST['id'])){
            $item = $this->loadItemModel($_POST['id']);
            $file_image = Yii::app()->basePath . "/../uploads/slide/" . $item->name;
            if ($item->delete()){
                if (file_exists($file_image)) {
                    unlink($file_image);
                }
                echo json_encode(1);
            }
        }
    }
}

?>
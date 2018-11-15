<?php
class GalleryController extends AdminController
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

    public function actionAdmin(){
        /*$data = Gallery::model()->getGalleryByType(0, Yii::app()->session['hotel']);

        $this->render('index',array(
            'model'=>$data,
        ));*/

        $model=new Gallery('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Gallery'])){
            $model->attributes=$_GET['Gallery'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid_2', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionCreate(){
        $model = new Gallery();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            //$check = Gallery::model()->getListbyTopSliderRoomdetails($model['name'], $model['hotel_id'], $model['roomtype_id']);

            $model->type = 0;
            //$model->hotel_id=Yii::app()->session['hotel'];
            //$cate = GalleryCategories::model()->getIDByUrl($model->name);
            //$model->gallery_categories = $cate['id'];
            $model->gallery_categories = $_POST['Gallery']['name'];
            ExtraHelper::update_tracking_data($model, 'create');
            $model->save();
            $gallery_id = $model->id;
            $image = CUploadedFile::getInstancesByName('items');
            if (isset($image) && count($image) > 1) {
                $i = 0;
                foreach ($image as $key => $value) {
                    $i++;
                    $gallery_item = new Item();
                    $gallery_item->display_order = $i;
                    $gallery_item->gallery_id = $gallery_id;
                    $gallery_item->file_ext = $value->type;
                    $gallery_item->old_name = $value->name;
                    $gallery_item->name = date("Y-m-d-H-i-s") . '-'.ExtraHelper::changeTitle(str_replace(array('.gif','.jpg','.png'),'',$value->name));
                    $gallery_item->url = Yii::app()->basePath . "/../uploads/gallery/";
                    if ($i == 1) {
                        $gallery_item['thumb_nails'] = 1;
                        $gallery_item['cover_image'] = 1;
                    } else {
                        $gallery_item['thumb_nails'] = 0;
                        $gallery_item['cover_image'] = 0;
                    }

                    $gallery_item->save();
                    $value->saveAs(Yii::app()->basePath . "/../uploads/gallery/$gallery_item->name");
                }
            }
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/gallery/admin'));
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id){
        $model = Gallery::model()->findByPk($id);
        $model->gallery_categories = $_POST['Gallery']['name'];
        /*if(Users::checkPermissionHotel($model->hotel_id)==FALSE){
            throw new CHttpException(404,'404 Page Not Found OR You have not permision.');
        }else{*/
            //if($model['hotel_id'] == Yii::app()->session['hotel']){
                if(isset($_POST['Gallery'])){
                    $model->attributes = $_POST['Gallery'];
                    $model->hotel_id = Yii::app()->session['hotel'];
                    if($model->update()){
                        $this->redirect(Yii::app()->createUrl('admin/gallery/admin'));
                    }
                }
                $this->render('update', compact('model'));
            /*}else{
                $this->render('../site/error');
            }*/
        //}
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
                    $gallery_item->name = date("Y-m-d-H-i-s") . '-'.ExtraHelper::changeTitle(str_replace(array('.gif','.jpg','.png'),'',$value->name));
                    $gallery_item->url = Yii::app()->basePath . "/../uploads/gallery/";
                    $gallery_item->save();
                    $value->saveAs(Yii::app()->basePath . "/../uploads/gallery/$gallery_item->name");
                }
            }
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/gallery/admin'));
        }
        $this->render('upload', array('model' => $gallery));
    }

    public function loadItemModel($id){
        $item=Item::model()->findByPk($id);
        return $item;
    }
    public function actionDeleteItem(){
        if(isset($_POST['id'])){
            $item = $this->loadItemModel($_POST['id']);
            $file_image = Yii::app()->basePath . "/../uploads/gallery/" . $item->name;
            if ($item->delete()){
                if (file_exists($file_image)) {
                    unlink($file_image);
                }
                echo json_encode(1);
            }
        }
    }

    public function actionView($id){
        $gallery=Gallery::model()->findByPk($id);
        /*if(Users::checkPermissionHotel($gallery->hotel_id)==FALSE){
            throw new CHttpException(404,'404 Page Not Found OR You have not permision.');
        }else{*/
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
        //}
    }

    public function actionDelete($id){
        $items = Item::model()->getListByGallery($id);
        
        if ($items && count($items->getData())>0) {
            foreach ($items->getData() as $key => $value) {
                $file_image = Yii::app()->basePath . "/../uploads/gallery/" . $value->name;
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
}

?>
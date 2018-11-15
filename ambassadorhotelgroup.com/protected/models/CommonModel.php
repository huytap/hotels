<?php 
	class CommonModel extends CActiveRecord
	{
		public function remove_vietnamese_accents($str){
            $accents_arr = array(
                "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
                "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "�?",
                "ế", "ệ", "ể", "ễ",
                "ì", "í", "ị", "ỉ", "ĩ",
                "ò", "ó", "�?", "�?", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ",
                "�?", "ớ", "ợ", "ở", "ỡ",
                "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
                "ỳ", "ý", "ỵ", "ỷ", "ỹ",
                "đ",
                "À", "�?", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă",
                "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
                "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
                "Ì", "�?", "Ị", "Ỉ", "Ĩ",
                "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "�?", "Ộ", "Ổ", "Ỗ", "Ơ",
                "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
                "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
                "Ỳ", "�?", "Ỵ", "Ỷ", "Ỹ",
                "�?"
            );

            $no_accents_arr = array(
                "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
                "a", "a", "a", "a", "a", "a",
                "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
                "i", "i", "i", "i", "i",
                "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
                "o", "o", "o", "o", "o",
                "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
                "y", "y", "y", "y", "y",
                "d",
                "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
                "A", "A", "A", "A", "A",
                "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
                "I", "I", "I", "I", "I",
                "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
                "O", "O", "O", "O", "O",
                "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
                "Y", "Y", "Y", "Y", "Y",
                "D"
            );

            return str_replace($accents_arr, $no_accents_arr, $str);
        }
        /**
         * Upload, rename and save image
         */
        public static function saveImage($model, $objFile, $path){
            $imgProcessing = new ImageProcessing();
            $imgProcessing->createDirectory($path);
            $imgProcessing->folder = $path;
            $objFile->saveAs(Yii::app()->basePath . "/..$path/$model->fileImage");
            return $model->fileImage;
        }

        /**
         * Delete File
         */
        public static function DeleteFile($file_name, $path) {
            $ImageProcessing = new ImageProcessing();
            $ImageProcessing->folder = $path;
            if ($file_name != null) {
                $ImageProcessing->deleteFile(Yii::app()->baseUrl . '/' . $ImageProcessing->folder . '/' . $file_name);
            }
            return true;
        }
	}
?>
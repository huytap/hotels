<?php
class ReportHelper{

	public static function dataBooking($filter_data) {

		$dataProvider = Bookings::model()->getList($filter_data);
		
		$arrTheList = array();
		$arrTheList = $dataProvider->getData();
		$nCount = 0;
		if(is_array($arrTheList)){
			foreach($arrTheList as $k => $v){
				//$checkin = ExtraHelper::date_2_show($v->request_date);
				$usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
				$nCount ++;
				$tmp = array();
				$tmp[] = $nCount;
				$tmp[] = ExtraHelper::date_2_show($v->request_date);
	            $tmp[] = $v['hotel']['name'];
	            $tmp[] = $v->short_id;
	            $tmp[] = $v->first_name;
	            $tmp[] = $v->last_name;
	            $tmp[] = $v->email;
	            $tmp[] = $v->country;
	            $country_name='';
	            if($v->ip_address){
	            	$geo_ip = geoip_record_by_name($v->ip_address);
	            	if($geo_ip)
	            	$country_name = $geo_ip['country_name'];
	            }
	            $tmp[] = $country_name;
	            $tmp[] = ExtraHelper::date_2_show($v->checkin);
	            $tmp[] = ExtraHelper::date_2_show($v->checkout);
	            $tmp[] = $v->booked_nights;
	            $tmp[] = $v['roomtype']['name'];
	            $pr = json_decode($v['promotion']['name'], true);
	            $tmp[] = $pr['en'];
	            $tmp[] = number_format($v->pickup_price/$usd_to_VND['sell'], 2);
	            $tmp[] = number_format($v->dropoff_price/$usd_to_VND['sell'], 2);

                $total = ($v['rate_vnd']*$v['no_of_room']+$v['no_of_extrabed']*$v['extrabed_price'])*$v['booked_nights']+$v['pickup_price']+$v['dropoff_price'];
                $packages = BookPackage::model()->getList($v['id']);
                $sum_packages = count($packages->getData());
                if($sum_packages>0){
                    foreach($packages->getData() as $pkey => $pk){
                        $total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$pk->exchange_rate*$v['booked_nights'];
                        $total += $total_p;
                    }                    
                }
                
                

	            $tmp[] = number_format($total/$usd_to_VND['sell'], 2);
	            $tmp[] = $v->status;
                $arr[] = $tmp;
			}
		}
		return $arr;
	}

	public static function cell_name($row, $col) {
		$chr_ord = ord('A');
		return chr($chr_ord + $col) . $row;
	}
	
	public static function doExport($arrReport, $data, $arrCells=array(), $formated = FALSE, $array_bold = FALSE) {
       $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
      /** PHPExcel_IOFactory */
      require_once $phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php';
       // Create new PHPExcel object
      $objReader = PHPExcel_IOFactory::createReader('Excel5');
      $objPHPExcel = $objReader->load("template/" . $arrReport['template']);
   
       // Set properties
       $objPHPExcel->getProperties()->setCreator("Contact Software")
      ->setLastModifiedBy("Contact Software")
      ->setTitle("Contact Software Report")
      ->setSubject("Contact Software Report")
      ->setDescription("Contact Software Report")
      ->setKeywords("Contact Software Report")
      ->setCategory("Contact Software Report");
	  
	  foreach ($arrCells as $key => $val) {
		$objPHPExcel->getActiveSheet()->setCellValue($key, $val);
	  }
	  //PHPExcel_Shared_Date::PHPToExcel(time())
 		$arr_colors = array();
		if (isset($arrReport['colors'])) {
			$arr_colors = $arrReport['colors'];
		}
		$b_bgcolor_change = FALSE;
		$bgcolor = $current_row_data = "";
		$bgcolor_index = -1;
		$arr_bgcolors = array();
		$bgcolors_spacer = '';
		if (isset($arrReport['bgcolors'])) {
			$b_bgcolor_change = TRUE;
			$arr_bgcolors = $arrReport['bgcolors'];
			if (isset($arrReport['bgcolors_spacer'])) {
				$bgcolors_spacer = $arrReport['bgcolors_spacer'];
			}
		}
		
        $baseRow = $arrReport['baserow'];
		$row = $baseRow;
        $spacer_row_number = 0;
        $array_pick = array();
		$date_pick_current = '';
		$b_new_date = FALSE;
		$bgcolor = '';
		//echo"<pre>";print_r($arrReport['price']);die;
		foreach($data as $r => $dataRow) {
			
          	if(isset($arrReport['flag_date_pick'])) {
				if ($date_pick_current!=$dataRow[0]) {
					$b_new_date = TRUE;
					$array_pick = array();
					$array_pick[] = $dataRow[0];
					$date_pick_current = $dataRow[0];
				} else {
					$b_new_date = FALSE;
				}
			}
			$bg_row = '';
			if(isset($dataRow['bg_row'])) {
				$bg_row = $dataRow['bg_row'];
				$bg_row = str_replace('#', '', $bg_row);
				unset($dataRow['bg_row']);
			}else{
				$bg_row = '';
			}
			$column_number = count($dataRow);
			$row = $baseRow + $r + $spacer_row_number;
			if ($b_bgcolor_change) {

				if ($dataRow[$arr_bgcolors['col_index']]!=$current_row_data) { /* change bg color */
					// insert empty row if not first time
					if ($current_row_data) {
						$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1);
						
						if (isset($arrReport['set_row_height'])) {
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($arrReport['set_row_height']);
						} else {
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
						}
						
						if ($bgcolors_spacer) {
							$column_count = 0;
							for ($tmpIdx=0; $tmpIdx<$column_number; ++$tmpIdx) {
								$cell_name = ReportHelper::cell_name($row, $column_count);
								$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFill()
									->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $bgcolors_spacer)));
								$column_count ++;
							}
						}
						$spacer_row_number ++;
					}
					// change the color
					$current_row_data = $dataRow[$arr_bgcolors['col_index']];
					$bgcolor_index = ($bgcolor_index + 1)%(count($arr_bgcolors['bgcolors']));
					$bgcolor = $arr_bgcolors['bgcolors'][$bgcolor_index];
					
				}
				if (isset($arrReport['set_row_height'])) {
					$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
				}
			}
			
			$row = $baseRow + $r + $spacer_row_number;

          	if ($r<count($data)-2) {
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1);
			}
			//echo"<pre>";print_r($arrReport['total_row']);die;
			if(isset($arrReport['total_row']) && $arrReport['total_row'] > 1){
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,(int)$arrReport['total_row']-1);
			}
			if (isset($arrReport['set_row_height'])) {
				$objPHPExcel->getActiveSheet()->getRowDimension($row+1)->setRowHeight($arrReport['set_row_height']);
			} else {
				$objPHPExcel->getActiveSheet()->getRowDimension($row+1)->setRowHeight(-1);
			}
			$column_count = 0;

			//check condition bold
			$flag_bold = false;
			$new_date = false;
			$row_pick = 0;
			$bg_pick = false;
			$total_price = 0;

			foreach ($dataRow as $k => $val) {
				$cell_name = ReportHelper::cell_name($row, $column_count);
				
				if(is_array($val)){

					if(count($val)>0){

						$kk=0;
						$count_val = count($val);
						
						foreach($val as $vv){
							$row = $baseRow + $r + $spacer_row_number;
							$cell_name = ReportHelper::cell_name($row+$kk, $column_count);
							//$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
							$objPHPExcel->getActiveSheet()->setCellValue($cell_name, $vv);
							$val = $vv;
							$kk++;
						}

						if($kk == $count_val && isset($arrReport['price'])){

							$cell_name = ReportHelper::cell_name($row+$arrReport['total_row'], $column_count);
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
							$objPHPExcel->getActiveSheet()->setCellValue($cell_name, 'Total: ' . $count_val);
							//$objPHPExcel->getActiveSheet()->setCellValue($cell_name, 'Price: ' . $count_val);
						}
						if(($kk+1) > $count_val && isset($arrReport['price']) && (int)$arrReport['price'][0][$column_count+1] > 0){
							$cell_name = ReportHelper::cell_name(($row+$arrReport['total_row']+1), $column_count);
							$total_price += $arrReport['price'][0][$column_count+1];
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
							$objPHPExcel->getActiveSheet()->setCellValue($cell_name, 'Price: ' . ExtraHelper::price_2_show($arrReport['price'][0][$column_count+1],"VND"));
						}
						
					}else{
						$val = '';
						//$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getRowDimension($row + $column_count)->setRowHeight(-1);
						$objPHPExcel->getActiveSheet()->setCellValue($cell_name, $val);
						
					}
				}

				$column_count ++;
				$val = str_ireplace("<br/>", "\r\n", $val);
				$val = str_ireplace("<br>", "\r\n", $val);

				$link = '';
				$pos1 = strpos($val, "href='");

				if ($pos1!==FALSE) {
					$pos1 += strlen("href='");
					$pos2 = strpos($val, "'", $pos1);
					if ($pos2!==FALSE) {
						$link = substr($val, $pos1, $pos2-$pos1);
					}
				}
				if ($link) {
					$val = strip_tags($val);
				}
				
				$photo = '';
				$check_link = strpos($val, "media");
				if($check_link !== FALSE){
					$photo = $val;
				}
				
				// $cell_name = ReportHelper::cell_name($row, $column_count);
				// $column_count ++;
				// if(is_array($val)){
				// 	$val = 'a';
				// 	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1);
				// 	$styleArray = array(
				//         'borders' => array(
				//         'top' => array(
				//         'style' => PHPExcel_Style_Border::BORDER_DASHED
				//     )));
				// 	$objPHPExcel->getActiveSheet()->getStyle($cell_name)->applyFromArray($styleArray);
				// }
				
				//formated
				if($formated !==FALSE && $val == $formated){
					$flag_bold = true;										
				}

				if($flag_bold && $column_count >= count($dataRow) && $array_bold !== FALSE){
					//$array_cell_bold = [1,2,3,9];					
					for($i=0;$i<count($array_bold);$i++){
						$cell_name_ = ReportHelper::cell_name($row, $array_bold[$i]);
						$objPHPExcel->getActiveSheet()->getStyle("$cell_name_:$cell_name_")->getFont()->setBold(true);
					}
				}
				//end formated
				if($photo){
					if(file_exists(Yii::app()->basePath.DIRECTORY_SEPARATOR.'/../'.$photo)){
						//set picture
						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setPath(Yii::app()->basePath.DIRECTORY_SEPARATOR.'/../'.$photo);
						$objDrawing->setHeight(60);
						$objDrawing->setWidth(50);
						$objDrawing->setCoordinates($cell_name);
						$objDrawing->setOffsetX(8);
						$objDrawing->setOffsetY(2);
						$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
						
					}					
				}elseif(!isset($arrReport['total_row'])){
					//$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getAlignment()->setWrapText(true);
					/* if (isset($arrReport['set_row_height'])) {
						$objPHPExcel->getActiveSheet()->getRowDimension($row + $column_count)->setRowHeight($arrReport['set_row_height']);
					} else {
						$objPHPExcel->getActiveSheet()->getRowDimension($row + $column_count)->setRowHeight(-1);
					} */
					$objPHPExcel->getActiveSheet()->setCellValue($cell_name, $val);
				}

				if (isset($arr_colors[$val])) {
					$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => $arr_colors[$val]),
						));
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->applyFromArray($styleArray);	
				}
				if ($bgcolor) {
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $bgcolor)));
				}
				//set bg color
				if ($bg_row) {
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $bg_row)));
				}
				if ($link) {
					$objPHPExcel->getActiveSheet()->getCell($cell_name)->getHyperlink()->setUrl($link);
					$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => '0000FF'),
							'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
						));
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->applyFromArray($styleArray);
				}
				//check new date
								
				if(isset($arrReport['flag_date_pick']) && ($k == 0)) {
					
					if ($b_new_date) {
						$row_pick = $r;	
						$array_pick[] = $val;
						$new_date = true;
						$objPHPExcel->getActiveSheet()->setCellValue($cell_name, $val);
					}else{		
						$new_date = false;
						$objPHPExcel->getActiveSheet()->setCellValue($cell_name, '');
					}
				}	
				//set width
				$arrCel = array(2=>'C',6=>'G'/* ,,11=>'L',16=>'Q',17=>'R' */);	
				if(isset($arrReport['setWidth']) && $arrReport['setWidth']!==false && ($k == 2/* || $k ==6 || $k==11 || $k==16 || $k==17 */)){
					$width = (int)(strlen($val)*90/100);
					if($width > $objPHPExcel->getActiveSheet()->getColumnDimension($arrCel[$k])->getWidth()){
						$objPHPExcel->getActiveSheet()->getColumnDimension($arrCel[$k])->setWidth($width);
					}				
				}
				if(isset($arrReport['setWidth']) && isset($arrReport['column']) && $k == $arrReport['column'] && strlen($val) >0){
					$width = (int)strlen($val)+((int)strlen($val)/2);
					
					if($width > $objPHPExcel->getActiveSheet()->getColumnDimension($arrCel[$k])->getWidth()){
						$objPHPExcel->getActiveSheet()->getColumnDimension($arrCel[$k])->setWidth($width);

					}				
				}
				$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getAlignment()->setWrapText(true);
				
				//set border
				if(isset($arrReport['flag_date_pick'])){
					
					if ($row_pick == $r) {
						$styleArray = array(
							'borders' => array(
							'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN, 
						)));
					} else {
						$border_style_value = PHPExcel_Style_Border::BORDER_HAIR;
						if ($column_count<=1) {
							$border_style_value = PHPExcel_Style_Border::BORDER_NONE;
						}
						$styleArray = array(
							'borders' => array(
							'top' => array(
							'style' => $border_style_value, 'color' => array('rgb' => '999999')
						)));
					} 
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->applyFromArray($styleArray);
					
				}					
				if(isset($arrReport['flag_date_pick']) && $dataRow[8] !== ''){
					$bg_pick = TRUE;
				} else {
					$bg_pick = FALSE;
				}
				if (!$bg_row && $bg_pick) {
					$objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'ffd674')));
				}
				//var_dump($row+$arrReport['total_row']+2);die;
				if((int)$total_price > 0){
					// $cell_name = ReportHelper::cell_name(($row+$arrReport['total_row']+2), $column_count);
					
					// $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
					// $objPHPExcel->getActiveSheet()->setCellValue($cell_name, 'Price Total: ' . ExtraHelper::price_2_show($total_price,"VND"));
					$objPHPExcel->getActiveSheet()->setCellValue('A' . ($row+$arrReport['total_row']+3), 'Week Total: '.ExtraHelper::price_2_show($total_price,"VND"));
				}

			}
		}
		$filename = $arrReport['filename'];

		
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        Yii::app()->end();
   
         // Once we have finished using the library, give back the 
         // power to Yii... 
         spl_autoload_register(array('YiiBase','autoload'));	
	}
}?>
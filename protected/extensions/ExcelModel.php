<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 14-5-30
 * Time: 上午11:06
 */

class ExcelModel {
    /**
     * Excel下载
     * param1  title：导出文件标题
     * param2  dataInfo包括：data导出的Excel数据列表，topCol导出的Excel表头，error错误标识；
     */
    public static function outExcel($title= null ,$dataInfo = null){
        if(empty($dataInfo)){
            exit("数据为空！");
        }
        if($dataInfo['error'] != 0){
            exit("数据查询出问题了！");
        }
        $data = $dataInfo['data'];
        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        //行标识
        $row = 1;
        //报表头的输出
        $objectPHPExcel->getActiveSheet()->mergeCells('B1:G1');
        $objectPHPExcel->getActiveSheet()->setCellValue('B1',$title);

        $row = $row +1;

        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2',$title);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2',$title);
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','日期：'.date("Y年m月j日"));
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle('G2')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $row = $row +1;

        //表格头的输出
        $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        if(!empty($dataInfo['topCol'])){
            //列标识
            $col = 1;
            foreach($dataInfo['topCol'] as $v){
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col,$row,$v);
                $objectPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(15);

                //设置居中
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //设置边框
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                //设置颜色
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');
                $col = $col + 1;
            }
            $row = $row + 1;
        }
       
        foreach ($data as $product ){
            //列标识
            $col = 1;
            //明细的输出
            foreach($product as $v){
                if(preg_match("/^([+-]?)\d*\.?\d+$/", $v)){
                    $objectPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,$v,PHPExcel_Cell_DataType::TYPE_STRING);
                }else{
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col,$row,$v);
                }
                //设置居中
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //设置边框
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)
                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                $col = $col + 1;
            }
            $row = $row +1;
        }

        $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        ob_end_clean();
        ob_start();
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$title.'-'.date("Y年m月j日").'.xls"');
        $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
    /**
     * 读取Excel内容
     * param1  $file：文件名
     * return  array
     */
    public static function ReaderExcel($file){
    	$PHPExcel = new PHPExcel();
    	$PHPReader = new PHPExcel_Reader_Excel2007();
    	if(!$PHPReader->canRead($file)){
    		$PHPReader = new PHPExcel_Reader_Excel5();
    		if(!$PHPReader->canRead($file)){
    			return false;
    		}
    	}
    	$PHPExcel = $PHPReader->load($file);
    	$currentSheet = $PHPExcel->getSheet(0);//读取第一个工作表
    	$allColumn = $currentSheet->getHighestColumn();//取得最大的列号
    	$allRow = $currentSheet->getHighestRow();//取得一共有多少行
    	/**从第二行开始输出，因为excel表中第一行为列名*/
    	$arr=array();
    	for($currentRow = 1;$currentRow <= $allRow;$currentRow++){
    		/**从第A列开始输出*/
    		for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
    			$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
    			/**如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出*/
    			//$arr[$currentRow][]=  iconv('utf-8','gb2312', $val)."\t";
    			$arr[$currentRow][]=  trim($val);
    		}
    	}
    
    	//删除全部为空的行
    	foreach ($arr as $key=>$vals){
    		$tmp = '';
    		foreach($vals as $v){
    			$tmp .= $v;
    		}
    		if(!$tmp) unset($arr[$key]);
    	}
    	return $arr;
    }
} 
<?php

/**
 * PHPExcel使用
 */
class Excel
{
	/*
	 * 四个私有属性
	 */
	private $model;//一个使用D或者M方法实例化的一个实例
	private $strSize = 1048576 * 10; //每次写入的一个阈值1048576 * 8
	private $fileType = array('csv', 'xls', 'xlsx', 'pdf');
	private $exFeild = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

	/*
	 * 构造函数 获取函数值 ，并将值赋予函数
	 */
	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		return $this->$name;
	}

//文件类型只支持 csv，xls，xlsx,pdf
	public function __construct($model, $fileType)
	{
		$this->model = $model;
		if (in_array($fileType, $this->fileType)) {
			$this->fileType = $fileType;
		}
		else {
			throw new \Think\Exception('文件类型错误');
		}
	}

	private function getObjWriter(\PHPExcel &$objPHPExcel, &$objWriter){
		if ($this->fileType === 'xlsx') {
// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="01simple.xlsx"');
			header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		}
		else if ($this->fileType === 'xls') {
//Redirect output to a client’s web browser (Excel5)--
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="01simple.xls"');
			header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		}
		else if ($this->fileType === 'pdf') {
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
			$objWriter->setFont('arialunicid0-chinese-simplified'); //这个很重要, 要不中文全是??
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="01simple.pdf"');
			header('Cache-Control: max-age=0');
		}
		else if ($this->fileType === 'csv') {
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="01simple.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		}
	}

	public function getXlsx($start = null, $num = null)
	{
		$objPHPExcel = new \PHPExcel();
		$objWriter = null;
		$this->getObjWriter($objPHPExcel, $objWriter);

//先处理参数
		if (empty($start)) {
			$start = 0;
		}
		if (empty($num)) {
			$num = $this->model->count() - $start;
		}
//获取表名 $this->model->getTableName()
		$oneData = $this->model->find();
		$DbFields = $this->model->getDbFields();
		$dataStr = implode(',', $oneData);
		$maxSize = floor($this->strSize / strlen($dataStr));

		$objPHPExcel->getActiveSheet()->settitle('Simple');
		$objPHPExcel->setActiveSheetIndex(0);


		$objWriter->save(str_replace('.php', '.' . $this->fileType, __FILE__));
		if ($num < $maxSize) {
			$data = $this->model->field('*')->limit($start, $num)->select();
			foreach ($data as $key => $value) {
				$i = $key + 1; //表格是从1开始的
				foreach ($DbFields as $k => $v) {
//echo $this->exFeild[$k] . $i.'<br>';
					$objPHPExcel->getActiveSheet()->setCellValue($this->exFeild[$k] . $i, $value[$v]); //这里是设置A1单元格的内容
				}
			}
			$objWriter->save(str_replace('.php', '.' . $this->fileType, __FILE__));
		}
		else {
			$forCount = ceil($num / $maxSize);
			$j = 0;
			for ($i = 0; $i < $forCount; $i++) {
				if ($i + 1 == $forCount) {
					$data = $this->model->field('*')->limit($start, $num % $maxSize)->select();
				}
				else {
					$data = $this->model->field('*')->limit($start, $maxSize)->select();
				}

				$start += $maxSize;
				foreach ($data as $key => $value) {
					$j++; //表格是从1开始的
					foreach ($DbFields as $k => $v) {
//echo $this->exFeild[$k] . $j.'<br>';
						$objPHPExcel->getActiveSheet()->setCellValue($this->exFeild[$k] . $j, $value[$v]); //这里是设置A1单元格的内容
					}
				}
				$objWriter->save(str_replace('.php', '.' . $this->fileType, __FILE__));
// $objWriter->save(str_replace('.php', '.xls', __FILE__));
			}
		}
//exit;
		$objWriter->save('php://output');
	}

	/**
	 * 导出excel(csv)
	 * @data 导出数据
	 * @headlist 第一行,列名
	 * @fileName 输出Excel文件名
	 */
	public function csv_export($start = null, $num = null)
	{

//先处理参数
		if (empty($start)) {
			$start = 0;
		}
		if (empty($num)) {
			$num = $this->model->count() - $start;
		}
//获取表名 $this->model->getTableName()
		$oneData = $this->model->find();
		$DbFields = $this->model->getDbFields();
		$dataStr = implode(',', $oneData);
		$maxSize = floor($this->strSize / strlen($dataStr));

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . 'abcd' . '.csv"');
		header('Cache-Control: max-age=0');

//打开PHP文件句柄,php://output 表示直接输出到浏览器
		$fp = fopen('php://output', 'a');

//输出Excel列名信息
		foreach ($DbFields as $key => $value) {
//CSV的Excel支持GBK编码，一定要转换，否则乱码
			$headlist[$key] = iconv('utf-8', 'gbk', $value);
		}

//将数据通过fputcsv写到文件句柄
//fputcsv($fp, $headlist);

		if ($num < $maxSize) {
			$data = $this->model->field('*')->limit($start, $num)->select();
			foreach ($data as $key => $value) {
				foreach ($value as $k => $v) {
					$value[$k] = iconv('utf-8', 'gbk', $v);
				}
				fputcsv($fp, $value);
			}
		}
		else {
			$forCount = ceil($num / $maxSize);
			$j = 0;
			for ($i = 0; $i < $forCount; $i++) {
				if ($i + 1 == $forCount) {
					$data = $this->model->field('*')->limit($start, $num % $maxSize)->select();
				}
				else {
					$data = $this->model->field('*')->limit($start, $maxSize)->select();
				}

				$start += $maxSize;
				foreach ($data as $key => $value) {
					$j++; //表格是从1开始的
					foreach ($value as $k => $v) {
						$value[$k] = iconv('utf-8', 'gbk', $v);
					}
					fputcsv($fp, $value);
				}
				ob_flush();
				flush();
			}
		}

//计数器
// $num = 0;
//每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
// $limit = 100000;
//逐行取出数据，不浪费内存
// $count = count($data);
// for ($i = 0; $i < $count; $i++) {
//
// $num++;
//
// //刷新一下输出buffer，防止由于数据过多造成问题
// if ($limit == $num) {
// ob_flush();
// flush();
// $num = 0;
// }
//
// $row = $data[$i];
// foreach ($row as $key => $value) {
// $row[$key] = iconv('utf-8', 'gbk', $value);
// }
//
// fputcsv($fp, $row);
// }
	}

	public function getPDF()
	{
// create new PDF document
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->Settitle('TCPDF Example 001');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_title.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set default font subsetting mode
		$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

// set text shadow effect
		$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
		$html = <<<EOD

EOD;

// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
		$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
	}

}

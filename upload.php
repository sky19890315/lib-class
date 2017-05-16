<?php

require_once 'conf/config.php';
/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/lib/PHPExcel/Classes/PHPExcel/IOFactory.php';


if ((isset($_FILES)) && ($_FILES["file"]["size"] < 20000))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		if (file_exists("./" . $_FILES["file"]["name"]))
		{
			echo $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],
				"./" . $_FILES["file"]["name"]);
			echo $_FILES["file"]["name"]."上传成功，该文件保存在服务器";
		}

	}
}
else
{
	echo "文件类型不正确";
	return false;
}

/*
 * 以下部分为文件处理部分
 */

$fileName = $_FILES["file"]["name"];

if (!file_exists("$fileName")) {
	exit("无法找到文件，请核实" . EOL);
}

$objPHPExcel = PHPExcel_IOFactory::load("$fileName");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save("new$fileName", __FILE__);




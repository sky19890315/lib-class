<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/5/22
 * Time: 上午12:38
 */

/**
 * @param null $var 需要传入的值
 * @param bool $dump 默认打印
 * @param bool $exit 默认退出程序
 */
function debug($var = null,$dump = true, $exit = true)
{
	if ($var === null){
		echo "必要参数不能为空";
		if ($exit){
			exit;
		}
	}else {

		if (is_array($var)) {
			echo "程序输出结果为：";
			?>
		<div style="background-color:darkkhaki;width: 400px;height: 120px" >


<?php
			print_r($var);
			?>

		</div>

<?php
			if ($exit) {
				echo "程序已退出";
				exit;
			}
		} else {

			if ($dump) {
				echo "输出结果为：";
				?>
				<div style="background-color:darkkhaki;width: 400px;height: 120px" >

<?php
				var_dump($var);
				?>

				</div>

				<?php
				echo "输出结束！";
			}
			if ($exit) {
				echo "程序退出";
				exit;
			}

		}
	}
}
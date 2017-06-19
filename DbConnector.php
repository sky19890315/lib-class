<?php
/**
 * Created by PhpStorm.
 * User: s
 * Date: 17-1-16
 * Time: 下午8:59
 */

/*
 * php常规设置
 */
define('DEBUG',true);
if (DEBUG){
	ini_set('error_reporting',E_ALL && ~E_NOTICE);
}

/**
 * Class DbConnector
 */
class DbConnector{
        var $pdo = null;

	/**
	 * 单例模式
	 * @return DbConnector|null
	 */
    public  static function getInstance(){
        static $obj = null;
        if ($obj == null){
            $obj = new DbConnector();
        }
        return $obj;
    }

	/**
	 * DbConnector constructor.
	 */
    function __construct(){
        //获得配置文件
        $settings = include 'conf/dbsetting.php';
        //取得变量
        $host   =   $settings['dbhost'];
        $db     =   $settings['dbname'];
        $user   =   $settings['dbuser'];
        $pass   =   $settings['dbpass'];
        //pdo调用数据库
        $pdo   =   new PDO('mysql:host='.$host.';dbname='.$db,$user,$pass);
        if ($pdo == null) {
        	echo "数据库链接失败，请重试！";
        	exit;
        }
        $this->pdo = $pdo;
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
        //register_shutdown_function(array(&$this,'close'));
    }

	/**
	 * @return null
	 */
    private function __clone()
    {
        // TODO: Implement __clone() method.
	    return null;
    }

	/**
	 * @param $sql
	 * @return array
	 */
   public function queryAll($sql){
        $stm = $this->pdo->query($sql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $re = $stm->fetchAll();
        return  $re;
   }

	/**
	 * @param $sql
	 * @return mixed
	 */
    public function queryOne($sql){
        $stm = $this->pdo->query($sql);
        //获得结果 指针下移
        $re  = $stm->fetch();
        return $re;
    }

	/**
	 * 执行增删改操作
	 * @param $sql
	 * @return int
	 */
    public function add($sql){
        //防止sql注入
        $stm = $this->pdo->prepare($sql);
        $re = $this->pdo->exec($sql);
        return $re;
    }

    public function testConnect(){
    	$sql = "DROP TABLE `test`;";
    	$this->add($sql);
    	$create = "CREATE TABLE `test` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
test CHAR(30) NOT NULL DEFAULT 'connect successfully!');";
    	$this->add($create);
	    $insert = "INSERT INTO `test` (test) VALUES ('connect successfully!');";
	    $rst = $this->add($insert);
		if ($rst){
			echo "恭喜你，数据库测试连接成功！";
		}else{
			echo "很遗憾，数据库测试连接失败！";
		}


    }
}

?>
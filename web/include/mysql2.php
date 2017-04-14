<?php
# 文件名称:mysql.php 2009-11-1 16:18:23
# 数据库操作类
class dbmysql {
	var $querynum = 0;
	var $link;

	//静态变量保存全局实例
    private static $_instance = null;
	//静态方法，单例统一访问入口
    static public function getInstance($con_db_host,$con_db_id,$con_db_pass, $con_db_name) {
        if (is_null ( self::$_instance ) || isset ( self::$_instance )) {
            self::$_instance = new self($con_db_host,$con_db_id,$con_db_pass, $con_db_name);
        }
        return self::$_instance;
    }

	function  __construct($con_db_host,$con_db_id,$con_db_pass, $con_db_name = '',$db_charset='utf8',$pconnect = 0) {
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($con_db_host,$con_db_id,$con_db_pass)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = @mysql_connect($con_db_host,$con_db_id,$con_db_pass, 1)) {
				$this->halt('Can not connect to MySQL server');
			}
		}
		if($this->version() > '4.1') {
			if($db_charset!='latin1') {
				@mysql_query("SET character_set_connection=$db_charset, character_set_results=$db_charset, character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				@mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($con_db_name) {
			@mysql_select_db($con_db_name, $this->link);
		}

	}
	
	function query($sql, $type = '') {
	   $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->close();
				global $config_db;
				$db_settings = parse_ini_file("$config_db");
	            @extract($db_settings);
				
				$this->query($sql, 'RETRY'.$type);
			} 
		}
		$this->querynum++;
		return $query;
	}
}
?>
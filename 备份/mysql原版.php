<?php
# 文件名称:mysql.php 2009-11-1 16:18:23
# 数据库操作类
class dbmysql {
	var $querynum = 0;
	var $link;

	//静态变量保存全局实例
    private static $_instance = null;
	//静态方法，单例统一访问入口
	//new self |  new static
	//new一个类的时候会调用构造函数
    public static function getInstance($con_db_host,$con_db_id,$con_db_pass, $con_db_name) {
    	//下面确保只new一个对象，否则每次启动mysql.php
    	//都将new一个对象，浪费内存
        if (is_null ( self::$_instance ) /*|| isset ( self::$_instance )*/) {
            self::$_instance = new self($con_db_host,$con_db_id,$con_db_pass, $con_db_name);
        }
        return self::$_instance;
    }

	function  __construct($con_db_host,$con_db_id,$con_db_pass, $con_db_name = '',$db_charset='utf8',$pconnect = 0) {
		//函数的默认参数，如果没有传入则取默认值
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($con_db_host,$con_db_id,$con_db_pass)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			//mysql和mysqli的区别为:mysqli是新出的函数，有优化
			//下面是判断是否连接,
			//mysqli_connect_errno()更好，能返回错误码
			//mysql_connect第四个参数 若为0则是不开新连接
			//若为1，则重复调用时使用新的连接
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
			//因为mysql_connect()无法选择数据库名
			//mysqli_connect(ip，用户名，密码，数据库名)
			//↓相当于手动敲 use+数据库名
			@mysql_select_db($con_db_name, $this->link);
		}

	}

	
	
	function move_first($query) {
		mysql_data_seek($query,0);
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	//MYSQL_ASSOC不需要加引号
	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		if(!$query)
		{
			return "";
		}
		else
		{
			//mysql_fetch_array仅仅是返回数据集的一条
			//如果想返回所有满足条件的，需要用到while循环
			return mysql_fetch_array($query,$result_type);
		}
	}
	
	function update($table, $bind=array(),$where = '')
	{
	    $set = array();
	    foreach ($bind as $col => $val) {
	    	//下面是普通数组而不是key-value数组,
	    	//key-value使用=>连接
	        $set[] = "$col = '$val'";
	        unset($set[$col]);
	    }
	    $sql = "UPDATE "
             . $table
             . ' SET ' . implode(',', $set)
             . (($where) ? " WHERE $where" : '');
        $this->query($sql);
	}
	
	
	function insert($table, $bind=array())
	{
	    $set = array();
	    foreach ($bind as $col => $val) {
	        $set[] = "`$col`";
	        $vals[] = "'$val'";
	    }
	   $sql = "INSERT INTO "
             . $table
             . ' (' . implode(', ', $set).') '
             . 'VALUES (' . implode(', ', $vals).')';
        $this->query($sql);
        return $this->insert_id();
	}
	
	/**
	* 执行sql语句，只得到一条记录
	* @param string sql语句
	* @return array
	*/
	//下面不需要传入$type
	function get_one($sql, $type = '')
	{
		$query = $this->query_direct($sql, $type);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs ;
	}
	


	function query($sql, $type = '') {
		//问号表达式	表达式?A:B 表达式为真则a，假则b
		//等价于if(表达式){
		//	A;
		//}else{
		//	B;
		//}
	   $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->close();
				global $config_db;
				$db_settings = parse_ini_file("$config_db");
	            @extract($db_settings);
				//$this->dbconn($con_db_host,$con_db_id,$con_db_pass, $con_db_name = '',$pconnect);
				$this->query($sql, 'RETRY'.$type);
			} 
		}
		$this->querynum++;
		return $query;
	}

	function query_direct($sql){
		return mysql_query($sql, $this->link);
	}
	
	function counter($table_name,$where_str="", $field_name="*")
	{
	    $where_str = trim($where_str);
	    if(strtolower(substr($where_str,0,5))!='where' && $where_str) {$where_str = "WHERE ".$where_str;}
	    $query = " SELECT COUNT($field_name) FROM $table_name $where_str ";
	    $result = $this->query($query);
	    $fetch_row = mysql_fetch_row($result);
	    return $fetch_row[0];
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	function list_fields($con_db_name,$table) {
		$fields=mysql_list_fields($con_db_name,$table,$this->link);
	    $columns=$this->num_fields($fields);
	    for ($i = 0; $i < $columns; $i++) {
	        $tables[]=mysql_field_name($fields, $i);
	    }
	    return $tables;
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '',$sql) {
	     $sqlerror = mysql_error();
		 $sqlerrno = mysql_errno();
		 $sqlerror = str_replace($dbhost,'dbhost',$sqlerror);
		 echo"<html><head><title>CSSInfo</title><style type='text/css'>P,BODY{FONT-FAMILY:tahoma,arial,sans-serif;FONT-SIZE:10px;}A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}TD { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 16pt; COLOR: #000000;}</style><body>\n\n";
		echo"<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>";
		echo"<br><br><b>The URL Is</b>:<br>http://$_SERVER[HTTP_HOST]$REQUEST_URI";
		echo"<br><br><b>MySQL Server Error</b>:<br>$sqlerror  ( $sqlerrno )";
		echo"</td></tr></table>";
		exit;
	}
}
?>
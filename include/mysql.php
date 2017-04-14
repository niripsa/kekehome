<?php
# 文件名称:mysql.php 2009-11-1 16:18:23
# 数据库操作类

/*$a=false;
var_dump(is_null($a));
var_dump(isset($a));
*/
class dbmysql {
	var $querynum = 0;
	var $link;

	//静态变量保存全局实例(对象)
	private static $_instance = null;
	//静态方法，单例统一访问入口(只new一次)
	//db:database con:connect
	public static function getInstance($con_db_host,$con_db_id,$con_db_pass,$con_db_name) {
		//下面确保只new一个对象，否则每次启动mysqli.php
		//都将new一个，浪费内存
		if (is_null ( self::$_instance )) {
			self::$_instance = new self($con_db_host,$con_db_id,$con_db_pass,$con_db_name);
		}
		return self::$_instance;
	}

	function __construct($con_db_host,$con_db_id,$con_db_pass,$con_db_name = '',$db_charset = 'utf8',$pconnect = 0){
		//↑函数的默认参数，若不传则取默认值
		if ($pconnect) {
			if (!$this->link = @mysql_pconnect($con_db_host,$con_db_id,$con_db_pass)) {
				$this->halt('Can not connect to MySQL Server');
			}else{
				if ($con_db_name) {
					@mysql_select_db($con_db_name,$this->link);
				}
			}
		} else {
			if (!$this->link = @mysqli_connect($con_db_host,$con_db_id,$con_db_pass,$con_db_name)) {
				$this->halt('Can not connect to MySQL Server');
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
	}

	//下面的是mysql当中比较少用的函数，故省略，但是mysqli中也存在对应的函数
	/*function move_first($query) {
		mysql_data_seek($query,0);
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}*/
	function move_first($query) {
		mysqli_data_seek($query,0);
	}

	function error() {
		return ($this->link) ? mysqli_error($this->link) :mysqli_error();
	}

	function errno() {
		return intval(($this->link) ? mysqli_errno($this->link) : mysqli_errno());
	}

	//直接去掉了unbuffered查询
	//mysqli_query(连接，语句)
	//mysql_query(语句，连接)
	function query($sql,$type='') {
		if (!($query = mysqli_query($this->link,$sql))) {
			if (in_array($this->errno(),array(2006,2013)) && substr($type,0,5) != 'RETRY') {
				$this->close();
				global $db_settings;
				@extract($db_settings);
				$this->mysqli_connect($con_db_host,$con_db_id,$con_db_pass,$con_db_name);
				$this->query($sql,'RETRY'.$type);
			}
		}
		$this->querynum++;
		return $query;
	}

	function query_direct($sql){
		return mysqli_query($this->link,$sql);
	}

	function fetch_array($query,$result_type=MYSQL_ASSOC){
		if (!$query) {
			return "";
		} else {
			return mysqli_fetch_array($query,$result_type);
		}
	}

	function update($table,$bind=array(),$where=''){
		$set = array();
		foreach ($bind as $col => $val) {
			$set[]="$col = '$val'";
			#unset(#set[$col]);
		}
		$sql= "UPDATE"
			. $table
			.'set'.implode(",",$set)
			.(($where)? "WHERE $where" : "");
		$this->query($sql);
	}

	function insert_id() {
		return ($id = mysqli_insert_id($this->link)) >=0 ? $id : $this->fetch_array($this->query("SELECT last_insert_id()"));
	}

	function insert($table,$bind=array()) {
		$set = array();
		foreach ($bind as $_key => $_value) {
			$set[] = "`$_key`";
			$vals[] = "'$_value'";
		}
		$sql= "INSERT INTO"
			. $table
			. ' ('.implode(",",$set).') '
			.'VALUES ('.implode(",",$vals).")";
		$this->query($sql);
		return $this->insert_id();
	}

	function free_result($query) {
		return mysqli_free_result($query);
	}

	function get_one($sql){
		$query = $this->query_direct($sql);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		//倘若$rs=$this->fetch_array($this->query_direct(sql)),则仍然占用内存
		return $rs;
	}

	function counter($table_name,$where_str="",$field_name ="*") {
		//trim:去除字符串两边空格
		$where_str = trim($where_str);
		#substr 前包后不包
		if (strtolower(substr($where,0,5))!='where' && $where_str) {
			$where_str .="WHERE";
		}
		$query = "SELECT COUNT($field_name) FROM $table_name $where_str";
		$result = $this->query($query);
		$fetch_row =mysqli_fetch_row($result);
		//↑这个函数存在,返回为数组,每次返回一行,去掉key,只返回value,若没有可以返回的数据则返回false
		return $fetch_row[0];
	}

	function affected_rows() {
		return mysqli_affected_rows($this->link);
	}

	#↓mysql_list_fields在mysqli中不存在，故删去
	/*function list_fields($con_db_name,$table) {
		$fields=mysql_list_fields($con_db_name,$table,$this->link);
	    $columns=$this->num_fields($fields);
	    for ($i = 0; $i < $columns; $i++) {
	        $tables[]=mysql_field_name($fields, $i);
	    }
	    return $tables;
	}*/
	function fetch_row($query) {
		return mysqli_fetch_row($query);
	}

	//为了与原文件中函数名保持一致，故使用fetch_fields
	function fetch_fields($query) {
		return mysqli_fetch_field($query);
	}

	function num_rows($query) {
		return mysqli_num_rows($query);
	}

	function num_fields($query) {
		return mysqli_num_fields($query);
	}

	function version(){
		return mysqli_get_server_info($this->link);
	}

	function close() {
		return mysqli_close($this->link);
	}

	function halt($message = '',$sql) {
	     $sqlierror = mysqli_error();
		 $sqlierrno = mysqli_errno();
		 $sqlierror = str_replace($dbhost,'dbhost',$sqlierror);
		 echo"<html><head><title>CSSInfo</title><style type='text/css'>P,BODY{FONT-FAMILY:tahoma,arial,sans-serif;FONT-SIZE:10px;}A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}TD { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 16pt; COLOR: #000000;}</style><body>\n\n";
		echo"<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>";
		echo"<br><br><b>The URL Is</b>:<br>http://$_SERVER[HTTP_HOST]$REQUEST_URI";
		echo"<br><br><b>MySQL Server Error</b>:<br>$sqlierror  ( $sqlierrno )";
		echo"</td></tr></table>";
		exit;
	}
}
?>
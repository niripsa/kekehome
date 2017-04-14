<?php

class Member {

    //静态变量保存全局实例
    private static $_instance = null;
    private $link  ;
    private $username  ;
    //私有构造函数，防止外界实例化对象
    private function __construct() {
        $this->$link;
        

        
    }
    //私有克隆函数，防止外办克隆对象
    private function __clone() {
    }
    //静态方法，单例统一访问入口
    static public function getInstance() {
        if (is_null ( self::$_instance ) || isset ( self::$_instance )) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }
  

    public function Dbquery($sql) {    
         return Mysql_query($sql,$this->$link);

    }
}





?>
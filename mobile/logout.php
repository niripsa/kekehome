<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
//setcookie("m_username", '',$expire,'/');
setcookie("m_password", '',NULL,'/');
setcookie("m_fullname", '',NULL,'/');
setcookie("m_level", '',NULL,'/');
setcookie("m_isPass", '',NULL,'/');

redirect('/');
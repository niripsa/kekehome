<?php
switch($clause)
{
	case "addinfo":
		menu();
		addinfo();
		break;
	case "saveaddinfo":
		saveaddinfo();
		break;
	case "saveeditinfo":
		saveeditinfo();
		break;
	case "editinfo":
		menu();
		editinfo();
		break;
	case "delinfo":
		delinfo();
		break;
	case "saveorder":
		saveorder();
		break;
	default:
		menu();
		eval($admin_article_page_config['config']['defaultFun']);
		break;
}

function menu()
{
	admin_article_menu();
}

function main()
{
	admin_article_main();
}

function addinfo()
{
	admin_article_record_interface();
}

function saveaddinfo()
{
	admin_article_record_save();
}

function editinfo()
{
	admin_article_record_interface();
}

function saveeditinfo()
{
	admin_article_record_save();
}

function saveorder()
{
	admin_article_chkAndUpdateOrder();
}

function delinfo()
{
	admin_article_delete();
}

//=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=

function admin_article_record_replaceVal($val)
{
	$temp = $val;
	if($temp == '{now}')
		$temp = date("Y-m-d H:i:s");
		
	return $temp;
}

function admin_article_menu()
{
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;
	
	if(count($admin_article_page_config['menu']) <= 0)
		return;
	
	echo '<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">';
	echo '<tr>';
	echo '<td height="25" class="tdtitle" align="center">' . $mTitle . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td height="23" class="tdbottom" align="center">';
	
	$menu_ci = 0;
	foreach($admin_article_page_config['menu'] as $menu_key=>$menu_val)
	{
		$menu_ci++;
		if($menu_ci > 1)
		{
			echo ' | ';
		}
		if($menu_key == 'add')
		{
			echo '<a href="?clause=addinfo&' . $pageParms . '">' . $menu_val . $admin_article_page_config['config']['keyName'] . '</a>';
		}
		if($menu_key == 'list')
		{
			echo '<a href="?' . $pageParms . '">' . $admin_article_page_config['config']['keyName'] . $menu_val . '</a>';
		}
	}

	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<br />';
}

function admin_article_main()
{
	global $db;
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;
	global $page,$total_count;
	
	$sql_select_field = 'id';
	foreach($admin_article_page_config['list'] as $config_key=>$config_val)
	{
		if($config_key == 'OTFV')
		{
			$sql_select_field .= ',(' . $config_val['sql'] . ' LIMIT 1) as ' . $config_val['field'];
		}
		else if($config_key == 'order')
		{
			$sql_select_field .= ',h_order';
		}
		else if($config_key != 'action' && $config_key != 'id')
		{
			$sql_select_field .= ',' . replace($config_key,'|',',') ;
		}
	}

	$list_num = $admin_article_page_config['config']['listNum'];
	$whereKK = $admin_article_page_config['config']['whereKK'];
	if($whereKK){
		$whereKK = "h_location = '$location' and h_menuId = $mid";
	}else{
		$whereKK = "1 = 1";
	}
	$orderBy = $admin_article_page_config['config']['orderBy'];
	if(!$orderBy){
		$orderBy = "h_order asc,h_addTime desc,id desc";
	}
	$total_count = $db->counter("`" . $admin_article_page_config['config']['dbTable'] . "`", $whereKK, 'id');$page = (int)$page;$rowset = new Pager($total_count,$list_num,$page);$from_record = $rowset->_offset();$page_list = $rowset->link('?' . $pageParms . '&page=');
	$query = "select " . $sql_select_field . " from `" . $admin_article_page_config['config']['dbTable'] . "` a where {$whereKK} order by {$orderBy} LIMIT $from_record, $list_num";
	//echo $query;
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	
	$tdCount = count($admin_article_page_config['list']);
	
	echo '<form action="?clause=saveorder&' . $pageParms . '" method="post" name="myForm" id="myForm" onSubmit="return jquery_submitAllBtnDis();">';
	
	echo '<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">';
	echo '<tr>';
	echo '<td height="25" colspan="' . $tdCount . '" align="center" class="tdtitle">列表</td>';
	echo '</tr>';
	echo '<tr>';
	foreach($admin_article_page_config['list'] as $config_key=>$config_val)
	{
		echo '<td';
		if($config_val['width'] != '')echo ' width="' . $config_val['width'] . '"';
		echo ' align="center" height="23" class="tdtitle-title">';
		echo $config_val['title'];
		echo '</td>';
	}
	echo '</tr>';

	$hasOrder = 0;
	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			echo '<tr>';
			foreach($admin_article_page_config['list'] as $config_key=>$config_val)
			{
				echo '<td align="' . $config_val['align'] . '" height="25">';
				if($config_key == 'action')
				{
					$action_ci = 0;
					foreach($config_val['action'] as $action_key=>$action_val)
					{
						$action_ci++;
						if($action_ci > 1)
						{
							echo ' | ';
						}
						if($action_key == 'edit')
						{
							echo '<a href="?clause=editinfo&id=' . $val[id] . '&' . $pageParms . '">' . $action_val . '</a>';
						}
						if($action_key == 'delete')
						{
							echo '<a href="#nolink" onClick="hintandturn(\'确定要删除吗？数据将不可恢复！\',\'?clause=delinfo&id=' . $val[id] . '&' . $pageParms . '\',true);">' . $action_val . '</a>';
						}
					}
				}
				else if($config_key == 'order')
				{
					$hasOrder = 1;
				
					echo '<input name="order_' . $val['id'] . '" type="text" class="inputclass3" maxlength="3" value="' . $val['h_order'] . '" />';
				}
				else if($config_key == 'OTFV')
				{
					echo $val[$config_val['field']];
				}
				else if($config_key == 'h_picSmall' || $config_key == 'h_picBig' || $config_key == 'h_picBigN')
				{
					echo '<img src="' . $val[$config_key] . '" width="120" />';
				}
				else if($config_key == 'h_pic')
				{
					echo '<img src="' . $val[$config_key] . '"';
					if($config_val['picHeight']){
						echo ' height="' . $config_val['picHeight'] . '"';
					}
					if($config_val['picWidth']){
						echo ' width="' . $config_val['picWidth'] . '"';
					}
					echo ' />';
				}
				else
				{
					if(strrpos($config_key,'|') >= 0)
					{
						$config_key_arr = explode('|',$config_key);
						$fci = 0;
						foreach($config_key_arr as $config_key_arr_val)
						{
							if(is_array($config_val['shtmls'])){
								echo $config_val['shtmls'][$fci];
							}
							
							if(is_array($config_val['case'][$fci])){
								foreach($config_val['case'][$fci] as $caseKey=>$caseVal){
									if($caseKey == $val[$config_key_arr_val]){
										echo $caseVal;
										break;
									}
								}
							}else{
								echo $val[$config_key_arr_val] . '<br />';
							}
							
							$fci++;
						}
					}
					else
					{
						echo $val[$config_key];
					}
				}
				echo '</td>';
			}
			echo '</tr>';
		}
		
		if($hasOrder == 1)
		{
			echo '<tr>';
			echo '<td height="25" colspan="' . $tdCount . '" align="center"><input type="submit" name="form_submit_" value=" 提交更新排序 " class="bttn" /></td>';
			echo '</tr>';
		}
	}
	else
	{
		echo '<tr>';
		echo '<td height="25" colspan="' . $tdCount . '" align="center">没有数据</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	echo '</form>';

	if(count($rs_list) > 0) echo "<div style='text-align:center;'>$page_list</div>";
}

function admin_article_record_interface()
{
	global $db;
	global $id;$id = (int)$id;
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;
	global $categoryId;$categoryId = (int)$categoryId;
	global $ckeditor_mc_id,$ckeditor_mc_val,$ckeditor_mc_lang,$ckeditor_mc_toolbar,$ckeditor_mc_height;
	
	if($id <= 0)
	{
		if($admin_article_page_config['config']['defaultFun'] == 'editinfo();')
		{
			$rs = $db->get_one("select id from `" . $admin_article_page_config['config']['dbTable'] . "` where h_location = '$location' and h_menuId = $mid order by h_order asc,id asc LIMIT 1");
			if(!$rs)
			{
				$query = "insert into `" . $admin_article_page_config['config']['dbTable'] . "` SET h_location = '$location',h_menuId = $mid";
				$db->query($query);
				
				$rs = $db->get_one("select id from `" . $admin_article_page_config['config']['dbTable'] . "` where h_location = '$location' and h_menuId = $mid order by h_order asc,id asc LIMIT 1");
			}
			$id = (int)$rs['id'];
		}
	}
	
	if($id > 0)
	{
		$rs = $db->get_one("select * from `" . $admin_article_page_config['config']['dbTable'] . "` where id = $id LIMIT 1");
		if(!$rs)
		{
			HintAndBack("抱歉，未找到您指定的数据！",1);
		}
	}
	
	echo '<form action="?clause=';
	if($id > 0)
		echo 'saveeditinfo';
	else
		echo 'saveaddinfo';
	echo '&' . $pageParms . '&id=' . $id . '" method="post" name="myForm" id="myForm" onSubmit="return jquery_submitAllBtnDis();">';
	
	foreach($admin_article_page_config['record']['hidden'] as $hidden_key=>$hidden_val)
	{
		echo '<input name="' . $hidden_key . '" type="hidden" value="';
		if($id > 0)
			echo $rs[$hidden_key];
		else
			echo admin_article_record_replaceVal($hidden_val);
		echo '" />';
	}
	
	echo '<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tableborder">';
	echo '<tr>';
	echo '<td height="25" colspan="2" align="center" class="tdtitle">';
	if($admin_article_page_config['config']['keyName'] == '{mTitle}')
	{
		echo $mTitle;
	}
	else
	{
		if($id > 0)
			echo '修改';
		else
			echo '添加';
		echo $admin_article_page_config['config']['keyName'];
	}
	echo '</td>';
	echo '</tr>';
	
	foreach($admin_article_page_config['record'] as $record_key=>$record_val)
	{
		if($record_key != 'hidden')
		{
			echo '<tr>';
			
			echo '<td width="15%" align="center">';
			echo $record_val['title'];
			echo '：</td>';
			echo '<td>';
			
			$hasVal = 0;
			switch($record_val['control'])
			{
				case 'radio':
					if($id > 0){
						$radio_val = $rs[$record_key];
					}else{
						$radio_val = $record_val['attr']['value'];
					}

					$radio_ci = 0;
					foreach($record_val['list'] as $attr_key=>$attr_val)
					{
						echo '<input type="radio" value="' . $attr_key . '" name="' . $record_key . '" id="' . $record_key . '_' , $radio_ci , '"';
						if($radio_val == $attr_key){
							echo ' checked="checked"';
						}
						echo ' />';
						echo '<label for="' . $record_key . '_' , $radio_ci , '">' , $attr_val , '</label> &nbsp; ';
						
						$radio_ci++;
					}
					break;
				case 'text':
					echo '<input type="text"';
					echo ' name="' . $record_key . '" id="' . $record_key . '"';
					foreach($record_val['attr'] as $attr_key=>$attr_val)
					{
						if($attr_key == 'value')
						{
							$hasVal = 1;
						}
						else
						{
							echo ' ' . $attr_key . '="' . $attr_val . '"';
						}
					}
					if($id > 0)
					{
						echo ' value="' . $rs[$record_key] . '"';
					}
					else if($hasVal == 1)
					{
						echo ' value="' . admin_article_record_replaceVal($record_val['attr']['value']) . '"';
					}
					echo ' />';
					break;
				case 'textarea':
					echo '<textarea';
					echo ' name="' . $record_key . '" id="' . $record_key . '"';
					foreach($record_val['attr'] as $attr_key=>$attr_val)
					{
						if($attr_key == 'value')
						{
							$hasVal = 1;
						}
						else
						{
							echo ' ' . $attr_key . '="' . $attr_val . '"';
						}
					}
					echo '>';
					if($id > 0)
					{
						echo $rs[$record_key];
					}
					else if($hasVal == 1)
					{
						echo admin_article_record_replaceVal($record_val['attr']['value']);
					}
					echo '</textarea>';
					break;
				case 'fckeditor':
					$ckeditor_mc_id = $record_key;
					$ckeditor_mc_toolbar = "Default";
					$ckeditor_mc_height = $record_val['attr']['Height'];
					if($id > 0)
					{
						$ckeditor_mc_val = $rs[$record_key];
					}
					FCreateCkeditor();
					break;
				case 'select':
					echo '<select';
					echo ' name="' . $record_key . '" id="' . $record_key . '"';
					echo '>';
					
					echo "<option value='0'>-=请选择=-</option>";
					
					$result = $db->query("select * from `h_category` where h_location = '$location' and h_menuId = $mid order by h_order asc,id asc");
					while($list = $db->fetch_array($result))
					{
						$rs_list[] = $list;
					}
					foreach ($rs_list as $key=>$val)
					{
						echo '<option value="' . $val['id'] . '">' . $val['h_title'] . '</option>';
					}

					echo '</select>';
					
					if($id > 0)
					{
						echo '<script language="javascript">$("#' . $record_key . '").val("' . $rs[$record_key] . '");</script>';
					}
					else if($hasVal == 1)
					{
						echo '<script language="javascript">$("#' . $record_key . '").val("' . admin_article_record_replaceVal($record_val['attr']['value']) . '");</script>';
					}
					if($categoryId > 0)
					{
						echo '<script language="javascript">$("#' . $record_key . '").val("' .$categoryId . '");</script>';
					}
					break;
			}
			
			echo $record_val['tips'];

			if($record_val['required'] == 1)
				echo ' <font color="#ff0000">*</font>';
				
			switch($record_key)
			{
				case 'h_keyword':
					echo '<br />若有单独关键字请填写，放空则自动使用网站关键字，利于搜索引擎收录，请不要回车换行';
					break;
				case 'h_description':
					echo '<br />若有单独介绍请填写，放空则自动使用网站介绍，利于搜索引擎收录，请不要回车换行';
					break;
				case 'h_pageKey':
					echo ' [<a class="pointer" onclick="getPinYin(\'h_pageKey\',$(\'#h_title\').val())">根据标题自动转拼音</a>] ';
					echo '<br />利于搜索引擎收录，比如栏目为“关于我们”，可设置页面名称为“about-us”，空格用-代替，若不优化可不填';
					break;
				case 'h_addTime':
					echo '时间越早，说明信息越旧，将排在越后面';
					break;
				case 'h_pic':
					echo '[<a style="cursor:pointer;" onClick="AdminUpLoadFile(\'h_pic\');"><font color="#ff0000">上传图片</font></a>] ';
					break;
				case 'h_picBig':
					echo '[<a style="cursor:pointer;" onClick="AdminUpLoadFile(\'h_picBig\');"><font color="#ff0000">上传图片</font></a>] ';
					break;
				case 'h_picBigN':
					echo '[<a style="cursor:pointer;" onClick="AdminUpLoadFile(\'h_picBigN\');"><font color="#ff0000">上传图片</font></a>] ';
					break;
				case 'h_picSmall':
					echo '[<a style="cursor:pointer;" onClick="AdminUpLoadFile(\'h_picSmall\');"><font color="#ff0000">上传图片</font></a>] ';
					echo '[<a style="cursor:pointer;" onClick="AdminPicAutoSmall(\'h_picBig\',\'h_picSmall\');"><font color="#ff0000">自动缩小</font></a>] ';
					break;
			}
				

			
			echo '</td>';
			
			echo '</tr>';
		}
	}
	
	echo '<tr>';
	echo '<td colspan="2" align="center">';
	echo '<input type="submit" name="form_submit_" value=" ';
	if($id > 0)
		echo '确定保存';
	else
		echo '确定添加';
	echo ' " class="bttn">';
	//echo ' ';
	//echo '<input type="button" name="form_button_back_" value=" 返回 " class="bttn" onClick="history.go(-1);"></td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';
}

function admin_article_record_save()
{
	global $db;
	global $id;$id = (int)$id;
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;
	global $h_title,$h_href,$h_target,$h_addTime;	//link
	global $h_keyword,$h_description,$h_info;	//article 新增
	global $h_pageKey;	//atricles 新增
	global $h_categoryId; //news 新增
	global $h_picBig,$h_picSmall;	// pics 新增
	
	if($id > 0)
		$query = "update `" . $admin_article_page_config['config']['dbTable'] . "` SET ";
	else
		$query = "insert into `" . $admin_article_page_config['config']['dbTable'] . "` SET ";
	
	$query .= "h_location = '$location'";
	$query .= ",h_menuId = $mid";
	
	/*
	if(!is_null($h_title)){$query .= ",h_title = '$h_title'";}
	if(!is_null($h_href)){$query .= ",h_href = '$h_href'";}
	if(!is_null($h_target)){$query .= ",h_target = '$h_target'";}
	if(!is_null($h_addTime)){$query .= ",h_addTime = '$h_addTime'";}
	if(!is_null($h_keyword)){$h_keyword = replace($h_keyword,"\r\n",'');$query .= ",h_keyword = '$h_keyword'";}
	if(!is_null($h_description)){$h_description = replace($h_description,"\r\n",'');$query .= ",h_description = '$h_description'";}
	if(!is_null($h_info)){$query .= ",h_info = '$h_info'";}
	if(!is_null($h_pageKey)){if($h_pageKey != ''){$rs = $db->get_one("select id from `" . $admin_article_page_config['config']['dbTable'] . "` where h_pageKey = '$h_pageKey' and h_location = '$location' and h_menuId = $mid and id <> $id LIMIT 1");if($rs){HintAndBack("抱歉，页面名称已经被占用，请换一个，不能重复！",1);}}$query .= ",h_pageKey = '$h_pageKey'";}
	if(!is_null($h_categoryId)){$h_categoryId = (int)$h_categoryId;$query .= ",h_categoryId = '$h_categoryId'";}
	if(!is_null($h_picBig)){$query .= ",h_picBig = '$h_picBig'";}
	if(!is_null($h_picSmall)){$query .= ",h_picSmall = '$h_picSmall'";}
	*/
	if(is_array($_POST)){
		foreach($_POST as $key=>$val){
			if(substr($key,0,2) == 'h_'){
				$val = daddslashes($val);
				$query .= ",{$key} = '{$val}'";
			}
		}
	}
	
	if($id > 0)
		$query .= " where id = $id";
			   
	$db->query($query);

	if($id > 0)
	{
		if($admin_article_page_config['config']['recordEditBack'] == 'editinfo')
		{
			HintAndTurn('保存成功！','?clause=editinfo&id=' . $id . '&' . $pageParms);
		}
		else
		{
			HintAndTurn('保存成功！','?' . $pageParms);
		}
	}
	else
	{
		HintAndTurn('添加成功！','?clause=' . $admin_article_page_config['config']['recordAddBack'] . '&categoryId=' . $h_categoryId . '&' . $pageParms);
	}
}

function admin_article_chkAndUpdateOrder()
{
	global $db;
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;
	
	foreach($_POST as $key=>$val)
	{
		if(left($key,6) == 'order_')
		{
			$order = (int)$_POST[$key];
			$id = (int)replace($key,'order_','');
			
			$query = "update `" . $admin_article_page_config['config']['dbTable'] . "` SET h_order = $order where id = " . $id;		 
			$db->query($query);
		}
	}
	
	HintAndTurn('排序成功！','?' . $pageParms);
}

function admin_article_delete()
{
	global $db;
	global $id;$id = (int)$id;
	global $location,$mid,$mTitle,$pageParms;
	global $admin_article_page_config;

	$query = "delete from `" . $admin_article_page_config['config']['dbTable'] . "` where id = $id";
	$db->query($query);
	
	okinfo('?' . $pageParms,'删除成功！');
}
?>
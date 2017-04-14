<?php
function list_($a){
	global $rewriteOpen,$db;
	global $page,$total_count,$met_pageskin;
	global $mid,$mType,$mTitle,$mPageKey;
	global $cid,$cPageKey;
	global $memberLogged_userName;
	$mid = 111;
	if($a == 1){
	$total_count = $db->counter('h_log_point1', "h_userName = '{$memberLogged_userName}' and h_price > 0", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point1` where h_userName = '{$memberLogged_userName}' and h_price > 0 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , $val['h_type'] , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";
	}elseif($a==2){
		$total_count = $db->counter('h_log_animal', "h_userName = '{$memberLogged_userName}' and h_type_id = 1", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_animal` where h_userName = '{$memberLogged_userName}' and h_type_id = 1 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , $val['h_type'] , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";	
		}elseif($a==3){
		$total_count = $db->counter('h_log_animal', "h_userName = '{$memberLogged_userName}' and h_type_id = 2", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_animal` where h_userName = '{$memberLogged_userName}' and h_type_id = 2 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , $val['h_type'] , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";	
		}elseif($a==4){
		$total_count = $db->counter('h_log_point2', "h_userName = '{$memberLogged_userName}' and h_type_id = 4", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type_id = 4 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , str_replace("宠物","可可",$val['h_type']) , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";	
		}elseif($a==5){
		$total_count = $db->counter('h_log_point2', "h_userName = '{$memberLogged_userName}' and (h_type_id = 2 or h_type_id = 3)", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point2` where h_userName = '{$memberLogged_userName}' and (h_type_id = 2 or h_type_id = 3) order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , str_replace("宠物","可可",$val['h_type']) , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";	
		}elseif($a==6){
			$total_count = $db->counter('h_log_point2', "h_userName = '{$memberLogged_userName}' and h_type_id = 5", 'id');
	$page = (int)$page;
	if($page_input){$page=$page_input;}
	$list_num = 10;
	$met_pageskin = 5;
	$rowset = new Pager($total_count,$list_num,$page);
	$from_record = $rowset->_offset();
	$query = "select * from `h_log_point2` where h_userName = '{$memberLogged_userName}' and h_type_id = 5 order by h_addTime desc,id desc LIMIT $from_record, $list_num";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	if($rewriteOpen == 1)
	{
		$page_list = $rowset->link("/$mPageKey/page",".html");
	}
	else
	{
		$page_list = $rowset->link(GetUrl(2) . "?page=");
	}

	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$val['h_addTime'] = date("Y-m-d",strtotime($val['h_addTime']));
			echo '  <tr>
				<td>' , str_replace("宠物","可可",$val['h_type']) , '</td>
				<td>' , $val['h_price'] , '</td>
				<td>' , $val['h_addTime'] , '</td>
			  </tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="99">暂无记录</td></tr>';
	}

	if(count($rs_list) > 0) echo "<tr>
                    <td colspan='99'>{$page_list}</td>
                </tr>";
		}
}
?>
<?php
function web_top_main_menu()
{
	global $db;
	$location = '网站主栏目';
	$query = "select * from `h_menu` where h_location = '$location' and h_isPass = 1 order by h_order asc,id asc";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	
	$ci = 0;
	foreach ($rs_list as $key=>$val)
	{
		$ci++;
		
		if($val['h_type'] == 'link')
		{
			echo '<li>';
			echo '<a href="' . $val['h_href'] . '" target="' . $val['h_target'] . '" id="menu_' . $ci . '">' . $val['h_title']. '</a>';
			echo '</li>';
		}
		else
		{
			echo '<li>';
			echo '<a href="' . create_page_url_htaccess_or_not('menu',$val['h_type'],$val['id'],$val['h_pageKey'],0,'',0,'') . '" id="menu_' . $ci . '">' . $val['h_title'] . '</a>';
			echo "</li>";
		}
	}
}

function web_left_sub_menu($mType,$mid,$mPageKey,$mTitle,$cid,$cPageKey)
{
	global $db;

	switch($mType)
	{
		case 'articles':
		case 'pics':
			$urlType = 'detail';
			$sql = 'select id,h_title,h_pageKey from `h_article` where h_menuId = ' . $mid . ' order by h_order asc,id asc';
			break;
		case 'news':
		case 'album':
		case 'photos':
			$urlType = 'category';
			$sql = 'select id,h_title,h_pageKey from `h_category` where h_menuId = ' . $mid . ' order by h_order asc,id asc';
			break;
		default:
			return;
	}
	$result = $db->query($sql);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	
	if(count($rs_list) > 0)
	{
		echo '<div class="lBox">';
		echo '	<div class="t"><span class="l">' . $mTitle . '</span></div>';
		echo '	<div class="clear"></div>';
		echo '	<div class="i list">';

		foreach ($rs_list as $key=>$val)
		{
			if($urlType == 'detail')
				echo '<a href="' . create_page_url_htaccess_or_not($urlType,$mType,$mid,$mPageKey,$cid,$cPageKey,$val['id'],$val['h_pageKey']) . '">' . $val['h_title'] . '</a>';
			else
				echo '<a href="' . create_page_url_htaccess_or_not($urlType,$mType,$mid,$mPageKey,$val['id'],$val['h_pageKey'],0,'') . '">' . $val['h_title'] . '</a>';
		}
		
		echo '</div>';
		echo '	<div class="b"></div>';
		echo '</div>';
	}
}

function web_bottom_footer_menu()
{
	global $db;
	$location = '底部栏目';
	$query = "select * from `h_menu` where h_location = '$location' and h_isPass = 1 order by h_order asc,id asc";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}
	
	$ci = 0;
	if(count($rs_list) > 0)
	{
		foreach ($rs_list as $key=>$val)
		{
			$ci++;
			
			if($ci > 1)
				echo ' | ';

			if($val['h_type'] == 'link')
			{
				echo '<a href="' . $val['h_href'] . '" target="' . $val['h_target'] . '" id="menu_footer_' . $ci . '">' . $val['h_title']. '</a>';
			}
			else
			{
				echo '<a href="' . create_page_url_htaccess_or_not('menu',$val['h_type'],$val['id'],$val['h_pageKey'],0,'',0,'') . '" id="menu_footer_' . $ci . '">' . $val['h_title'] . '</a>';
			}
		}
	}
}

function create_page_url_htaccess_or_not($urlType,$mType,$mid,$mPageKey,$cid,$cPageKey,$id,$iPageKey)
{
	global $rewriteOpen;
	$temp = '';

	if($rewriteOpen == 1)
	{
		$temp = '/' . $mPageKey . '/';
		switch($urlType)
		{
			case 'menu':
				break;
			case 'category':
				if($cPageKey != '')
					$temp .= $cPageKey . '/';
				elseif($cid > 0)
					$temp .= $cid . '/';
					
				break;
			case 'detail':
				//有子分类的，要加上子分类的路径
				switch($mType)
				{
					case 'news':
					case 'album':
					case 'photos':
						if($cPageKey != '')
							$temp .= $cPageKey . '/';
						elseif($cid > 0)
							$temp .= $cid . '/';

						break;
				}
					
				if($iPageKey != '')
					$temp .= $iPageKey . '.html';
				elseif($id > 0)
					$temp .= $id . '.html';
					
				break;
		}
	}
	else
	{
		$temp = '/web/' . $mType . '.php';
		switch($urlType)
		{
			case 'menu':
				$temp .= '?mkey=' . $mPageKey;
					
				break;
			case 'category':
				if($cPageKey != '')
					$temp .= '?ckey=' . $cPageKey;
				elseif($cid > 0)
					$temp .= '?cid=' . $cid;
					
				break;
			case 'detail':
				if($iPageKey != '')
					$temp .= '?ikey=' . $iPageKey;
				elseif($id > 0)
					$temp .= '?id=' . $id;
					
				break;
		}
	}
	
	return $temp;
}

function web_create_record_and_url_for_pic($isLink,$href,$target,$id,$title,$img,$pageKey,$cTarget,$mType,$mid,$mPageKey,$cid,$cPageKey,$shortNum,$w,$h,$pageUrl = '')
{
	if($isLink == 1)
	{
		$href_ = $href;
		$target_ = $target;
	}
	else
	{
		$href_ = create_page_url_htaccess_or_not('detail',$mType,$mid,$mPageKey,$cid,$cPageKey,$id,$pageKey);
		$target_ = $cTarget;
	}

	echo '<div class="pic">';
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" align="center" class="i">';
			echo '<a href="' . $pageUrl . '" target="' . $target_ . '">';
			echo '<img src="' . $img . '" alt="' . $title . '" onload="imgSizeReSet(this,' . $w . ',' . $h . ')" />';
			echo '</a>';
		echo '</td></tr></table>';
		echo '<div class="t">';
			echo '<a href="' . $pageUrl . '" target="' . $target_ . '">';
			if($shortNum > 0)
				echo shortStringCn($title,$shortNum);
			else
				echo $title;
			echo '</a>';
		echo '</div>';
	echo '</div>';
}

function web_create_record_and_url_for_news($isLink,$href,$target,$id,$title,$pageKey,$time,$cTarget,$mType,$mid,$mPageKey,$cid,$cPageKey,$shortNum)
{
	if($isLink == 1)
	{
		$href_ = $href;
		$target_ = $target;
	}
	else
	{
		$href_ = create_page_url_htaccess_or_not('detail',$mType,$mid,$mPageKey,$cid,$cPageKey,$id,$pageKey);
		$target_ = $cTarget;
	}

	echo '<a href="' . $href_ . '" target="' . $target_ . '">';
	if($shortNum > 0)
		echo shortStringCn($title,$shortNum);
	else
		echo $title;
	if($time != ''){echo '<span>' . $time . '</span>';}
	echo '</a>';
}

function replace_menu_type_key_to_name($key)
{
	$temp = $key;
	$temp = replace($temp,'articles','无子分类，多篇文章');
	$temp = replace($temp,'article','一篇文章');
	$temp = replace($temp,'news','有子分类，多篇文章');
	$temp = replace($temp,'pics','无子分类，多张图片');
	$temp = replace($temp,'album','有子分类，多张图片');
	$temp = replace($temp,'imgs','无子分类，多张纯图片');
	$temp = replace($temp,'photos','有子分类，多张纯图片');
	$temp = replace($temp,'links','友情链接');
	$temp = replace($temp,'link','外部链接');
	return $temp;
}

function get_member_level_name($rsOrLevel){
	if(is_array($rsOrLevel)){
		$level = $rsOrLevel['h_level'];
	}else{
		$level = $rsOrLevel;
	}
	$level = intval($level);
	$levelName = 'VIP';
	if($level > 0){
		$levelName = 'VIP' . $level;
	}

	return $levelName;
}

function get_member_level_span($rsOrLevel){
	if(is_array($rsOrLevel)){
		$level = $rsOrLevel['h_level'];
	}else{
		$level = $rsOrLevel;
	}
	$level = intval($level);
	if($level <= 0){
		$html = '<span class="label label-default">VIP</span>';
	}else{
		$html = '<span class="label label-danger">VIP' . $level . '</span>';
	}

	return $html;
}

function get_member_level_selector($selId,$rsOrLevel){
	if(is_array($rsOrLevel)){
		$level = $rsOrLevel['h_level'];
	}else{
		$level = $rsOrLevel;
	}
	$level = intval($level);
	
	$html = '<select name="' . $selId . '" id="' . $selId . '">';
	$html .= '<option value="">-=VIP等级=-</option>';
	for($ci = 0;$ci <= 4;$ci++){
		$html .= '<option value="' . $ci . '"';
		if($level == $ci){
			$html .= ' selected="selected"';
		}
		$html .= '>VIP';
		if($ci > 0){
			$html .= $ci;
		}
		$html .= '</option>';
	}
    $html .= '</select>';

	return $html;
}

//会员购买宠物时的提成，5级
/*
function bonus_farm_buy($buyUserName,$buyMoney,$currUserName,$floorIndex = 1){
	global $db;
	
	if($floorIndex > 5){
		return;
	}
	
	//奖金
	$bonus = floatval($buyMoney) * floatval($webInfo['h_point2Com' . $floorIndex]);
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$currUserName}'");
	//会员存在
	if($rs){
		//推荐人存在，结算给推荐人
		if(strlen($rs['h_parentUserName']) > 0){
			//奖金 > 0 才发放和记录
			if($bonus > 0){
				//加款
				$sql = "update `h_member` set ";
				$sql .= "h_point2 = h_point2 + ({$bonus}) ";
				$sql .= "where h_userName = '" . $rs['h_parentUserName'] . "' ";
				$db->query($sql);
				
				//记录
				$sql = "insert into `h_log_point2` set ";
				$sql .= "h_userName = '" . $rs['h_parentUserName'] . "', ";
				$sql .= "h_price = '" . $bonus . "', ";
				$sql .= "h_type = '宠物收益分红', ";
				$sql .= "h_about = '" . $rs_list['h_title'] . "，数量：" . $goodsIN[$rs_list['id']] . "', ";
				$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
				$sql .= "h_actIP = '" . getUserIP() . "' ";
				$db->query($sql);
			}
			
			//下一轮
			bonus_farm_buy($buyUserName,$buyMoney,$rs['h_parentUserName'],$floorIndex + 1);
		}
	}
}
*/

//结算会员的宠物产币
/*function settle_farm_day($userName){
	global $db;
	
	$bonusAll = 0;
	$now = date('Y-m-d H:i:s');
	
	$sql = "select *,DATEDIFF(sysdate(),h_lastSettleTime) as diffDaysS,DATEDIFF(sysdate(),h_addTime) as diffDaysA from `h_member_farm` where h_userName = '{$userName}' and h_isEnd = 0 and DATEDIFF(sysdate(),h_addTime) > 0 and (DATEDIFF(sysdate(),h_lastSettleTime) <> 0 or h_lastSettleTime is null)";
	$query = $db->query($sql);
	//遍历
	while($rs = $db->fetch_array($query)){
		//计算上次结算与今天的时间差（天数）
		//如果上次未结算，默认为购买时便已结算（虚拟）
		$dateDiffDay = $rs['diffDaysS'];
		if(is_null($dateDiffDay)){
			$dateDiffDay = $rs['diffDaysA'];
		}
		$dateDiffDay = intval($dateDiffDay);
		if($dateDiffDay <= 0){
			$dateDiffDay = intval($rs['diffDaysA']);
		}
		//echo $mustSettleDay , '|' ,  $rs['id'];
		//exit;
		if($dateDiffDay <= 0){
			continue;
		}
		
		//需要结算的天数
		//如果超出生存周期，最多是生存周期
		$mustSettleDay = $dateDiffDay;
		if(($mustSettleDay + $rs['h_settleLen']) > $rs['h_life']){
			$mustSettleDay = $rs['h_life'] - $rs['h_settleLen'];
		}
		
		
		if($mustSettleDay > 0){
			//是否死亡
			if(($mustSettleDay + $rs['h_settleLen']) >= $rs['h_life']){
				$isEnd = 1;
			}else{
				$isEnd = 0;
			}
			
			//需要结算的金币
			$mustSettleMoney = $mustSettleDay * intval($rs['h_point2Day']) * intval($rs['h_num']);
			
			//累加，最后一次性发放
			$bonusAll += $mustSettleMoney;
			
			//更新为已发放
			$sql = "update `h_member_farm` set h_settleLen = h_settleLen + ({$mustSettleDay}),h_lastSettleTime = '{$now}',h_isEnd = '{$isEnd}' where id = '{$rs['id']}'";
			$db->query($sql);
		}
	
		//echo $rs['h_lastSettleTime'] . '|';
		//echo $dateDiffDay . '|';
		//echo $mustSettleDay . '|';
		//echo $mustSettleMoney . '|';
		//echo $isEnd . '|';
		//echo '<br />';
	}
	
	//echo '总额：';
	//echo $bonusAll . '|';
	//echo '<br />';
	
	//一次性发放
	if($bonusAll > 0){
		//加款
		$sql = "update `h_member` set ";
		$sql .= "h_point2 = h_point2 + ({$bonusAll}) ";
		$sql .= "where h_userName = '" . $userName . "' ";
		$db->query($sql);
		
		//记录
		$sql = "insert into `h_log_point2` set ";
		$sql .= "h_userName = '" . $userName . "', ";
		$sql .= "h_price = '" . $bonusAll . "', ";
		$sql .= "h_type = '宠物收益', ";
		$sql .= "h_about = '登录，系统自动拾取宠物金币', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);
		
		//发放奖金
		bonus_farm_day($userName,$bonusAll,$userName);
	}
}*/
// function settle_farm_day_old($userName){
// 	global $db;
	
// 	$bonusAll = 0;
// 	$now = date('Y-m-d H:i:s');
	
// 	$sql = "select * from `h_member_farm` where h_userName = '{$userName}' and h_isEnd = 0 and timestampdiff(day,h_addTime,sysdate()) > 0 and (timestampdiff(day,h_lastSettleTime,sysdate()) <> 0 or h_lastSettleTime is null)";
// 	$query = $db->query($sql);
// 	//遍历
// 	while($rs = $db->fetch_array($query)){
// 		//计算上次结算与今天的时间差（天数）
// 		//如果上次未结算，默认为购买时便已结算（虚拟）
// 		if(is_null($rs['h_lastSettleTime'])){
// 			$rs['h_lastSettleTime'] = $rs['h_addTime'];
// 		}
// 		$dateDiffDay = FDateDiff0($rs['h_lastSettleTime'],time(),'d');
		
// 		//需要结算的天数
// 		//如果超出生存周期，最多是生存周期
// 		$mustSettleDay = $dateDiffDay - $rs['h_settleLen'];
// 		if(($mustSettleDay + $rs['h_settleLen']) > $rs['h_life']){
// 			$mustSettleDay = $rs['h_life'] - $rs['h_settleLen'];
// 		}
		
// 		if($mustSettleDay > 0){
// 			//是否死亡
// 			if(($mustSettleDay + $rs['h_settleLen']) >= $rs['h_life']){
// 				$isEnd = 1;
// 			}else{
// 				$isEnd = 0;
// 			}
			
// 			//需要结算的金币
// 			$mustSettleMoney = $mustSettleDay * intval($rs['h_point2Day']) * intval($rs['h_num']);
			
// 			//累加，最后一次性发放
// 			$bonusAll += $mustSettleMoney;
			
// 			//更新为已发放
// 			$sql = "update `h_member_farm` set h_settleLen = h_settleLen + ({$mustSettleDay}),h_lastSettleTime = '{$now}',h_isEnd = '{$isEnd}' where id = '{$rs['id']}'";
// 			$db->query($sql);
// 		}
	
// 		//echo $rs['h_lastSettleTime'] . '|';
// 		//echo $dateDiffDay . '|';
// 		//echo $mustSettleDay . '|';
// 		//echo $mustSettleMoney . '|';
// 		//echo $isEnd . '|';
// 		//echo '<br />';
// 	}
	
// 	//echo '总额：';
// 	//echo $bonusAll . '|';
// 	//echo '<br />';
	
// 	//一次性发放
// 	if($bonusAll > 0){
// 		//加款
// 		$sql = "update `h_member` set ";
// 		$sql .= "h_point2 = h_point2 + ({$bonusAll}) ";
// 		$sql .= "where h_userName = '" . $userName . "' ";
// 		$db->query($sql);
		
// 		//记录
// 		$sql = "insert into `h_log_point2` set ";
// 		$sql .= "h_userName = '" . $userName . "', ";
// 		$sql .= "h_price = '" . $bonusAll . "', ";
// 		$sql .= "h_type = '宠物收益', ";
// 		$sql .= "h_about = '登录，系统自动拾取宠物金币', ";
// 		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
// 		$sql .= "h_actIP = '" . getUserIP() . "' ";
// 		$db->query($sql);
		
// 		//发放奖金
// 		bonus_farm_day($userName,$bonusAll,$userName);
// 	}
// }
//会员宠物产币时的提成，5级
/*function bonus_farm_day($buyUserName,$bonusAll,$currUserName,$floorIndex = 1){
	global $db;
	global $webInfo;
	
	if($floorIndex > 5){
		return;
	}
	
	//奖金
	$bonus = floatval($bonusAll) * floatval($webInfo['h_point2Com' . $floorIndex]);
	
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$currUserName}'");
	//会员存在
	if($rs){
		//推荐人存在，结算给推荐人
		if(strlen($rs['h_parentUserName']) > 0){
			//奖金 > 0 才发放和记录
			if($bonus > 0){
				//加款
				$sql = "update `h_member` set ";
				$sql .= "h_point2 = h_point2 + ({$bonus}) ";
				$sql .= "where h_userName = '" . $rs['h_parentUserName'] . "' ";
				$db->query($sql);
				
				//记录
				$sql = "insert into `h_log_point2` set ";
				$sql .= "h_userName = '" . $rs['h_parentUserName'] . "', ";
				$sql .= "h_price = '" . $bonus . "', ";
				$sql .= "h_type = '宠物收益分红', ";
				$sql .= "h_about = '第" . $floorIndex . "代会员" . $buyUserName . "登录，系统自动拾取其宠物金币', ";
				$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
				$sql .= "h_actIP = '" . getUserIP() . "' ";
				$db->query($sql);
				//echo $sql . '<br />';
			}
			
			//下一轮
			bonus_farm_day($buyUserName,$bonusAll,$rs['h_parentUserName'],$floorIndex + 1);
		}
	}
}
*/
//检测其上家是否达到升级的条件
/*function member_chk_update_level($actParentMember){
	global $db;
	global $webInfo;
	
	$temp = false;
	
	$sql = "select *";
	$sql .= ",(select count(id) from `h_member` where h_parentUserName = a.h_userName and h_isPass = 1) as comMembers";
	$sql .= " from `h_member` a where h_userName = '{$actParentMember}' LIMIT 1";
	$rs = $db->get_one($sql);
	$upToLevel = 0;
	if($rs){
		for($ci = 1;$ci <= 4;$ci++){
			if($rs['comMembers'] >= $webInfo['h_levelUpTo' . $ci]){
				$upToLevel = $ci;
			}
		}
		
		if($upToLevel > $rs['h_level']){
			//需要升级
			$sql = "update `h_member` set ";
			$sql .= "h_level = {$upToLevel} ";
			$sql .= "where h_userName = '{$actParentMember}' ";
			$db->query($sql);
			
			$temp = true;
		}
	}
	
	return $temp;
}*/

//注册赠送种子
function bonus_member_reg($regUserName,$parentUserName,$umember){
	global $db;
	global $webInfo;


	if($webInfo['h_point2ComRegAct'] > 0){
		$bonus = $webInfo['h_point2ComRegAct'];
		
		//推荐人消耗LM
		$rs = $db->get_one("select * from `h_member` where h_userName = '{$umember}'");
		$money = $rs['h_point2'] - $bonus ;
		if($money < 0){
			exit;
		}else{
			$sql = "update `h_member` set ";
			$sql .= "h_point2 = h_point2 - ({$bonus}) ";
			$sql .= "where h_userName = '" . $umember . "' ";
			$bIsSuccess = $db->query($sql);
			if($bIsSuccess){
				//如果扣除成功 则把注册时多出的30kk平均到系统的十个账户上
				$aSystemUsers = array('\'1389326488\'', '\'1458479322\'', '\'1587243299\'', '\'1896478882\'', '\'1386532522\'', '\'1326588288\'', '\'1876589732\'', '\'1586589588\'', '\'1685689288\'', '\'1698752838\'',);

				$fSystemMoney = floatval(($bonus - 300)/count($aSystemUsers));
				if($fSystemMoney > 0){
					$sAllNumber = implode(',', $aSystemUsers);
					$sql = "update h_member set h_point2 = h_point2 + {$fSystemMoney} where h_userName in ({$sAllNumber})";
					$db->query($sAllNumber);
				}
			}
		}
		

		//推荐人消耗LM记录
		$sql = "insert into `h_log_point2` set ";
		$sql .= "h_userName = '" . $umember . "', ";
		$sql .= "h_price = '-" . $bonus . "', ";
		$sql .= "h_type = '开通新用户', ";
		$sql .= "h_type_id = '6', ";
		$sql .= "h_about = '开通新用户(" . $regUserName . "),消耗".$bonus."LM ',";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "', ";
		$sql .= "h_account = '" . getaccount($umember) . "' ";
		$db->query($sql);
		//echo $sql . '<br />';
	}


	if($webInfo['h_point2ComReg'] > 0){
		$bonus = $webInfo['h_point2ComReg'];

		//推荐人加种子
		$sql = "update `h_member` set ";
		$sql .= "h_point1 = h_point1 + ({$bonus}) ";
		$sql .= "where h_userName = '" . $parentUserName . "' ";
		$db->query($sql);

		//推荐人加种子记录
		$sql = "insert into `h_log_point1` set ";
		$sql .= "h_userName = '" . $parentUserName . "', ";
		$sql .= "h_price ='" . $bonus . "', ";
		$sql .= "h_type = '直推奖', ";
		$sql .= "h_type_id = '1', ";
		$sql .= "h_about = '推荐会员(" . $regUserName . ")注册,获取".$bonus."个种子 ',";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);
	}
	

	if($webInfo['h_point2ComRegAct2'] > 0){
		$bonus = $webInfo['h_point2ComRegAct2'];
		
		//新用户注册奖励LM
		$sql = "update `h_member` set ";
		$sql .= "h_point2 = h_point2 + ({$bonus}) ";
		$sql .= "where h_userName = '" . $regUserName . "' ";
		$db->query($sql);


		//新用户注册奖励LM记录
		$sql = "insert into `h_log_point2` set ";
		$sql .= "h_userName = '" . $regUserName . "', ";
		$sql .= "h_price = '" . $bonus . "', ";
		$sql .= "h_type = '新用户注册', ";
		$sql .= "h_type_id = '7', ";
		$sql .= "h_about = '新用户注册奖励" . $bonus . "LM', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "', ";
		$sql .= "h_account = '" . getaccount($regUserName) . "' ";
		$db->query($sql);

	}


}




/*每推荐10个送一个丘比特，最多送4个*/
function invitadd($UserName){
	global $db;
	$status=0;

    /*邀请人数加1*/
	$sql  = "update `h_member` set ";
	$sql .= "invitnum = invitnum + 1 ";
	$sql .= "where h_userName = '" . $UserName . "' ";
	$db->query($sql);

	$result = $db->get_one("select * from `h_member` where h_userName = '{$UserName}'");

	$result2 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 2 and h_price= {$result['invitnum']}");
	if($result['invitnum'] == 10  && empty($result2)){
			
			$sql3  = "update `h_member` set bogy = bogy + 1  where h_userName = '{$UserName}' ";
			$db->query($sql3);
			$status=1;

	}else if($result['invitnum'] == 20 && empty($result2)){
		
			$sql3  = "update `h_member` set bogy = bogy + 1  where h_userName = '" . $UserName . "' ";
			$db->query($sql3);
			$status=2;
		
	}else if($result['invitnum'] == 30 && empty($result2)){
		
			$sql3  = "update `h_member` set bogy = bogy + 1  where h_userName = '" . $UserName . "' ";
			$db->query($sql3);
			$status=3;
		
	}else if($result['invitnum'] == 40 && empty($result2)){
		
			$sql3  = "update `h_member` set ";
			$sql3 .= "bogy = bogy + 1 ";
			$sql3 .= "where h_userName = '" . $UserName . "' ";
			$db->query($sql3);
			$status=4;
	
	}

	if($status){

		//直推奖记录
		$sql = "insert into `h_log_animal` set ";
		$sql .= "h_userName = '" . $UserName . "', ";
		$sql .= "h_price ='".$result['invitnum']."', ";
		$sql .= "h_type = '奖励花仙子', ";
		$sql .= "h_about = '每推荐10个送一个花仙子',";
		$sql .= "h_type_id = '2', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);

	}


}

/*花仙子判断是否已经奖励过*/
function isaward2($UserName,$num)
{
	global $db;

	$result3 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 1 and h_price= {$num}");
	if(count($result3)>0){
			return false;
	}else{
			return true;
	}
}

/*判断LM每达到5w 和 15w 获取一条花仙子*/
function isflowerfairy($UserName){
	global $db;
	$status=0;
	$land_now = 0;

	$result = $db->get_one("select * from `h_member` where h_userName = '{$UserName}'");

	$query = "select * from `h_member_farm` where h_userName = '{$UserName}' and h_isEnd = 0";
	$rs = $db->query($query);
	
	while($list = $db->fetch_array($rs))
	{
		$rs3[]=$list;
	}
	if(count($rs3) > 0)
	{
		foreach ($rs3 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			
			  for($a = 0; $a < count($h_harvest); $a++)
			  {
			    $land_now = $land_now + intval($h_harvest[$a]);
			  }
		  }
		  else
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			  
		    for($a = 0; $a < count($h_harvest); $a++)
			{
			  $land_now = $land_now + intval($h_harvest[$a]);
			}
		  }
		}
	}

    $total =  $result['h_point2']+$land_now;

	if($total >= 50000 && $total < 150000  ){

			$result2 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 1 and h_price=50000 ");
			if(empty($result2)){
				$sql3  = "update `h_member` set ";
				$sql3 .= "dog = dog + 1 ";
				$sql3 .= "where h_userName = '" . $UserName . "' ";
				$db->query($sql3);

				$status=1;
				$h_price =50000;
			}
			
		
	}else if($total >= 150000  && empty($result2)){
			$result2 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 1 and h_price=150000 ");
			if(empty($result2)){
				$sql3  = "update `h_member` set ";
				$sql3 .= "dog = dog + 1 ";
				$sql3 .= "where h_userName = '" . $UserName . "' ";
				$db->query($sql3);

				$status=2;
				$h_price =150000;
			}
	}

	if($status){

		//推荐人加种子记录
		$sql = "insert into `h_log_animal` set ";
		$sql .= "h_userName = '" . $UserName . "', ";
		$sql .= "h_price ='".$h_price."', ";
		$sql .= "h_type = '奖励花仙子', ";
		$sql .= "h_about = '每达到5w 和 15w 获取一个花仙子',";
		$sql .= "h_type_id = '1', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);

	}


}



function detail($UserName,$title,$about,$bonus){

		global $db;
		$sql = "insert into `h_log_point2` set ";
		$sql .= "h_userName = '" . $UserName . "', ";
		$sql .= "h_price = '-" . $bonus . "', ";
		$sql .= "h_type = '".$title."', ";
		$sql .= "h_about = '".$about."', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$sql .= "h_account = '" . getaccount($UserName) . "' ";
		$db->query($sql);
}


function getpoint2($username){
	global $db;

	 $sql  = "select * from  `h_member`  where  h_userName = '" . $username . "' ";
	 $result=$db ->query($sql);
	 echo  $result[0]['h_point2'];
}

/*增加初始化农场*/
function addfarm($username,$pid){
	global $db;
	//增加宠物
		$land = "";
		$harvest = "";
		$time = "";
		if($pid == "112")
		{
		    $land = "0,0,0,0,0,0,0,0,0,0";
			$harvest = $land;
			$time = "0|0|0|0|0|0|0|0|0|0";
		}
		else
		{
			$land = "0,0,0,0,0";
			$harvest = $land;
			$time = "0|0|0|0|0";
		}
		$sql = "select * from `h_member_farm` where h_userName = '".$username."' and h_pid = '".$pid."'";
		$yon = $db->query($sql);
		$fm;
		while($list1 = $db->fetch_array($yon))
		{
			$fm[]=$list1;
		}
		if(count($fm) == 0)
		{

			$query = "select * from `h_farm_shop` where id in ({$pid})";
			$result = $db->query($query);
			if(empty($result)){
				echo '未找到任何商品';
				exit;
			}

			while($rs_list = $db->fetch_array($result)){

				$sql = "insert into `h_member_farm` set ";
				$sql .= "h_userName = '" . $username . "', ";
				$sql .= "h_pid = '" . $pid . "', ";
				$sql .= "h_land = '" . $land . "', ";
				$sql .= "h_harvest = '" . $harvest . "', ";
				$sql .= "h_h_time = '" . $time . "', ";
				$sql .= "h_addTime = '" . date('Y-m-d') . "', ";
				$sql .= "h_endTime = '" . date('Y-m-d',strtotime('+' . ($rs_list['h_life'] + 1) . ' day')) . "', ";
				$sql .= "h_lastSettleTime = NULL, ";
				$sql .= "h_settleLen = '0', ";
				$sql .= "h_isEnd = '0', ";
				$sql .= "h_title = '" . $rs_list['h_title'] . "', ";
				$sql .= "h_pic = '" . $rs_list['h_pic'] . "', ";
				$sql .= "h_point2Day = '" . $rs_list['h_point2Day'] . "', ";
				$sql .= "h_life = '" . $rs_list['h_life'] . "', ";
				$sql .= "h_money = '" . $rs_list['h_money'] . "' ";
			}

			$db->query($sql);
		}
		
}


/*采蜜*/
function getusebee($username,$pusername,$money, $level = 1)
{
	global $db;
	
    	

		//好友采蜜奖励记录
		$sql2 = "insert into `h_usebee` set ";
		$sql2 .= "h_username = '" . $pusername . "', ";
		$sql2 .= "h_fusername = '" . $username . "', ";
		$sql2 .= "h_price = '" . $money . "', ";
		$sql2 .= "h_level = " . $level . ", ";
		$sql2 .= "h_addTime = '" . date('Y-m-d H:i:s') . "'";

		$db->query($sql2);
}

function writeLog($message){
	$message = 'time: ' . date('Y-m-d H:i:s') . '|' . $message;
	file_put_contents('/home/www/keke.kekejiayuan.com/web/keke.log_' . date('Y-m-d'), $message . PHP_EOL, FILE_APPEND);
}

function controlFrequency($member_name){
	if(empty($member_name)){
		return;
	}
	//进行访问频率控制
	if(extension_loaded('redis')){
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		if(isset($_SERVER['REQUEST_URI'])){
			//对访问的接口进行频率控制
			$sKey = str_replace('/', '#', $_SERVER['REQUEST_URI']);
			$sKey .= '#' . $member_name;
			$redis->multi();
			$iNow = $redis->incr($sKey);
			$redis->expire($sKey, 5);
			$aRes = $redis->exec();
			$iNow = intval($aRes[0]);
			if($iNow == 1){
				/*void do nothing*/
			}else{
				$m_user_ip = getUserIP();
				writeLog("{$sKey} faces {$m_user_ip}|{$member_name} frequency attack!");
				exit('请求正在处理，请耐心等待...');
			}
		}
	}
}

function get_farm_money($username){
	if(empty($username)){
		return 0;
	}

	global $db;
	$query = "select * from `h_member_farm` where h_userName = '{$username}' and h_isEnd = 0";
	$result = $db->query($query);
	
	$rs3 = [];
	while($list = $db->fetch_array($result)){
		$rs3[]=$list;
	}

	$land_now = 0;
	if(count($rs3) > 0)
	{
		foreach ($rs3 as $key=>$val)
		{
		  if($val['h_pid'] == "112")
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			
			  for($a = 0; $a < count($h_harvest); $a++)
			  {
			    $land_now = $land_now + $h_harvest[$a];
			  }
		  }
		  else
		  {
			$h_harvest = explode(",",$val['h_harvest']);
			  
		    for($a = 0; $a < count($h_harvest); $a++)
			{
			  $land_now = $land_now + $h_harvest[$a];
			}
		  }
		}
	}

	return floatval($land_now);
}


function get_growth_rate($username){
	global $db;
	global $webInfo;

	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	//会员存在
	if($rs){
		$dog = $rs['dog'];
		$bogy = $rs['bogy'];//花仙子
		$days=date("Y-m-d",time());
		$rs2 = $db->get_one("select  *  from h_growth_rate where DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = '".$days."'");
		$land_info_common = $db->get_one("select * from `h_member_farm` where h_userName = '{$username}' and h_pid = '112'");
		$land_info_gold   = $db->get_one("select * from `h_member_farm` where h_userName = '{$username}' and h_pid = '113'");

		$aCommonLandInfo = explode(',', $land_info_common['h_land']);
		$aGoldLandInfo   = explode(',', $land_info_gold['h_land']);

		$iCommonLandNums = 0;
		$iGoldLandNums   = 0;
		foreach($aCommonLandInfo as $iIsUse){
			if(intval(trim($iIsUse))){
				++$iCommonLandNums;
			}
		}

		foreach($aGoldLandInfo as $iIsUse){
			if(intval(trim($iIsUse))){
				++$iGoldLandNums;
			}
		}

		if($rs2){
			//种植第二块普通地拆分增加0.02%
			//种植第二块金土地拆分增加0.04%
			//每推荐10个人可获得一个花仙子，增加拆分0.1%
			$h_bogy_add   = $bogy * 0.1;
			if($iCommonLandNums >=1 ){
				$h_common_add = ($iCommonLandNums - 1)*0.02;
			}

			if($iGoldLandNums >=1 ){
				$h_gold_add   = ($iGoldLandNums   - 1)*0.04;
			}
			

			$h_growth_rate   = ($rs2['rate'] + $h_bogy_add + $h_common_add + $h_gold_add)*0.01;
			$rate = $h_growth_rate - (4-$bogy)*0.001 + $dog*0.0005;
		}else{
			$rate = 0;
		}

		return $rate;
	}else{
		return false;
	}

}
//激活会员时，其上家得到奖励
/*function bonus_member_act($regUserName,$parentUserName){
	global $db;
	global $webInfo;
	
	if($webInfo['h_point2ComRegAct'] > 0){
		$bonus = $webInfo['h_point2ComRegAct'];
		
		//加款
		$sql = "update `h_member` set ";
		$sql .= "h_point2 = h_point2 + ({$bonus}) ";
		$sql .= "where h_userName = '" . $parentUserName . "' ";
		$db->query($sql);
		
		//记录
		$sql = "insert into `h_log_point2` set ";
		$sql .= "h_userName = '" . $parentUserName . "', ";
		$sql .= "h_price = '" . $bonus . "', ";
		$sql .= "h_type = '直荐激活奖', ";
		$sql .= "h_about = '直接推荐的会员" . $regUserName . "激活', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);
		//echo $sql . '<br />';
	}
}*/

/*判断开满地*/
function isfull($username){
	global $db;
	$rs = $db->get_one("select * from `h_member_farm` where h_userName = '{$username}' and h_pid=112 and h_land='1,1,1,1,1,1,1,1,1,1' ");
	$rs2 = $db->get_one("select * from `h_member_farm` where h_userName = '{$username}' and h_pid=113 and h_land='1,1,1,1,1' ");
	if($rs && $rs2){
		return true;
	}else{
		return false;
	}
}


/*获取蜂蜜*/
function getfengmi($username){
	global $db;
	$query = "select * from `h_member` where h_parentUserName = '{$username}' or h_secondParentUserName = '{$username}'";
	$result = $db->query($query);
	while($list = $db->fetch_array($result))
	{
		$rs_list[]=$list;
	}

	if(count($rs_list) > 0)
	{	
		$fengmi =0;
		foreach ($rs_list as $key=>$val)
		{
			/*是否施肥*/
			$days=date("Y-m-d",time());
			$query = "select   sum(h_price) as num   from  `h_log_point2`  where  h_userName = '{$val['h_userName']}' and h_type_id =4 and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs = $db->get_one($query);

			/*是否采蜜*/
			$query = "select * from  `h_usebee`  where  h_fusername = '{$val['h_userName']}'  and  DATE_FORMAT(FROM_UNIXTIME(unix_timestamp(h_addTime)),'%Y-%m-%d') = '".$days."'";
			$rs2 = $db->get_one($query);
			if($rs['num']  &&  !$rs2){ 
				$fengmi =$fengmi+$rs['num'];
			}
		}
		return $fengmi;
	}
}



/*判断是否有LM*/
function  havejinbi($username,$num){
	global $db;
	$query = "select * from `h_member` where h_parentUserName = '{$username}' ";
	$result = $db->get_one($query);
	if($result){
		if($result['h_point2'] < $num){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}



/*判断生长率和采蜜是否达到5w或15w获取一条花仙子 */
function isflowerfairy2($UserName){
	global $db;

	$rs1 =   $db ->get_one("select  sum(h_price) as num1  from  `h_log_point2`  where  h_userName = '{$UserName}' and h_type_id= 4 ");
	$num1 = $rs1['num1'];
    $total =  $num1 ;

	if($total >= 50000 && $total < 150000  ){
			$result2 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 1 and h_price=50000 ");
			if(empty($result2)){
				$sql3  = "update `h_member` set ";
				$sql3 .= "dog = dog + 1 ";
				$sql3 .= "where h_userName = '" . $UserName . "' ";
				$db->query($sql3);

				$status=1;
				$h_price =50000;
			}
				
	}else if($total >= 150000){
			$result2 = $db ->get_one("select *  from  `h_log_animal`  where  h_userName = '{$UserName}' and h_type_id= 1 and h_price=150000 ");
			if(empty($result2)){
				$sql3  = "update `h_member` set ";
				$sql3 .= "dog = dog + 1 ";
				$sql3 .= "where h_userName = '" . $UserName . "' ";
				$db->query($sql3);

				$status=2;
				$h_price =150000;
			}
	}

	if($status){

		//推荐人加种子记录
		$sql = "insert into `h_log_animal` set ";
		$sql .= "h_userName = '" . $UserName . "', ";
		$sql .= "h_price ='".$h_price."', ";
		$sql .= "h_type = '奖励花仙子', ";
		$sql .= "h_about = '每达到5w 和 15w 获取一个花仙子',";
		$sql .= "h_type_id = '1', ";
		$sql .= "h_addTime = '" . date('Y-m-d H:i:s') . "', ";
		$sql .= "h_actIP = '" . getUserIP() . "' ";
		$db->query($sql);

	}
}



/*查找账户余额*/

function  getaccount($username){
	global $db;
	$rs = $db->get_one("select * from `h_member` where h_userName = '{$username}'");
	//会员存在
	if($rs){
		return  $rs['h_point2'];
	}else{
		return false;
	}
}



function getlandmoney($username){
		global $db;

		$query = "select * from `h_member_farm` where h_userName = '{$username}' ";
		$result = $db->query($query);

		while($list = $db->fetch_array($result))
		{
			$rs2[]=$list;
		}
		if(count($rs2) > 0)
		{
			foreach ($rs2 as $key=>$val)
			{		  
			  if($val['h_pid'] == '112')
			  {
			    $land1 = explode(",",$val['h_land']);
				$harvest1 = explode(",",$val['h_harvest']);
				$time1 = explode("|",$val['h_h_time']);
				
				for($a = 0; $a < count($land1); $a++)
				{
				  if($land1[$a] == "1")
				  {
				    $zero1=strtotime(date("y-m-d h:i:s")); //当前时间
			        $zero2=strtotime($time1[$a]);
			        $days=floor(($zero1 - $zero2)/86400);
			      
			        	$days=1;
			          	$money_now = $money_now + $harvest1[$a];

			        $time1[$a] = date('Y-m-d')." 00:00:00";
			        

				  }
				}

				if(intval($farmid) < 11)
				{
				  $h_harvest = explode(",",$val['h_harvest']);
			      $land_money = $h_harvest[intval($farmid)-1];
				  $pid = "112";
			    }


			  }
			  else
			  { 
			    $land2 = explode(",",$val['h_land']);
				$harvest2 = explode(",",$val['h_harvest']);
				$time2 = explode("|",$val['h_h_time']);

				for($a = 0; $a < count($land2); $a++)
				{
				  if($land2[$a] == "1")
				  {
				    $zero1=strtotime(date("y-m-d h:i:s")); //当前时间
			        $zero2=strtotime($time2[$a]);
			        $days=floor(($zero1 - $zero2)/86400);
					
			        	$days=1;
			        	$money_now = $money_now + $harvest2[$a];
			        /* echo "<br>";*/
			        $time2[$a] = date('Y-m-d')." 00:00:00";			  
			      }
				}

				if(intval($farmid) == 11 || intval($farmid) > 11)
				{
				  $h_harvest = explode(",",$val['h_harvest']);
			      $land_money = $h_harvest[intval($farmid)-11];
				  $pid = "113";
				}

				
			  }
			}


			return $money_now;
		}
}



function getallbee($username){
	global $db;

	/*采蜜*/
	$growth_total=0;

	$query2 = "select sum(h_price) as total from h_usebee where h_userName = '{$username}' ";
	$rs2 = $db->get_one($query2);
	if($rs2){
		if(!empty($rs2['total'])){
			$growth_total =  $growth_total  + $rs2['total'];
		}
	}

	return $growth_total;
}


function getallgrowth($username){
	global $db;
	/*采蜜*/
	$growth_total = 0;

	$query = "select sum(h_price) as total from h_log_point2 where h_userName = '{$username}' and  h_type_id=4";
	$rs = $db->get_one($query);
	if($rs){
		if(!empty($rs['total'])){
			$growth_total = $rs['total'];
		}	
	}
	return $growth_total;
}
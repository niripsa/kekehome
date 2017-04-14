<?php
require_once 'header.php';

require_once '../include/pager.php';

require_once 'chkMenuId.php';

if($mid == 46){
	$picBigWidth = 1431;
	$picBigHeight = 372;
	
	$picBigNWidth = 1431;
	$picBigNHeight = 372;
}

$admin_article_page_config = array
(
	"menu"=>array
	(
		"add"=>"添加","list"=>"列表"
	)
	,
	"config"=>array
	(
		"dbTable"=>"h_category","keyName"=>"分类","listNum"=>15,"recordAddBack"=>"addinfo","recordEditBack"=>"","defaultFun"=>"main();"
	)
	,
	"list"=>array
	(
		"h_title"=>array
		(
			"title"=>"分类名称","type"=>"string","width"=>"30%","align"=>"center"
		)
		,
		"order"=>array
		(
			"title"=>"排序","width"=>"15%","align"=>"center"
		)
		,
		"action"=>array
		(
			"title"=>"相关操作","width"=>"15%","align"=>"center",
			"action"=>array
			(
				"edit"=>"修改","delete"=>"删除"
			)
		)
	)
	,
	"record"=>array
	(
		"hidden"=>array
		(
			"h_addTime"=>"{now}"
		)
		,
		"h_title"=>array
		(
			"title"=>"分类名称","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_picBig"=>array
		(
			"title"=>"展示图","control"=>"text","required"=>1,"tips"=>"规格：{$picBigWidth}×{$picBigHeight}",
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
	)
);

require_once 'inc_db_field_fun.php';

require_once 'footer.php';
?>
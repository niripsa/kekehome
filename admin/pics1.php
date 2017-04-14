<?php
require_once 'header.php';

require_once '../include/pager.php';

require_once 'chkMenuId.php';

$admin_article_page_config = array
(
	"menu"=>array
	(
		"add"=>"添加","list"=>"列表"
	)
	,
	"config"=>array
	(
		"dbTable"=>"h_farm_shop","keyName"=>"图片","listNum"=>10,"recordAddBack"=>"addinfo","recordEditBack"=>"","defaultFun"=>"main();",
		"whereKK"=>false,
		"orderBy"=>'h_minMemberLevel asc,id asc',
	)
	,
	"list"=>array
	(
		"h_pic"=>array
		(
			"title"=>"图片","type"=>"string","width"=>"15%","align"=>"center","picHeight"=>"100"
		)
		,
		"h_title"=>array
		(
			"title"=>"标题","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_point2Day"=>array
		(
			"title"=>"每天生产KK","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_life"=>array
		(
			"title"=>"生命周期","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_money"=>array
		(
			"title"=>"售价","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_minMemberLevel"=>array
		(
			"title"=>"要求会员等级","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_dayBuyMaxNum"=>array
		(
			"title"=>"每天限购","type"=>"string","width"=>"","align"=>"center"
		)
		,
		"h_alKKaxNum"=>array
		(
			"title"=>"庄园最大存在","type"=>"string","width"=>"","align"=>"center"
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
			"title"=>"标题","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_pic"=>array
		(
			"title"=>"展示图","control"=>"text","required"=>1,"tips"=>"",
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_point2Day"=>array
		(
			"title"=>"每天生产","control"=>"text","required"=>1,"tips"=>" KK",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
		,
		"h_life"=>array
		(
			"title"=>"生命周期","control"=>"text","required"=>1,"tips"=>" 天",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
		,
		"h_money"=>array
		(
			"title"=>"售价","control"=>"text","required"=>1,"tips"=>" KK",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
		,
		"h_minMemberLevel"=>array
		(
			"title"=>"要求会员等级","control"=>"text","required"=>1,"tips"=>"",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
		,
		"h_dayBuyMaxNum"=>array
		(
			"title"=>"每天限购","control"=>"text","required"=>1,"tips"=>" 只",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
		,
		"h_alKKaxNum"=>array
		(
			"title"=>"庄园最大存在","control"=>"text","required"=>1,"tips"=>" 只",
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"8"
			)
		)
	)
);

require_once 'inc_db_field_fun.php';

require_once 'footer.php';
?>
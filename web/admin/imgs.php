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
		"dbTable"=>"h_article","keyName"=>"图片","listNum"=>10,"recordAddBack"=>"addinfo","recordEditBack"=>"","defaultFun"=>"main();"
	)
	,
	"list"=>array
	(
		"h_picBig"=>array
		(
			"title"=>"图片","type"=>"string","width"=>"15%","align"=>"center"
		)
		,
		"h_title"=>array
		(
			"title"=>"标题","type"=>"string","width"=>"","align"=>"left"
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
			"title"=>"标题","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_picBig"=>array
		(
			"title"=>"图片","control"=>"text","required"=>1,"tips"=>"规格：{$picBigWidth}×{$picBigHeight}",
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_href"=>array
		(
			"title"=>"链接地址","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250","value"=>"http://"
			)
		)
	)
);

require_once 'inc_db_field_fun.php';

require_once 'footer.php';
?>
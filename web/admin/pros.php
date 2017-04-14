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
		"h_picSmall"=>array
		(
			"title"=>"图片","type"=>"string","width"=>"15%","align"=>"center"
		)
		,
		"OTFV"=>array
		(
			"title"=>"分类","width"=>"20%","align"=>"center",
			"field"=>"categoryTitle",
			"sql"=>"select h_title from `h_category` where id = a.h_categoryId"
		)
		,
		"h_title|h_hyj|h_kc|h_isPass"=>array
		(
			"title"=>"标题","type"=>"string","width"=>"","align"=>"left",
			"shtmls"=>array('','会员价：','库存：','状态：'),
			"case"=>array('','','',array('1'=>'上架，正常销售','0'=>'<font color="#ff0000">下架</font>'))
		)
		,
		"h_addTime"=>array
		(
			"title"=>"添加时间","type"=>"string","width"=>"15%","align"=>"center"
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
		"h_categoryId"=>array
		(
			"title"=>"所属分类","control"=>"select","required"=>1,
			"attr"=>array
			(
				
			)
		)
		,
		"h_addTime"=>array
		(
			"title"=>"发布时间","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass1","maxlength"=>"30","value"=>"{now}"
			)
		)
		,
		"h_picBig"=>array
		(
			"title"=>"大图","control"=>"text","required"=>1,"tips"=>"规格：{$picBigWidth}×{$picBigHeight}",
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_picSmall"=>array
		(
			"title"=>"小图","control"=>"text","required"=>1,"tips"=>"规格：{$picSmallWidth}×{$picSmallHeight}",
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"250"
			)
		)
		,
		"h_isPass"=>array
		(
			"title"=>"上架状态","control"=>"radio","required"=>1,
			"list"=>array
			(
				"1"=>"上架销售",
				"0"=>"下架",
			)
		)
		,
		"h_kc"=>array
		(
			"title"=>"库存","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"5"
			)
		)
		,
		"h_pm"=>array
		(
			"title"=>"品名","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_pfwz"=>array
		(
			"title"=>"排放位置","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_cz"=>array
		(
			"title"=>"材质","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_gy"=>array
		(
			"title"=>"工艺","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_ys"=>array
		(
			"title"=>"颜色","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_mz"=>array
		(
			"title"=>"毛重","control"=>"text","required"=>1,
			"attr"=>array
			(
				"class"=>"inputclass2","maxlength"=>"30"
			)
		)
		,
		"h_lsj"=>array
		(
			"title"=>"零售价","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		,
		"h_hyj"=>array
		(
			"title"=>"会员价","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		,
		"h_tc1"=>array
		(
			"title"=>"推荐购买提成","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		/*
		,
		"h_tc1"=>array
		(
			"title"=>"1级提成(直荐)","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		,
		"h_tc2"=>array
		(
			"title"=>"2级提成","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		,
		"h_tc3"=>array
		(
			"title"=>"3级提成","control"=>"text","required"=>1,"tips"=>' 元',
			"attr"=>array
			(
				"class"=>"inputclass3","maxlength"=>"12"
			)
		)
		*/
		,
		"h_keyword"=>array
		(
			"title"=>"页面关键字","control"=>"textarea","required"=>0,
			"attr"=>array
			(
				"class"=>"textareaclass5"
			)
		)
		,
		"h_description"=>array
		(
			"title"=>"页面介绍","control"=>"textarea","required"=>0,
			"attr"=>array
			(
				"class"=>"textareaclass5"
			)
		)
		,
		"h_info"=>array
		(
			"title"=>"内容","control"=>"fckeditor","required"=>0,
			"attr"=>array
			(
				"Height"=>400,"ToolbarSet"=>"Default"
			)
		)
	)
);

require_once 'inc_db_field_fun.php';

require_once 'footer.php';
?>
//取得id的obj
function $$$()
{
	if(typeof(arguments[0]) == "string")
	{
		return document.getElementById?document.getElementById(arguments[0]):eval(arguments[0]);
	}
	else
	{
		return arguments[0];
	}
}

//询问对话框
function hintandturn(str,url,torf)
{
	if(confirm(str) && torf){
		window.location=url;
		return true;
	}else{
		return false;
	}
}

//提交按钮不可用，防重复点击
function submitBtnDis(o,v)
{
	var subBtn = $$$(o);
	subBtn.disabled = true;
	subBtn.value = v;
	return true;
}

//选择所有复选框
function CheckAll(FormName,CheckboxName,chkAllName){
  for (var i=0;i<eval("document." + FormName + "." + CheckboxName + ".length");i++){
		var e = eval("document." + FormName + "." + CheckboxName + "[" + i + "]");
		if (e.Name != chkAllName){
			e.checked = eval("document." + FormName + "." + chkAllName + ".checked");
		}
    }
}
function UnSelectAll(FormName,chkAllName){
    eval("document." + FormName + "." + chkAllName + ".checked=1")	
}

/*子菜单*/
function menuFix(){
	$("#head .menu ul li").mouseover(function(){
		$(this).children("ul").css("display","block");
	}).mouseout(function(){
		$(this).children("ul").css("display","none");
	});
}

/*后台登录页面验证输入*/
function chkAdminLoginForm(){
	if ($$$("loginName").value==""){alert("请输入帐号！");$$$("loginName").focus();return false;}
	if ($$$("loginPwd").value==""){alert("请输入密码！");$$$("loginPwd").focus();return false;}
	if ($$$("code").value==""){alert("请输入验证码！");$$$("code").focus();return false;}
	return true;
}

/*获取拼音*/
function getPinYin(id,cn)
{
	if(cn == ""){alert("抱歉，空字符无法转换！");return;}
	$.ajax({
        url: '/ajax/getPinyin.php?rnd='+(new Date()),
        data:'cn='+stringJoinBars(cn),
        type: 'POST',
		async: true,
		dataType: 'json',
		success: function(json) {
			if(json.success)
			{
				$("#" + id).val(json.pinyin);
			}
			else
			{
				alert("抱歉，转换失败，请重试！");
			}
		}
	});	
}
function replaceAll(s1,s2,s3){var r=new RegExp(s2.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"ig");return s1.replace(r,s3);}
function isChinese(str){if(escape(str).indexOf("%u")!=-1){return true;}return false;}
function replacePunctuation(istr){
	var str = replaceAll(istr,"~","");
	str = replaceAll(str,"!","");
	str = replaceAll(str,"@","");
	str = replaceAll(str,"#","");
	str = replaceAll(str,"$","");
	str = replaceAll(str,"%","");
	str = replaceAll(str,"^","");
	str = replaceAll(str,"&","");
	str = replaceAll(str,"*","");
	str = replaceAll(str,"(","");
	str = replaceAll(str,")","");
	str = replaceAll(str,"_","");
	str = replaceAll(str,"+","");
	str = replaceAll(str,"{","");
	str = replaceAll(str,"}","");
	str = replaceAll(str,":","");
	str = replaceAll(str,"\"","");
	str = replaceAll(str,"|","");
	str = replaceAll(str,"<","");
	str = replaceAll(str,">","");
	str = replaceAll(str,"?","");
	str = replaceAll(str,"-","");
	str = replaceAll(str,"=","");
	str = replaceAll(str,"[","");
	str = replaceAll(str,"]","");
	str = replaceAll(str,";","");	
	str = replaceAll(str,"'","");
	str = replaceAll(str,"\\","");
	str = replaceAll(str,",","");
	str = replaceAll(str,".","");
	str = replaceAll(str,"/","");
	str = replaceAll(str,"！","");
	str = replaceAll(str,"·","");
	str = replaceAll(str,"￥","");
	str = replaceAll(str,"…","");
	str = replaceAll(str,"—","");
	str = replaceAll(str,"：","");
	str = replaceAll(str,"；","");
	str = replaceAll(str,"“","");
	str = replaceAll(str,"”","");
	str = replaceAll(str,"，","");
	str = replaceAll(str,"、","");
	str = replaceAll(str,"《","");
	str = replaceAll(str,"》","");
	str = replaceAll(str,"？","");
	str = replaceAll(str,"，","");
	str = replaceAll(str,"。","");
	str = replaceAll(str," ","-");
	return str;
}
function stringJoinBars(istr)
{
	var str = replacePunctuation(istr);
	
	var arr = str.split("");
	var endStr = "";
	var tStr;
	for(var i = 0;i < arr.length;i++)
	{
		if(isChinese(arr[i])){tStr = "-" + arr[i] + "-";}else{tStr = arr[i];}
		endStr += tStr;
	}
	while(endStr.indexOf("--") >= 0)
	{
		endStr = replaceAll(endStr,"--","-");
	}

	if(endStr.charAt(0) == "-"){endStr = endStr.substring(1, endStr.length);}
	if(endStr.charAt(endStr.length - 1) == "-"){endStr = endStr.substring(0, endStr.length - 1);}

	return endStr 
}

//文件按等比重置宽高度。使用例子：<img src="..." onload='imgSizeReSet(this,120,120);'>
function imgSizeReSet(ImgD,w,h) {
	var maxWidth = w;
	var maxHeight = h;
	var image = new Image();
	image.src = ImgD.src;
	if (image.width > 0 && image.height > 0) {
		if (image.width / image.height >= maxWidth / maxHeight) {
			if (image.width > maxWidth) {
				ImgD.width = maxWidth;
				ImgD.height = (image.height * maxWidth) / image.width;
			} else {
				ImgD.width = image.width;
				ImgD.height = image.height;
			}
		} else {
			if (image.height > maxHeight) {
				ImgD.height = maxHeight;
				ImgD.width = (image.width * maxHeight) / image.height;
			} else {
				ImgD.width = image.width;
				ImgD.height = image.height;
			}
		}
	}
}

function AdminTdHoverInit()
{
	$("table.tableborder td[class='']").parent().attr("class","tdbottom");
	$("table.tableborder td:not([class])").parent().attr("class","tdbottom");
	$("table.tableborder tr[class='tdbottom']").mouseover(function(){this.className="tdbottomover"}).mouseout(function(){this.className="tdbottom"});
	
	$("table.tableborder").each(function(){
		$(this).find("tr").each(function(){
			var td = $(this).find("td");
			if(td.length == 2)
			{
				if(td.eq(0).attr("align") == "")
				{
					td.eq(0).attr("align","right");
				}
				if(td.eq(1).attr("align") == "")
				{
					td.eq(1).attr("align","left");
				}
			}
		});
	});
}

function AdminUpLoadFile(id)
{
	var fileUrl = showModalDialog("uploadFileFrame.php",window,"dialogWidth:550px;dialogHeight:150px;help:no;scroll:no;status:no");
	if (fileUrl != null){
		document.getElementById(id).value = fileUrl.replace("../","/");
	}
}
function AdminPicAutoSmall(bigId,smallId)
{
	var bigVal = document.getElementById(bigId).value;
	if(bigVal == "")
	{
		alert("抱歉，请先上传大图片！");
	}
	else
	{
		var html = $("#" + smallId).parent().html();
		var wh = html.split("规格：")[1];
		var w = wh.split("×")[0];
		var h = wh.split("×")[1];
	
		var fileUrl = showModalDialog("uploadFileThumb.php?big=" + bigVal + "&width=" + w + "&height=" + h,window,"dialogWidth:350px;dialogHeight:150px;help:no;scroll:no;status:no");
		if (fileUrl != null){
			document.getElementById(smallId).value = fileUrl.replace("../","/");
		}
	}
}

function AdminChangeMenuType(v)
{
	document.getElementById("linkInfo").style.display="none";
	document.getElementById("picBigInfo").style.display="none";
	document.getElementById("picSmallInfo").style.display="none";
	
	if(v == "link"){document.getElementById("linkInfo").style.display="block";}
	if(v == "pics" || v == "album"){document.getElementById("picBigInfo").style.display="block";document.getElementById("picSmallInfo").style.display="block";}
	if(v == "imgs" || v == "photos"){document.getElementById("picBigInfo").style.display="block";}
}

function setTab03Syn ( i )
{
	selectTab03Syn(i);
}

function selectTab03Syn ( i )
{
	switch(i){
		case 1:
		document.getElementById("TabCon1a").style.display="block";
		document.getElementById("TabCon2a").style.display="none";
		document.getElementById("font1").style.color="#ffffff";
		document.getElementById("font2").style.color="#000000";
		break;
		case 2:
		document.getElementById("TabCon1a").style.display="none";
		document.getElementById("TabCon2a").style.display="block";
		document.getElementById("font1").style.color="#000000";
		document.getElementById("font2").style.color="#ffffff";
		break;
		
	}
}

function AddFavorite(sURL, sTitle) 
{ 
    try 
    { 
        window.external.addFavorite(sURL, sTitle); 
    } 
    catch (e) 
    { 
        try 
        { 
            window.sidebar.addPanel(sTitle, sURL, ""); 
        } 
        catch (e) 
        { 
            alert("加入收藏失败，请使用Ctrl+D进行添加"); 
        } 
    } 
} 
function SetHome(obj,vrl){ 
        try{ 
                obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl); 
        } 
        catch(e){ 
                if(window.netscape) { 
                        try { 
                                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
                        } 
                        catch (e) { 
                                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。"); 
                        } 
                        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
                        prefs.setCharPref('browser.startup.homepage',vrl); 
                 } 
        } 
} 

function toPageTop() {
    $("html,body").animate({ scrollTop: $("#pageTopLine").offset().top }, 1000);
}
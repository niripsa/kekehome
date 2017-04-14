
var msico = "ydico";
var kaiID ;
var nkaiID  ;
var adtypes="";
var diinfo;
var temobj;
var kailen;
var ndiinfo;
var huafei;
var zmei=0;
var Qfmin= new Array();
	Qfmin[0] = 300; Qfmin[1] = 3000;
var Qfmax= new Array();
	Qfmax[0] = 3000; Qfmax[1] = 30000;




$(document).ready(function() {
	window.onload = function() { $(".gaidiv").css({display:"none"});	$("#load").css({display:"none"});	}; 
	$(".diinfo").fadeTo("fast",0.0);
	if($("#huafei").html()!="0"){
		 $("#hfico").html("<img src='"+imgsrc+"/hfico.gif' onclick=\"mico('hfico')\" />") ;
	}
	$(".di").hover( function(){ $(this).find(".diinfo").fadeTo("fast",0.8);  },
				    function(){ $(this).find(".diinfo").fadeTo("fast",0.0);  }				   
	);

/*---------扩展或者增加KK----------*/
	$(".di").click(function(){
		//if($(this).attr("id").replace('di','')>11) return false;
		//开垦新地播种事件	
		if(msico=="kaiico" && $(this).html().indexOf("diinfo")==-1){
			adtypes = "new";
			$(".gaidiv").fadeTo("fast",0.3);
			$("#adbtn").html("开垦播种");
			$("#aform").fadeTo("fast",1);
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			if(kaiID<11){
				if(parseInt($("#money_now").val()) < 3000){
					$("#max_add").html($("#money_now").val());
				}
				else{
					$("#max_add").html("2700");
				}
			}
			else{
				if(parseInt($("#money_now").val()) < 30000){
					$("#max_add").html($("#money_now").val());
				}
				else{
					$("#max_add").html("27000");
				}
			}
		}
		
		//增加播种事件
	
		if(msico=="jiaico" && $(this).html().indexOf("diinfo")>-1){
			adtypes = "ad";
			$(".gaidiv").fadeTo("fast",0.3);
			$("#adbtn").html("增加播种");
			$("#aform").fadeTo("fast",1);
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			if(kaiID<11){
				if(parseInt($("#money_now").val()) < 3000){
					$("#max_add").html($("#money_now").val());
				}
				else{
					$("#max_add").html("2700");
				}
			}
			else{
				if(parseInt($("#money_now").val()) < 30000){
					$("#max_add").html($("#money_now").val());
				}
				else{
					$("#max_add").html("27000");
				}
			}
		} 
		//施肥动作
		if(msico=="hfico" && $(this).html().indexOf("diinfo")>-1){
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","")
			$("#shifei").fadeTo(100,1);	
			$("#shifei img").animate({height:"159px",width:"358px",marginTop:"80px"},400,function(){$("#shifei img").animate({marginTop:"70px"},200);});
			$("#shifei").fadeTo(1000,0.0,function(){
				$("#shifei").css({display:"none"}); 
				$.post("shifei.php",{act:"shifei",farmID:kaiID},function(result){
					if (result.indexOf("ok")>0){
						huafei = result.split("-")[1] ;
						$("#fei").html(huafei+"千克");						
						$("#di"+kaiID).find("img").attr("src",imgsrc+"/shu"+getshu(result.split("-")[2],kaiID)+imgt);
						$("#di"+kaiID).find(".diinfo").html(result.split("-")[2]+"枚");
						//alert( ( result.split("-")[3]).toFixed(2));
						$("#di"+kaiID).find(".zeng").html("+"+result.split("-")[3]);
						temobj = $("#di"+kaiID).find(".zeng");						
						temobj.fadeTo(100,0.9);
						temobj.animate({top:"0px"},400);
						temobj.fadeTo(1100,0.0)	;
						$("#zmei").html((result.split("-")[3]*1)+($("#zmei").html().replace("枚","")*1)+"枚");
						$("#huafei").html(huafei);
						if(huafei==0){
							$("#body").css({cursor:""});  
							msico="";	
							$("#hfico").html("<img src='"+imgsrc+"/hfico2"+imgt+"' />") ;	
						}
					}
					else alert(result);
				} );					
			});
		}/////
		//收获动作

		if(msico=="caiico" && $(this).html().indexOf("diinfo")>0){
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			
			$.post("shouhuo.php",{farmID:kaiID},function(result){
						if (result.indexOf("ok")>0){
							alert(kaiID);
							if(kaiID<=11){ 
								$("#di"+kaiID).find("img").attr("src",""+imgsrc+"/shu1"+imgt+"");
								$("#di"+kaiID).find(".diinfo").html(Qfmin[0]+"枚");
							}
							else{
								$("#di"+kaiID).find("img").attr("src",""+imgsrc+"/shu5"+imgt+"");
								$("#di"+kaiID).find(".diinfo").html(Qfmin[1]+"枚");

							}
							$("#zmei").html(($("#zmei").html().replace("枚","")*1)-(result.split("-")[1]*1)+"枚");
							$("#zhong").html(($("#zhong").html().replace("枚","")*1)+(result.split("-")[1]*1)+"枚");
							$("#body").css({cursor:""}); 
							msico="";
							}
						else alert(result);
			} );
		}
		//帮忙浇水事件	
		if(msico=="jsico" && $("#jsico").find("img").attr("src")==""+imgsrc+"/jsico"+imgt+"" ){
			$.post("jiaoshui.asp",{act:"jiaoshui",unumber:$("#unumber").html()},function(result){
				if (result=="-ok-"){
					$(".gaidiv").fadeTo("fast",0.3);
					$("#shuidiv").fadeTo("fast",1,function(){
						$(".gaidiv").fadeTo(2000,0.3,function(){
							$("#shuidiv").fadeTo(500,0.0,function(){$("#shuidiv").css({display:"none"});  });					 
							$(".gaidiv").fadeTo(500,0.0,function(){$(".gaidiv").css({display:"none"});  }); 
						});				 
					});
					$("#body").css({cursor:""}); 
					msico="";
					$("#jsico").find("img").attr("src",""+imgsrc+"/jsico2"+imgt+"");
				}
				else alert(result);
			} );
		} 
	});
	
	$("#adbtn").click(function(){

		money_now = $("#money_now").val();
		txt=$("#dousum").val();
		$.post("addou.php",{addou:txt,kid:kaiID,adtype:adtypes,now:money_now},function(result){

			$(".gaidiv").css({display:"none"}); 
			$("#aform").css({display:"none"}); 
			$("#dousum").val("");
			if ( result.indexOf("ok")>0){
				if(adtypes=="ad"){
					$("#di"+kaiID).html("<img src='"+imgsrc+"/shu"+getshu(result.split("-")[1],kaiID)+""+imgt+"' /><div class='diinfo'>"+result.split("-")[1]+"枚</div>");
				}
				else{
					$("#di"+kaiID).html("<img src='"+imgsrc+"/shu"+getshu(result.split("-")[1],kaiID)+""+imgt+"' /><div class='diinfo'>"+result.split("-")[1]+"枚</div>");
					if(kaiID>=11){	$("#di"+kaiID).css({background:"url("+imgsrc+"/dibg11"+imgt+") top left no-repeat"}); }
					else{	$("#di"+kaiID).css({background:"url("+imgsrc+"/dibg01"+imgt+") top left no-repeat"}); 
					}
				}
				
				$(".diinfo").fadeTo("fast",0.0);				
				msico = "";
				$("#body").css({cursor:""}); 
				if(adtypes=="ad"){
				zmei = ($("#zmei").html().replace("枚","")*1)+(txt*1);
				}
				else{
				zmei = ($("#zmei").html().replace("枚","")*1)+(result.split("-")[1]*1);
				}
				
				$("#zmei").html(zmei+"枚");
				if(kaiID<11){
					$("#zhong").html(($("#zhong").html().replace("枚","")*1)-(txt*1)-300+"枚");
				}else{
					$("#zhong").html(($("#zhong").html().replace("枚","")*1)-(txt*1)-3000+"枚");
				}
				
				/*alert(result+"成功");
				location.reload();*/
				}
			else alert(result);

		} );  
	});
	
	
	
	$("#closes").click(function(){
			$(".gaidiv").css({display:"none"}); 
			
			$("#aform").css({display:"none"}); 	});

	
}); 

/*	点击工具栏改变鼠标样式*/
function mico(ico){
	msico = ico;
	$("#body").css({cursor:"url('"+imgsrc+"/"+msico+".ico'),auto "});   
	//alert(msico);
}

/*	点击工具栏改变鼠标样式*/
function getshu(dous,id){
	var tdou ;
	if(id<=11)  tdou=dous/100;
	else tdou=dous/1000;
	if(id<=11)
	{
		 return 1;
		
	}
	else
	{
		 return 5;
		
	}
	
}
 //alert(getshu(1333));

 
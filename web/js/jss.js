
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
	if($("#fei").html()!="0"){
		 $("#hfico").html("<img src='"+imgsrc+"/hfico.gif' onclick=\"mico('hfico')\" />") ;
	}else{
		$("#hfico").html("<img src='"+imgsrc+"/hfico2.png' />") ;
	}
	$(".di").hover( function(){ $(this).find(".diinfo").fadeTo("fast",0.8);  },
				    function(){ $(this).find(".diinfo").fadeTo("fast",0.0);  }				   
	);


/*---------扩展或者增加金豆----------*/
	$(".di").bind("click",function(){
		if(msico=="kaiico" && $(this).html().indexOf("diinfo")==-1){
			adtypes = "new";
			
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			money_now = $("#money_now").val();
			if(kaiID<11){
				if(parseInt(money_now) < 300){
					alert("您没有这么多KK了！快去购买KK吧~~！");
				}else{
					txt = 300;
				}
			}
			else{
				if(parseInt(money_now) < 3000){
					alert("您没有这么多KK了！快去购买KK吧~~！");
				}else{
					txt = 3000;
				}
			}


			$.post("addou.php",{addou:txt,kid:kaiID,adtype:adtypes},function(result){
			$(".gaidiv").css({display:"none"}); 
			$("#aform").css({display:"none"}); 
			$("#dousum").val("");
			if ( result.indexOf("ok")>0){
				$("#di"+kaiID).html("<img src='"+imgsrc+"/shu"+getshu(result.split("-")[1],kaiID)+""+imgt+"' /><div class='diinfo'>"+result.split("-")[1]+"KK</div>");
				if(kaiID>=11){	$("#di"+kaiID).css({background:"url("+imgsrc+"/dibg11"+imgt+") top left no-repeat"}); }
				else{	$("#di"+kaiID).css({background:"url("+imgsrc+"/dibg01"+imgt+") top left no-repeat"}); 
				}
				
				$(".diinfo").fadeTo("fast",0.0);				
				msico = "";
				$("#body").css({cursor:""}); 
				if(adtypes=="ad"){
					zmei = ($("#zmei").html()*1)+(txt*1);
				}
				else{
					zmei = ($("#zmei").html()*1)+(result.split("-")[1]*1);
				}
				$("#zmei").html(zmei);
				
				stock = $("#stock").html()-result.split("-")[1];
				if(stock > 0){
					$("#stock").html(stock);

					zong = zmei+stock;
					$("#zong").html(zong);

				}
			}
			else alert(result);
		} ); 
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
			kaiID = kaiID.replace("di","");
			$("#shifei").fadeTo(100,1);	
			$("#shifei img").animate({height:"159px",width:"358px",marginTop:"80px"},400,function(){$("#shifei img").animate({marginTop:"70px"},200);});
			$("#shifei").fadeTo(1000,0.0,function(){
				$("#shifei").css({display:"none"}); 
				$.post("shifei.php",{act:"shifei",farmID:kaiID},function(result){
					if (result.indexOf("ok")>0){
						huafei = result.split("-")[1] ;
						$("#fei").html(huafei);						
						$("#di"+kaiID).find("img").attr("src",imgsrc+"/shu"+getshu(result.split("-")[2],kaiID)+imgt);
						$("#di"+kaiID).find(".diinfo").html(result.split("-")[2]);
						//alert( ( result.split("-")[3]).toFixed(2));
						$("#di"+kaiID).find(".zeng").html("+"+result.split("-")[3]);
						temobj = $("#di"+kaiID).find(".zeng");						
						temobj.fadeTo(100,0.9);
						temobj.animate({top:"0px"},400);
						temobj.fadeTo(1100,0.0)	;
						$("#zmei").html((result.split("-")[3]*1)+($("#zmei").html()*1));
						
						zong =($("#zmei").html()*1)+($("#stock").html()*1);
						$("#zong").html(zong);

						growth_total = (result.split("-")[3]*1)+($("#growth_total").html()*1);
						$("#growth_total").html(growth_total);

						$("#huafei").html(huafei);
						if(huafei==0){
							$("#body").css({cursor:""});  
							msico="";	
							//$("#hfico").html("<img src='"+imgsrc+"/hfico2"+imgt+"' />") ;	
						}
					}
					else alert(result);
				} );					
			});
		}

		//收获动作
		if(msico=="caiico" && $(this).html().indexOf("diinfo")>0){
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			//$("#caiico").html("<img src='"+imgsrc+"/caiico2"+imgt+"' />") ;	
			$.post("shouhuo.php",{farmID:kaiID},function(result){

						if (result.indexOf("ok")>0){
							if(kaiID<=10){ 
								$("#di"+kaiID).find("img").attr("src",""+imgsrc+"/shu1"+imgt+"");
								$("#di"+kaiID).find(".diinfo").html(Qfmin[0]);
							}
							else{
								$("#di"+kaiID).find("img").attr("src",""+imgsrc+"/shu5"+imgt+"");
								$("#di"+kaiID).find(".diinfo").html(Qfmin[1]);

							}
							$("#zmei").html(($("#zmei").html()*1)-(result.split("-")[1]*1));
						
							
							stock = ($("#stock").html()*1)+(result.split("-")[1]*1);
							if(stock > 0){
								$("#stock").html(stock);
							}
							

							$("#body").css({cursor:""}); 
							msico="";

							

						}
						else alert(result);
			} );
		}


		
		/*向好友采蜜*/
		if(msico=="caimi" && $(this).html().indexOf("diinfo")>0){
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			username = $("#unumber").text();
			username = username.replace("用户：","");
				
			$.post("caimi.php",{username:username,farmID:kaiID},function(result){
				  $("#caimi").html("<img src='"+imgsrc+"/caimi2"+imgt+"' />") ;

				   alert("采蜜的数量为"+result.split("-")[1]);
					
			} );
		}

		/*一键采蜜*/
		if(msico=="caimi2" ){
			kaiID = $(this).attr("id");
			kaiID = kaiID.replace("di","");
			username = $("#unumber").text();
			username = username.replace("用户：","");
		
			$.post("caimi.php",{username:username,farmID:kaiID},function(result){
				   alert("采蜜的数量为"+result.split("-")[1]);
					
			} );
		}

	});
	
	
	$("#adbtn").click(function(){
		$("#adbtn").attr({"disabled":"disabled"});
		money_now = $("#money_now").val();
		txt=$("#dousum").val();
		$(".gaidiv").css({display:"none"}); 
		$("#aform").css({display:"none"}); 

		$.post("addou.php",{addou:txt,kid:kaiID,adtype:adtypes,now:money_now},function(result){
			
			$("#dousum").val("");
			if ( result.indexOf("ok")>0){
				if(adtypes=="ad"){
					$("#di"+kaiID).html("<img src='"+imgsrc+"/shu"+getshu(result.split("-")[1],kaiID)+""+imgt+"' /><div class='diinfo'>"+result.split("-")[1]+"KK</div>");
				}
				
				$(".diinfo").fadeTo("fast",0.0);				
				msico = "";
				$("#body").css({cursor:""}); 
				if(adtypes=="ad"){
				zmei = ($("#zmei").html()*1)+(txt*1);
				}
				
				$("#zmei").html(zmei);
				
				stock = $("#stock").html()-txt;
				if(stock > 0){
					$("#stock").html(stock);

					zong = zmei+stock;
					$("#zong").html(zong);
				}

				$("#jiaico").html("<img src='"+imgsrc+"/jiaico2"+imgt+"' />") ;	
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
	if(id<=10)  tdou=dous/100;
	else tdou=dous/1000;
	if(id<=10)
	{
		if (tdou==3) return 1;
		if (tdou>3 && tdou<=12) return 2;
		if (tdou>12 && tdou<=21) return 3;
		if (tdou>21 && tdou<=30) return 4;
	}
	else
	{
		if (tdou==3) return 5;
		if (tdou>3 && tdou<=12) return 6;
		if (tdou>12 && tdou<=21) return 7;
		if (tdou>21 && tdou<=30) return 8;
	}
	
}
 //alert(getshu(1333));

 
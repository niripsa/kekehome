<?
if(!$webInfo['h_open']){
	echo "
	<script>
	window.location.href='/close.php';
	</script>
	";
	}
?>
    <div class="page-body">
        
    <div class="head">
        <input type="image" name="ctl00$Back" id="ctl00_Back" class="head-icon-left" src="/mod/images/common_back.png" style="border-width:0px;">
        <div class="head-title"><?php echo $pageTitle ?></div>
        <a href="index.php" class="head-icon-right  "><img src="/mod/images/home_right.png"></a>
    </div>
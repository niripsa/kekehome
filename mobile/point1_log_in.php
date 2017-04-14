<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';
$t[1] = '种子奖励记录';
$td[1] = '<td>类型</td>
    <td>种子数量</td>
    <td>时间</td>';
$t[2] = '丘比特奖励记录';
$td[2] = '<td>类型</td>
    <td>推荐人数量</td>
    <td>时间</td>';
$t[3] = '花仙子奖励记录';
$td[3] = '<td>类型</td>
    <td>KK</td>
    <td>时间</td>';
$t[4] = '施肥奖励记录';
$td[4] = '<td>类型</td>
    <td>KK</td>
    <td>时间</td>';
$t[5] = '播种奖励记录';
$td[5] = '<td>类型</td>
    <td>KK</td>
    <td>时间</td>';
$t[6] = '收获奖励记录';
$td[6] = '<td>类型</td>
    <td>KK</td>
    <td>时间</td>';
if(!$_GET['type'] or $_GET['type'] <= 0 or $_GET['type'] > 6)die;
$pageTitle = $t[$_GET['type']];

require_once 'inc_header.php';
require_once 't.php';
require_once 'log_function.php';
?>
<div class="content">
        <table style="width: 100%;">
            <thead style="color:red;text-align:center;font-size:12px">
                 <tr>
    <?php echo $td[$_GET['type']] ?>
  </tr>
  </thead>
            <tbody style="background: #ffffff;">
<?php
list_($_GET['type']);
?>
</tbody>
</table>


</div>
</div>
<!--MAN End-->
</div></div>
    <script>
	mgo(33);
    </script>
    
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>
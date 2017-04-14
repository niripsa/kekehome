<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/webConfig.php';

$pageTitle = '庄园说明';

require_once 'inc_header.php';
require_once 't.php';
?>

<div class="panel panel-default">

<div class="panel-body">
<br />
<img style = "width:100%" src="/imsges/sm.jpg" />
<img style = "width:100%" src="/imsges/smB.jpg" />
  <div>
    <span style="font-weight:bold; font-size:18px; float:left; line-height:25px; width:100%;">庄园工具介绍：</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">1、扩展工具：鼠标点击扩展工具，鼠标变成铲子形状，点击要开垦的地块上，会弹出种植数量对话框如图B，输入要种植的KK数量，点击“开垦播种”，完成地块的种植。</span> 
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">2、增加种植工具：选择增加种植工具，点击已经种植过的地块上，弹出增加播种对话框如图B，输增加播种的KK种子数量，点击“增加播种”，该地块上完成增加播种。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">3、化肥包工具：系统每次拆分完后，会根据您地里边种植的KK数量产生相应数量的化肥，并放到您的化肥包里面，化肥包会变成闪烁状态，选择化肥包工具，点击您要施肥的地块或地块上的农作物，出现施肥效果，随既该地块的KK数量增加，化肥包既为空，如果您施肥的地块到达最大数量上限而化肥没有用完，可以再次到其他地块施肥，直到化肥施完。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">4、采摘工具：选择采摘工具，点击要收获的地块，改地块的KK数量除了最低播种限度外的其他KK都会收回到您的种子包里面，完成采摘。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">5、采蜜工具：进入好友果园，如果下属会员产生的化肥，您也随即产生相应的蜜蜂（会员化肥*固定系数），选择采蜜工具，在游戏屏幕中点击后，蜜蜂会飞出去采蜜，您的仓库会得到相应的KK数量。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;width:100%;">6、刷新工具：刷新游戏界面，检测是否有新的化肥包产生；</span>
    <br/>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;width:100%;">7、花仙子：每推荐10个会员系统会奖励1个花仙子，上限是4个花仙子。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">8、丘比特：化肥累计达到50000和150000后，分别赠送一个丘比特，可以提高生长比例。</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">您所有的操作结果会及时显示到信息栏上，如图C。</span>
<br />
    <span style="font-weight:bold; font-size:18px; float:left; color:#FF0000; line-height:25px; width:100%; margin-top:10px;">注意事项：</span>
<span style="font-weight:bold; font-size:14px; float:left; color:#FF0000; line-height:25px;">1、化肥的数量是根据系统拆分的时候您地里边的KK数量产生的化肥，粮仓里的种子不会产生化肥，所以请及时把多余的种子种到地里边，保证您的收益；</span>
<span style="font-weight:bold; font-size:14px; float:left; color:#FF0000; line-height:25px;">2、每块土地都有最低和最高种植限制，普通地块300 - 3000KK，金地3000 - 30000KK，地块达到最高数量无法再增加播种，也无法施肥增加KK，此时您要采摘出售您的果实变成实在的收益，地块一旦种植后，都要保留最低限度的种子数量（普通地300,金地3000），无法采摘；</span>
<span style="font-weight:bold; font-size:14px; float:left; color:#FF0000; line-height:25px;">3、如果您产生了化肥没有及时向地里边施肥，系统再次拆分产生的化肥将累加到您的化肥包。</span>
<br />
    <span style="font-weight:bold; font-size:18px; float:left; line-height:25px; width:100%; margin-top:10px;">游戏理念</span>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">1、只有种植到地里边的种子才能产生收益，这样是让玩家认识到利复利；</span>
    <br/>
    <span style="font-weight:bold; font-size:14px; float:left; line-height:25px;">2、每块地保留最低的种子限度是让每个玩家懂得以小博大的精髓，让每个玩家通过游戏学习到理财；</span>
  </div>
</div>

</div>
</div>﻿
<?php
require_once 'f.php';
require_once 'inc_footer.php';
?>
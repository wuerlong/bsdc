<?php
session_start();
?>

<div id="header">
  <div id="headerBox">
    <div id="logo"><a href="#" class="linkwhite">宝山教育学院</a></div>
    <div class="logout"><a href="login.out.php" class="linkwhite">注销系统</a></div>
    <div class="logout"><a href="javascript:editPassword()" class="linkwhite">修改密码</a></div>
    <p class="clear"></p>
    <ul id="menu">
      <li> <a href="member.php" target="mainFrame"><span>用户管理</span></a>
      </li>
      <li> <a href="research.php?id=1" target="mainFrame"><span>加餐管理</span></a> </li>
      <li> <a href="research.php" target="mainFrame"><span>订餐管理</span></a> </li>
	  <?php if($_SESSION['userid']==1){?>
      <li> <a href="friendlink.php" target="mainFrame"><span>时间管理</span></a> </li>
	  <?php }?>
	  <?php if($_SESSION['userid']==1){?>
	  <li> <a href="#"><span>报表管理</span></a>
        <ul class="subMenu">
          <li><a href="report01.php" target="mainFrame">部门汇总总表（午饭）</a></li>
		  <li><a href="report01a.php" target="mainFrame">部门汇总总表（早餐）</a></li>
          <li><a href="report02.php" target="mainFrame">吃饭登记表（午饭）</a></li>
		  <li><a href="report02a.php" target="mainFrame">吃饭登记表（早餐）</a></li>
		  <li><a href="report03.php" target="mainFrame">每日吃饭汇总表（午饭）</a></li>
		  <li><a href="report03a.php" target="mainFrame">每日吃饭汇总表（早餐）</a></li>
		  <li><a href="report04.php" target="mainFrame">月度统计报表（午饭）</a></li>
		  <li><a href="report04a.php" target="mainFrame">月度统计报表（早餐）</a></li>
        </ul>
      </li>
	  <?php }else{?>
	  <li> <a href="#"><span>报表管理</span></a>
        <ul class="subMenu">
          <li><a href="report01b.php" target="mainFrame">部门汇总总表（午饭）</a></li>
		  <li><a href="report01c.php" target="mainFrame">部门汇总总表（早餐）</a></li>
          <li><a href="report02b.php" target="mainFrame">吃饭登记表（午饭）</a></li>
		  <li><a href="report02c.php" target="mainFrame">吃饭登记表（早餐）</a></li>
		  <li><a href="report03b.php" target="mainFrame">每日吃饭汇总表（午饭）</a></li>
		  <li><a href="report03c.php" target="mainFrame">每日吃饭汇总表（早餐）</a></li>
		  <li><a href="report04b.php" target="mainFrame">月度统计报表（午饭）</a></li>
		  <li><a href="report04c.php" target="mainFrame">月度统计报表（早餐）</a></li>
        </ul>
      </li>
	  <?php }?>
	  <?php if($_SESSION['userid']==1){?>
      <li> <a href="#"><span>系统管理</span></a>
        <ul class="subMenu">
          <li><a href="user.php" target="mainFrame">管理员账号</a></li>
          <li><a href="file.php" target="mainFrame">文件管理</a></li>
          <li><a href="webconfig.php" target="mainFrame">网站设置</a></li>
          <li><a href="data.backup.php" target="mainFrame">数据备份</a></li>
          <li class="no_border"><a href="data.restore.php" target="mainFrame">数据还原</a></li>
        </ul>
      </li>
	  <?php }?>
    </ul>
  </div>
  <p class="clear"></p>
</div>
<?php 
?>

<?php
include_once 'global.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>菜单页</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" class="main_left"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_title">
        <tr>
          <td>文章管理</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_menu01">
        <tr>
          <td><a href="article.add.php?act=add" target="mainFrame">添加文章</a></td>
        </tr>
        <tr>
          <td><a href="article.php" target="mainFrame">文章管理</a></td>
        </tr>
        <tr>
          <td><a href="category.php" target="mainFrame">栏目管理</a></td>
        </tr>
        <tr>
          <td><a href="article.rubbish.php" target="mainFrame">垃圾箱管理</a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_title">
        <tr>
          <td>产品管理</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_menu01">
        <tr>
          <td><a href="case.add.php?act=add" target="mainFrame">添加商品</a></td>
        </tr>
        <tr>
          <td><a href="case.php" target="mainFrame">商品管理</a></td>
        </tr>
        <tr>
          <td><a href="case_category.php" target="mainFrame">商品栏目管理</a></td>
        </tr>
        <tr>
          <td><a href="case.rubbish.php" target="mainFrame">商品垃圾箱管理</a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_title">
        <tr>
          <td>网站管理</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_menu01">
        <tr>
          <td><a href="notice.php" target="mainFrame">KV管理</a></td>
        </tr>
        <tr>
          <td><a href="friendlink.php" target="mainFrame">友情链接</a></td>
        </tr>
        <tr>
          <td><a href="message.php" target="mainFrame">留言管理</a></td>
        </tr>
        <tr>
          <td><a href="file.php" target="mainFrame">文件管理</a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_title">
        <tr>
          <td>系统管理</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_menu01">
        <tr>
          <td><a href="user.php" target="mainFrame">管理员账号</a></td>
        </tr>
        <tr>
          <td><a href="webconfig.php" target="mainFrame">网站设置</a></td>
        </tr>
        <tr>
          <td><a href="data.backup.php" target="mainFrame">数据备份</a></td>
        </tr>
        <tr>
         <td><a href="data.restore.php" target="mainFrame">数据还原</a></td>
        </tr>
      </table>
      <br />
      </td>
  </tr>
</table>
</body>
</html>

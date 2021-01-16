<?php
require_once ("global.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['name'];?>-管理后台</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="images/atod.common.css">
<link rel="stylesheet" type="text/css" media="screen" href="images/atod.default.css">
<link rel="stylesheet" type="text/css" media="screen" href="images/jquery-ui-1.8.11.custom.css">
<link rel="stylesheet" type="text/css" media="screen" href="images/atod.overlay.css">
<link rel="stylesheet" type="text/css" media="screen" href="images/shadowbox.css">
<script type="text/javascript" src="images/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="images/jquery.form.js"></script>
<script type="text/javascript" src="images/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="images/jquery.exfixed-1.3.1.js"></script>
<script type="text/javascript" src="images/jquery.upload-1.0.2.js"></script>
<script type="text/javascript" src="images/shadowbox.js"></script>
<script type="text/javascript" src="images/atod.common.js"></script>
<script type="text/javascript" src="images/jquery.atod.js"></script>
<script type="text/javascript" src="images/jquery.tile.js"></script>
<script type="text/javascript" src="images/common.js"></script>
<script type="text/javascript">
function editPassword(){
	parent.mainFrame.location="user.editpwd.php?act=editpwd&hlink="+encodeURIComponent(parent.mainFrame.location);
}
</script>
</head>
<?php include_once 'header.php';
if($_SESSION['userid']==3){
?>
<iframe src="research.php" name="mainFrame" id="mainFrame" scrolling="auto" width="100%" height="600" frameborder="no" border="0" framespacing="0"/></iframe>
<?php }else{?>
<iframe src="research.php" name="mainFrame" id="mainFrame" scrolling="auto" width="100%" height="600" frameborder="no" border="0" framespacing="0"/></iframe>
<?php }?>
<div class="clear"></div>
<div id="footer">
	<div id="copyright">Copyright(C) 2019 宝山教育学院 All Rights Reserved.</div>
</div>
</html>
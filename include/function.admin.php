<?php 
/**
 * 后台公用函数库
 */

/**
 * 分页函数
 *
 * @param int $num	
 * @param int $perpage
 * @param int $curpage
 * @param string $mpurl
 * @param int $maxpages
 * @param int $page
 * @param bool $autogoto
 * @param bool $simple
 * @return string
 */
function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE) {
	global $maxpage;
		$shownum = $showkbd = true;
		$lang['prev'] = '上一页';
		$lang['next'] = '下一页';

	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	$realpages = 1;									
	if($num > $perpage) {
		$offset = 2;

		$realpages = @ceil($num / $perpage);
		$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}

		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first">首页</a> ' : '').
			($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev">'.$lang['prev'].'</a> ' : '');	
		
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<strong><font style="color:#ff0000">'.$i.'</font></strong> &nbsp;&nbsp;' :
				'<a href="'.$mpurl.'page='.$i.($i == $pages && $autogoto ? '#' : '').'">'.$i.'</a> &nbsp;&nbsp;';
		}

		$multipage .= ($to < $pages ? '. . .&nbsp;&nbsp;<a href="'.$mpurl.'page='.$pages.'" class="last">'.$realpages.'</a> ': '').
			($curpage < $pages && !$simple ? '&nbsp;&nbsp;<a href="'.$mpurl.'page='.($curpage + 1).'" class="next">'.$lang['next'].'</a> ' : '').
			($showkbd && !$simple && $pages > $page ? '<kbd><input type="text" name="custompage" size="3" style="height:20px;font-size:12px" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+this.value; return false;}" /><input type="button"  style="height:22px;font-size:12px" value="转到" onclick="window.location=\''.$mpurl.'page=\'+document.all(\'custompage\').value; return false;"></kbd>' : '');

		$multipage = $multipage ? '<div class="pages">'.($shownum && !$simple ? '共&nbsp;<font style="color:#ff0000">'.$num.'</font>&nbsp;条 ' : '').$multipage.'</div>' : '';
	}
	$maxpage = $realpages;
	return $multipage;
}

/**
 * 栏目分类下拉框 <option></option>
 *
 * @param int $pid
 * @param int $id
 * @param int $level
 */
function getCategorySelect($select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->findAll ( "select * from phpaadb_category where pid = " . $id . " order by seq" );
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "　";
	}
	if ($level++) $level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		getCategorySelect ($select_id, $id, $level );
	}
}

/**
 * 栏目分类下拉框 <option></option>
 *
 * @param int $pid
 * @param int $id
 * @param int $level
 */
function getWeekSelect($select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->findAll ( "select * from phpaadb_friendlink  order by id desc" );

	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
	}
}
function getArealSelect($select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->findAll ( "select * from phpaadb_areal where pid = " . $id . " order by seq" );
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "　";
	}
	if ($level++) $level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		getCategorySelect ($select_id, $id, $level );
	}
}
function getArea2Select($select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->findAll ( "select * from phpaadb_area2 where pid = " . $id . " order by seq" );
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "　";
	}
	if ($level++) $level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		getCategorySelect ($select_id, $id, $level );
	}
}
/**
 * 获取所有子节点集合
 * @param $pid 栏目ID
 * @return 子节点ID集合 如 1,2,3
 */
function getCategoryChildIds($pid=0){
	global $db;
	$str = "";		//节点集合
	$strChild = ""; //子节点集合
	$list = $db->findAll("select id from phpaadb_category where pid=".$pid);
	foreach($list as $ls){
		$strChild = getCategoryChildIds($ls['id']);		
		$str .= $str==""?$ls['id']:",".$ls['id'];		
		if ($strChild) {
			$str .= $str==""?$strChild:",".$strChild;
		}
	}
	return $str;
}
function getArealChildIds($pid=0){
	global $db;
	$str = "";		//节点集合
	$strChild = ""; //子节点集合
	$list = $db->findAll("select id from phpaadb_areal where pid=".$pid);
	foreach($list as $ls){
		$strChild = getCategoryChildIds($ls['id']);		
		$str .= $str==""?$ls['id']:",".$ls['id'];		
		if ($strChild) {
			$str .= $str==""?$strChild:",".$strChild;
		}
	}
	return $str;
}

function getArea2ChildIds($pid=0){
	global $db;
	$str = "";		//节点集合
	$strChild = ""; //子节点集合
	$list = $db->findAll("select id from phpaadb_area2 where pid=".$pid);
	foreach($list as $ls){
		$strChild = getCategoryChildIds($ls['id']);		
		$str .= $str==""?$ls['id']:",".$ls['id'];		
		if ($strChild) {
			$str .= $str==""?$strChild:",".$strChild;
		}
	}
	return $str;
}

/**
 * 案例栏目分类下拉框 <option></option>
 *
 * @param int $pid
 * @param int $id
 * @param int $level
 */
function getCaseCategorySelect($select_id=0,$id = 0,$level = 0){
	global $db;
	$category_arr = $db->findAll ( "select * from phpaadb_case_category where pid = " . $id . " order by seq" );
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "　";
	}
	if ($level++) $level_nbsp .= "┝";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		$selected = $select_id==$id?'selected':'';
		echo "<option value=\"".$id."\" ".$selected.">".$level_nbsp . " " . $name."</option>\n";
		getCaseCategorySelect ($select_id, $id, $level );
	}
}
/***********************************
			图片上传函数
***********************************/
function uploadFile($filename){
	global $db;
	global $config;
	$attachment_dir = $config['attachment_dir'].date('Ym')."/";
	!is_dir(ROOT_PATH.$attachment_dir)&&mkdir(ROOT_PATH.$attachment_dir);	
	$AllowedExtensions = array('bmp','gif','jpeg','jpg','png');
	$Extensions = end(explode(".",$_FILES[$filename]['name']));
	
	if(!in_array(strtolower($Extensions),$AllowedExtensions)){
		exit("<script>alert('缩略图格式错误！只支持后缀名为bmp,gif,jpeg,jpg,png 的文件');window.history.go(-1)</script>");
	}


	$file_name = date('YmdHis').'_'.rand(10,99).'.'.$Extensions;
	$upload_file = $attachment_dir.$file_name;
	$upload_absolute_file = ROOT_PATH.$upload_file;
	if (move_uploaded_file($_FILES[$filename]['tmp_name'], $upload_absolute_file)) {
		$record = array(
			'filename'			=>$file_name,
			'ffilename'			=>$_FILES [$filename]['name'],
			'path'				=>$upload_file,
			'ext'				=>$Extensions,
			'size'				=>$_FILES [$filename]['size'],
			'upload_date'		=>date("Y-m-d H:i:s")			
		);
		$id = $db->save('phpaadb_file',$record);
		return $upload_file;
	}
}
/* 
函数名称：inject_check() 
函数作用：检测提交的值是不是含有SQL注射的字符，防止注射，保护服务器安全 
参　　数：$sql_str: 提交的变量 
返 回 值：返回检测结果，ture or false 
*/
function inject_check($sql_str) {
    return eregi('select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str); // 进行过滤 
}

/* 
函数名称：verify_id() 
函数作用：校验提交的ID类值是否合法 
参　　数：$id: 提交的ID值 
返 回 值：返回处理后的ID 
*/
function verify_id($id = null) {
    if (!$id) {
        exit('没有提交参数！');
    } // 是否为空判断 
    elseif(inject_check($id)) {
        exit('提交的参数非法！');
    } // 注射判断 
    elseif(!is_numeric($id)) {
        exit('提交的参数非法！');
    } // 数字判断 
    $id = intval($id); // 整型化 
    return $id;
}

/* 
函数名称：str_check() 
函数作用：对提交的字符串进行过滤 
参　　数：$var: 要处理的字符串 
返 回 值：返回过滤后的字符串 
*/
function str_check($str) {
    if (!get_magic_quotes_gpc()) { // 判断magic_quotes_gpc是否打开 
        $str = addslashes($str); // 进行过滤 
    }
    $str = str_replace("_", "\_", $str); // 把 '_'过滤掉 
    $str = str_replace("%", "\%", $str); // 把 '%'过滤掉 
    return $str;
}

/* 
函数名称：post_check() 
函数作用：对提交的编辑内容进行处理 
参　　数：$post: 要提交的内容 
返 回 值：$post: 返回过滤后的内容 
*/
function post_check($post) {
    if (!get_magic_quotes_gpc()) { // 判断magic_quotes_gpc是否为打开 
        $post = addslashes($post); // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 
    }
    $post = str_replace("_", "\_", $post); // 把 '_'过滤掉 
    $post = str_replace("%", "\%", $post); // 把 '%'过滤掉 
    $post = nl2br($post); // 回车转换 
    $post = htmlspecialchars($post); // html标记转换 
    return $post;
}
?>
$(document).ready(function(){
	
	$(".menulist").hover(function(){
		    $(".sublist").hide();
			$(this).find(".sublist").show();
		},function(){
			 $(".sublist").hide();
		}
	);
	$(".sublist li").hover(function(){
		    $(".sublist li").removeClass("select");
			$(this).addClass("select");
		},function(){
			// $(".sublist").hide();
		}
	);

	
	//取得当前窗口的事件
	var e = window.event;
	$('.nav_btn').live(
			'mouseover',
			function(e) {
				$(this).addClass("nav_tit_color");
				var elem=$(this).parents("li");
				elem.find(".nav_con").slideDown();
	});
	//鼠标移除层区域后，触发mouseout事件，把整个层隐藏
	$('.menu_box').live('mouseout', function(e) {
	    if(checkHover(e,this)){
			$(this).find(".nav_btn").removeClass("nav_tit_color");  
			$(this).find(".nav_con").hide();
	    }
	});
	
	/**
	 * 下面是一些基础函数，解决mouseover与mouserout事件不停切换的问题（问题不是由冒泡产生的）
	 */
	function checkHover(e, target) {
		if (getEvent(e).type == "mouseover") {
			return !contains(target, getEvent(e).relatedTarget
					|| getEvent(e).fromElement)
					&& !((getEvent(e).relatedTarget || getEvent(e).fromElement) === target);
		} else {
			return !contains(target, getEvent(e).relatedTarget
					|| getEvent(e).toElement)
					&& !((getEvent(e).relatedTarget || getEvent(e).toElement) === target);
		}
	}

	function contains(parentNode, childNode) {
		if (parentNode.contains) {
			return parentNode != childNode && parentNode.contains(childNode);
		} else {
			return !!(parentNode.compareDocumentPosition(childNode) & 16);
		}
	}
	//取得当前window对象的事件
	function getEvent(e) {
		return e || window.event;
	}
})
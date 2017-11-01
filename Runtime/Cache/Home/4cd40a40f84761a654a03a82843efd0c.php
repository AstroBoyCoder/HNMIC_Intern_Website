<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>岗位经验目录</title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/experience-catalog.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/nav.css">
</head>

<body>

	<div class="bg">
		<div class="navb">
			<a class="logo" href="/index.php?s=/Home/Index"></a>
			<ul class="nav">
				<li><a href="/index.php?s=/Home/Index#HIP" style="color: white;" class="lih">HIP</a></li>
				<li><a href="/index.php?s=/Home/personal" style="color: white;" class="lih">个人风采</a></li>
				<li><a href="/index.php?s=/Home/Experience" style="color: white;" class="lih">岗位经验</a></li>
				<li><a href="/index.php?s=/Home/infomalessay/jottings" style="color: white;" class="lih">随笔</a></li>
			</ul>
		</div>
		<div class="catalog">
			<div class="catalog_icon">
				<ul class="catalog_icon_ul">
					<li class="catalog_icon_ul_li1"></li>
					<li class="catalog_icon_ul_li2"></li>
					<li class="catalog_icon_ul_li3"></li>
					<li class="catalog_icon_ul_li4"></li>
					<li class="catalog_icon_ul_li5"></li>
					<li class="catalog_icon_ul_li6"></li>
				</ul>
			</div>
			<div class="catalog_text">
				<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><h4><a href="/index.php?s=/Home/Experience/subpage/id/<?php echo ($item['id']); ?>" style="color:#6d90a3;"><img src="/Public/Home/images/next_gray_icon.png" alt=""> <?php echo ($station); ?>感悟</a></h4>
					<p> 作者：2017届<?php echo ($station); ?></p>
					<p class="catalog_text_right"><?php echo ($item["create_time"]); ?></p>
					<br><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
	</div>

	<div class="foot">
		<p>Hi,partner</p>
		<p>powered by HIP</p>
		<p>Hi,partner © 2017 . PRIVACY POLICY</p>
	</div>




	<script src='/Public/Home/js/nav.js'></script>
	<script src="/Public/Home/js/experience-catalog.js"></script>


</body>

</html>
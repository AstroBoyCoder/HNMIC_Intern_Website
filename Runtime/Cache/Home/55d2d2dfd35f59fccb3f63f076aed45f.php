<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">

<head>
	<meta charset="UTF-8">
	<title>experience_subpage</title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/experience_subpage.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/nav.css">

</head>

<body>
	<div class="personalwrapper">
		<div class="navb">
			<a class="logo" href="/index.php?s=/Home/Index"></a>
			<ul class="nav">
				<li><a href="/index.php?s=/Home/Index#HIP" style="color: white;" class="lih">HIP</a></li>
				<li><a href="/index.php?s=/Home/personal" style="color: white;" class="lih">个人风采</a></li>
				<li><a href="/index.php?s=/Home/Experience" style="color: white;" class="lih">岗位经验</a></li>
				<li><a href="/index.php?s=/Home/infomalessay/jottings" style="color: white;" class="lih">随笔</a></li>
			</ul>
		</div>
		<div class="background">
			<div class="paper_background">
				<div class="paper_header">
					<p class="paper_title">
						<?php echo ($data["title"]); ?>
					</p>
					<!-- <img src="/Public/Home/images/head_pic.png" class="img_head" style="left:-800px; top:0px;"> -->
					<p class="author">
						作者：<?php echo ($data["author"]); ?>
					</p>
					<ul class="tag_name">
						<li style="background: #505050"><?php echo ($data["keyword"]); ?></li>
					</ul>
				</div>
				<div class="text_content">
					<?php echo ($data["content"]); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="foot">
		<p>Hi,partner</p>
		<p>powered by HIP</p>
		<p>Hi,partner © 2017 . PRIVACY POLICY</p>
	</div>

	<script src='/Public/Home/js/nav.js'></script>

</body>

</html>
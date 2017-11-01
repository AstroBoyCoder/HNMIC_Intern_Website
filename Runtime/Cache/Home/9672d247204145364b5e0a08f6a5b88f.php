<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>随笔</title>
	<link rel="stylesheet" href="/Public/Home/css/jottings.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/nav.css">
</head>

<body>
	<div class="navb">
		<a class="logo" href="/index.php?s=/Home/Index"></a>
		<ul class="nav">
			<li><a href="/index.php?s=/Home/Index#HIP" style="color: white;" class="lih">HIP</a></li>
			<li><a href="/index.php?s=/Home/personal" style="color: white;" class="lih">个人风采</a></li>
			<li><a href="/index.php?s=/Home/Experience" style="color: white;" class="lih">岗位经验</a></li>
			<li><a href="#" style="color: white;" class="lih">随笔</a></li>
		</ul>
	</div>
	<div class="title_bg">
		<div class="title">
			<h3>随笔</h3>
			<hr color="#DBDBDB" />
			<p class="personaltext">这里简单介绍一下MIC2017届实习生的所见所闻、所感所悟</p>
		</div>
	</div>
	<div class="jottings">
		<div class="jottings_content">
			<ul class="jottings_ul">
				<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="jottings_ul_li" style="background-image: url('<?php echo ($item['cover_path']); ?>');">
						<a href="/index.php?s=/Home/infomalessay/subpage/id/<?php echo ($item['id']); ?>">
							<div class="jottings_ul_li_more">
								<span></span>
								<div class="jottings_ul_li_more_text">
									<h3><?php echo ($item["title"]); ?></h3>
									<p><img src="/Public/Home/images/next_icon.png" alt=""> LEARN MORE</p>
								</div>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
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
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
	<title>实习生个人风采</title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/personal.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/nav.css">
</head>

<body>
	<div class="personalwrapper">
		<div class="navb">
			<a class="logo" href="/index.php?s=/Home/Index"></a>
			<ul class="nav">
				<li><a href="/index.php?s=/Home/Index#HIP" style="color: white;" class="lih">HIP</a></li>
				<li><a href="#" style="color: white;" class="lih">个人风采</a></li>
				<li><a href="/index.php?s=/Home/Experience" style="color: white;" class="lih">岗位经验</a></li>
				<li><a href="/index.php?s=/Home/infomalessay/jottings" style="color: white;" class="lih">随笔</a></li>
			</ul>
		</div>
		<div class="title_bg">
			<div class="title">
				<h3>个人风采</h3>
				<hr color="#DBDBDB" />
				<p class="personaltext">这里将展示MIC历届实习生的风采</p>
			</div>
		</div>
		<div class="personalwrapperimg" id="personalwrapperimg">
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="personalimg_content Horizontalcenter">
					<?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="personalimg_content_li">
							<img src="<?php echo ($item['p_img']); ?>" id="<?php echo ($item['id']); ?>">
							<p class="internname"><?php echo ($item['p_name']); ?></p>
							<p class="internjob"><?php echo ($item['p_station']); ?></p>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php
 for($i=count($vo); $i<4; $i++){ echo "<li class='personalimg_content_li'></li>"; } ?>
				</ul><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

		<!-- 翻页组件 -->


		<!-- 底部 -->
		<div class="foot">
			<p>Hi,partner</p>
			<p>powered by HIP</p>
			<p>Hi,partner © 2017 . PRIVACY POLICY</p>
		</div>
	</div>
	<div id="screen"></div>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="popup" id="<?php echo ($item['id']); ?>">
				<div class="popup_left">
					<div class="popup_left_head" style="background: url('<?php echo ($item['p_small_img']); ?>') center center;background-size:163px 163px;
					
					">
					</div>
					<div class="popup_left_text">
						<h3><?php echo ($item['p_name']); ?></h3>
						<div class="place">
							<img src="/Public/Home/images/site.png" alt="">
							<em><?php echo ($item['p_address']); ?></em>
						</div>
					</div>
				</div>

				<div class="popup_right">
					<div class="popup_right_message">
						<div class="popup_right_message_text">

							<span class="title">兴趣：</span>
							<p><?php echo ($item['p_hobby']); ?></p>
							<br>

							<span class="title">学校：</span>
							<p><?php echo ($item["p_school"]); ?></p>
							<br>

							<span class="title">对公司整体的看法：</span>
							<p><?php echo ($item["p_view_to_company"]); ?></p>
							<br>

							<span class="title">对公司其他人描述：</span>
							<p><?php echo ($item["p_view_to_other"]); ?></p>
							<br>
						</div>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>


	<script src='/Public/Home/js/nav.js'></script>
	<script type="text/javascript" src="/Public/Home/js/personal.js"></script>

</body>

</html>
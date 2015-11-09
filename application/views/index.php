<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Code Snippet &mdash; CKEditor Sample</title>
	<link href="<?php echo Uri::host()?>/static/css/default.css" rel="stylesheet">
	<script>
	function search() {
		var keyword = document.getElementById('keyword').value;
		window.location.href='<?php echo Uri::site("index.php/category-{$id}-1-")?>'+keyword+'.html';
	}
	</script>
</head>
<body>
	<div id='wrap'>
		<div id='head'>
		<div id='logo'><em>---往者不谏 来者可追---</em></div>
		<div id='nav'>
			<ul>
				<li class='line'><a href='<?php echo Uri::host()?>'>首页</a></li>
				<?php if($cat){foreach ($cat as $k=>$v){$k++?>
				<li class='curr <?php if($k<count($cat)){?>line<?php }?>'><a href='<?php echo Uri::site('category-'.$v['id'].'.html')?>'><?php echo $v['title']?></a></li>
				<?php }}?>
			</ul>
		</div>
		</div>
		<div id='content'>
			<div id='left'>
				<?php if($list){foreach ($list as $v){?>
				<div class='row'>
					<div class='title'><u><a href='<?php echo Uri::site('archive-'.$v['id'].'.html')?>'><?php echo $v['title']?></a></u></div>
					<p><?php echo $v['desc']?></p>
					<div class='info'><em>Time:<?php echo date('Y-m-d H:i', $v['createtime'])?></em>&nbsp;<em>Comments:0</em></div>
				</div>
				<?php }}?>
				<div class='page'>
					<?php echo $page;?>
				</div>
			</div>
			<div id='right'>
				<div style='font-size:14px;color:rgb(33,81,121);border-bottom:1px solid rgb(33,81,121)'><em>热门排行</em></div>
				<?php if($list){foreach ($list as $v){?>
				<div class='row'>
					<div class='title' style='height:25px;line-height:25px'><a style='text-decoration:none;font-size:12px' href='<?php echo Uri::site('archive-'.$v['id'].'.html')?>'><?php echo Utf8::cutstr($v['title'], 0, 18)?></a></div>
				</div>
				<?php }}?>
			</div>
		</div>
		<div style='clear:both'></div>
		<div id='footer'>
			
		</div>
	</div>
</body>
</html>
<?
	$user = [
		'user_name' => 'UName Test',
		'user_pic_url' => 'https://habrastorage.org/getpro/moikrug/uploads/user/100/006/031/1/avatar/medium_6393dc446c13261c138ae1c803cfefaf.jpg'
	]
		
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Views/reset.css" />
		<link rel="stylesheet" type="text/css" href="Views/feed.css" />
		<link rel="stylesheet" type="text/css" href="Views/add.css" />
	</head>
	<body>
		<header> 
			<div class="wrapper clearfix">
				<div class="header_left-wrapper">
					<h1 class="header_title">There is gonna be some blog name sometimes</h1>
				</div>
				<div class="header_right-wrapper">
					<a class="user_panel-user_info" href="/user_info">
						<span class="user_panel-user_pic" style="background-image: url('<?=$user['user_pic_url'] ?>');"></span>
						<span class="user_panel-user_name"><?=$user['user_name'] ?></span>
					</a>
				</div>
			</div>
		</header>
		
		<section class="blog_list_header">
			<div class="wrapper">
				<h1 class="blog_title">Add new post </h1>
			</div>
		</section>
		<section>
			<div class="wrapper">
				<form action="feed.php" method="post" class="blog_post-new">
					<p>
						<input name="blog_post[title]" placeholder="Post Title">
					</p>
					<p>
						<textarea rows="15" name="text"></textarea>
					</p>
					<p>
						<input type="submit" value="Send" class="button_input">
					</p>
				</form>
			</div>
		</section>
		<footer>
			<div class="wrapper">
				Copyright 2015
			</div>
		</footer>
	</body>
</html>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Views/reset.css" />
		<link rel="stylesheet" type="text/css" href="Views/feed.css" />
	</head>
	<body>
		<header> 
			<div class="wrapper clearfix">
				<div class="header_left-wrapper">
					<h1 class="header_title">There is gonna be some blog name sometimes</h1>
				</div>
				<div class="header_right-wrapper">
					<a class="button_reg login" href="/login">Login</a>
				</div>
			</div>
		</header>
		
		<section class="blog_list_header">
			<div class="wrapper">
				<h1 class="blog_list_title">Feed </h1>
			</div>
		</section>
		<section>
			<div class="wrapper">
				<? foreach($posts as $post){ ?>
				<article class="post_block">
					<h1 class="post_block-title">
                        <?=$post->title  ?>
                    </h1>
					
					<div class="post_block-content">
						<p><?= $post->text ?></p>
					</div>					
				</article>
				<? } ?>
			</div>
		</section>
		<footer>
			<div class="wrapper">
				Copyright 2015
			</div>
		</footer>
	</body>
</html>


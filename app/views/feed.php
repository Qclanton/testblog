<?
	$post = [
		[
			'title'=>'Title Test',
			'text'=>'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.'
		],
		[
			'title'=>'Title Test2',
			'text'=>'oloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.'
		]
	];
?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="views/reset.css" />
		<link rel="stylesheet" type="text/css" href="views/feed.css" />
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
				<h1 class="blog_list_title">Blog list </h1>
			</div>
		</section>
		<section>
			<div class="wrapper">
				<? foreach($post as $post_block){ ?>
				<article class="post_block">
					<? if (!empty($post_block['title'])) {   ?>
					<h1 class="post_block-title">
						<?=$post_block['title']  ?>
					</h1>
					<? } else { ?>
					<h1 class="post_block-title">
						There is no title
					</h1>
					<? } ?>
					
					<div class="post_block-content">
					<? if (!empty($post_block['text'])) {   ?>
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
						</p>
					<? } else { ?>
						<p>
							There is no content
						</p>
					<? } ?>
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


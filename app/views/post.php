<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Views/reset.css" />
		<link rel="stylesheet" type="text/css" href="Views/feed.css" />
		<link rel="stylesheet" type="text/css" href="Views/add.css" />
	</head>
	<body>		
		<section class="blog_list_header">
			<div class="wrapper">
				<h1 class="blog_title">Post page</h1>
			</div>
		</section>
		<section>
			<div class="wrapper">
                <h4><?= $post->title ?></h4>
                <p><?= $post->text ?></p>
			</div>
		</section>
		<footer>
			<div class="wrapper">
				Copyright 2016
			</div>
		</footer>
	</body>
</html>

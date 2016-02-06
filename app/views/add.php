<?
	$user = [
		'user_name' => 'UName Test',
		'user_pic_url' => 'https://habrastorage.org/getpro/moikrug/uploads/user/100/006/031/1/avatar/medium_6393dc446c13261c138ae1c803cfefaf.jpg'
	]
		
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Views/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="Views/css/feed.css" />
		<link rel="stylesheet" type="text/css" href="Views/css/add.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	
	<!--Bootstrap-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<header>
		<nav class="navbar">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="glyphicon glyphicon-align-justify"></span>
					</button>
					<a class="navbar-brand" href="/">Blog</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="/">Blog</a>
						</li>
						<li>
							<a href="/add">Add Post</a>
						</li>
						<li>
							<a href="#">Link</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right user_panel-user_info">
						<li>
							<button class="user_panel-user_pic" data-toggle="popover" data-original-title="" title="">
								<img src='<?=$user['user_pic_url'] ?>'>
							</button>
						
						</li>
					</ul>
					<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
					</form>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</header>
	<section class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="panel">
						<div class="panel-heading">
							<h5>About</h5>
						</div>
						<div class="panel-body">
							<p>I wish i was a little bit taller, wish i was a baller, wish i had a girl… also.</p>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h5>About</h5>
						</div>
						<div class="panel-body">
							<p> 
								Aenean lacinia bibendum nulla sed consectetur. Vestibulum id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 posts_blocks">
					
					<form action="/set" method="post" class="blog_post-new">
						<p>
							<input class="form-control" name="post[title]" placeholder="Post Title">
						</p>
						<p>
							<input class="form-control" name="post[tags]" placeholder="Post Tags">
						</p>
						<p>
							<textarea  class="form-control" name="post[text]" rows="15" name="text"></textarea>
						</p>
						<p>
							<input class="form-control" type="submit" value="Send" class="button_input">
						</p>
					</form>
				</div>
				<div class="col-md-3">
					<div class="panel">
						<div class="panel-heading">
							<h5>About</h5>
						</div>
						<div class="panel-body">
							<p> Aenean lacinia bibendum nulla sed consectetur. Vestibulum id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
						</div>
					</div>
					<div class="panel">
						<div class="panel-body">
							<p> &copy <?php echo date('Y'); ?>  VividCrest </p>
						</div>
					</div>

				</div>
			</div>	
		</div>
	</section>
</body>
	
	
<!--
	
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
			<form action="/set" method="post" class="blog_post-new">
				<p>
					<input name="post[title]" placeholder="Post Title">
				</p>
				<p>
					<input name="post[tags]" placeholder="Post Tags">
				</p>
				<p>
					<textarea name="post[text]" rows="15" name="text"></textarea>
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
-->
</html>

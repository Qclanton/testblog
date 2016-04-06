<!doctype html>
<html lang=en>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Views/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="Views/css/feed.css" />
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
							<a href="add">Add Post</a>
						</li>
						<li>
							<a href="#">Link</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Login</a></li>
						<li><a href="#">Register</a></li>
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
					<?php foreach($posts as $post){ ?>
						<article class="post_block">
							<div class="post_block-title row">
								<h1 class="col-md-9">
									<a href="">
										<?=$post->title ?>
									</a>
								</h1>
								<time class="col-md-3 text-right">Feb 05, 2015</time>
							</div>

							<div class="post_block-content">
								<div class="post_block-content_text">
									<p>
										<?= $post->text ?>
									</p>
								</div>
								<div class="post_block-info_line text-right">
									<a href="/">
									  5 <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
									</a>
								</div>
							</div>					
						</article>
					<?php } ?>
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
	
	<footer>
		<div class="wrapper">
			
		</div>
	</footer>
</body>
</html>


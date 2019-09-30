<?php 
	require 'core/conf.php';
	$title = "Home | ".APP_NAME;
	$styles = ["index.css"];
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require ROOT.'/struct/head.php'; ?>
	</head>
	<body>
		<div id="hero-half">
			<h1><span>un</span>Bias</h1>	
			<div id="hero-desc">
				A platform built on <b>unbiased</b> Machiene Learning to present you with the true face behind every political parties' mask.
				<br><br><b>Find the change you want to see.</b>
			</div>
			<a href="filter.php"><button class="btn" id="hero-explore">Explore</button></a>
		</div><img id="hero-img" src="img/anon.jpeg">
	</body>
</html>
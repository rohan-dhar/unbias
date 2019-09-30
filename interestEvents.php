<?php 
	require 'core/conf.php';
	require 'core/Event.php';
	
	$e = new Event();
	
	if(!@isset($_GET['id'])){
		header('Location: filter.php');		
		exit();
	}
	
	$id = (int)$_GET['id'];
	$events = $e->getInterestEvents($id);
	$inter = $interests[$id];

	$title = $inter." | ".APP_NAME;
	$styles = ['event.css', "interest.css"];
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require ROOT.'/struct/head.php'; ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIVFdmuyuAXp6UmEcWWodocZmFPK4lATw&callback=initMap" async defer></script>
	</head>
	<body>
		<div id="hero">
			<a href="filter.php"><div id="back">< Back</div></a>
			<h1><?php echo $inter; ?>.</h1><br>
			<div id="desc">Analysis of recent events</div>			
		</div>
		<?php 
		$html = '';
		foreach ($events as $v) {
			$html .= $e->genHTML($v);
		}
		echo $html;
		?>
	</body>
</html>
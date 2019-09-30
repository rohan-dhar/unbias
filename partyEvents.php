<?php 
	require 'core/conf.php';
	require 'core/Party.php';
	require 'core/Event.php';

	$p = new Party();
	$e = new Event();
	
	if(!@isset($_GET['id'])){
		header('Location: filter.php');		
		exit();
	}
	
	$id = (int)$_GET['id'];
	$info = $p->getInfo($id);
	$events = $e->getPartyEvents($id);


	$title = $info["code"]." | ".APP_NAME;
	$scripts = ['events.js'];
	$styles = ['event.css', "party.css"];
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
			<h1><?php echo $info["name"]; ?></h1>
			<div id="desc">Analysis of recent events</div>			
		</div>
		<?php 
			$html = '';
			foreach ($events as $v) {
				$html .= $e->genHTML($v);
			}
			echo $html;
		?>
		<div id="info-cont">
			<img src=<?php echo '"img/'.$info['logo'].'"';?>>
			<div class="party-info party-name"> <?php echo $info['name']; ?></div>
			<div class="party-info"> <span class="party-label">Interests</span> <?php echo implode($info['interests'], ', '); ?></div>
			<div class="party-info"> <span class="party-label">Leader</span> <?php echo $info['leader']; ?></div>
			<div class="party-info"> <span class="party-label">Location</span> <?php echo $info['location']; ?></div>
			<div class="party-info"> <span class="party-label">Year of Establishment</span> <?php echo $info['year']; ?></div>
			<div class="party-info"> <span class="party-label">Location</span> <?php echo $info['location']; ?></div>
			<div class="party-info"> <span class="party-label">Funds Raised</span> <?php echo $info['funding']; ?></div>
		
		</div>
	</body>
</html>
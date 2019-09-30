<?php 
	require 'core/conf.php';
	require 'core/Party.php';

	$p = new Party();
	$allParties = $p->getAll();

	$title = "Filters | ".APP_NAME;
	$styles = ["filter.css"];
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require ROOT.'/struct/head.php'; ?>
	</head>
	<body>
		<h1>Choose the category you<br>care about the most.</h1>
		<div class="opt-cont" id="opt-cont-party">
			<h2 class="opt-head">Political Party</h2>
			<?php 
				$html = "";
				foreach ($allParties as $v) {
					$html .= '<a href="partyEvents.php?id='.$v['id'].'"> <div class="opt" id="opt-party-'.$v["id"].'"><b>'.$v['code'].'</b> '.$v["name"].'</div></a>';
				}
				echo $html;
			?>
		</div>
		<div class="opt-cont" id="opt-cont-interest">
			<h2 class="opt-head">Interest</h2>
			<?php 
				$html = "";
				foreach ($interests as $k => $v) {
					$html .= '<a href="interestEvents.php?id='.$k.'"><div class="opt" id="opt-int-'.$k.'">'.$v.'</div>';
				}
				echo $html;
			?>
		</div>

	</body>
</html>
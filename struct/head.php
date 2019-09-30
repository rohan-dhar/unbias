<meta charset="utf-8">

<title><?php if(@isset($title)){echo $title;}?></title>

<script type="text/javascript" src= <?php echo '"'.HTML_ROOT.'/js/jquery.min.js"' ?> ></script>
<script type="text/javascript" src= <?php echo '"'.HTML_ROOT.'/js/ui.js"' ?> ></script>

<link rel="stylesheet" type="text/css" href= <?php echo '"'.HTML_ROOT.'/css/ui.css"' ?>>


<?php 
	if(@isset($styles)){
		$html = '';	
		foreach($styles as $s){
			$html .= '<link rel="stylesheet" type="text/css" href= "'.HTML_ROOT.'/css/'.$s.'">';
		}
		echo $html;
	}
	if(@isset($scripts)){
		$html = "";
		foreach($scripts as $s){
			$html .= '<script type="text/javascript" src= "'.HTML_ROOT.'/js/'.$s.'"></script>';
		}
		echo $html;
	}
?>
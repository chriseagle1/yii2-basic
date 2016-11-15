<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Poker record</title>
	 <link href="/css/poker.css" rel="stylesheet">
</head>
<body>
	<div class="wrap">
		<div class="poker-set">
			<?php foreach ($all_poker as $key => $value) { ?>
				<div id="<?=$value?>" class="poker-list <?php if ($key == 0) { echo 'first-poker';}?>" style="background-image: url(/image/poker_pics/<?=$value?>.JPG);left:<?=($key*25+80);?>px"></div>
			<?php }?>
		</div>
		<div class="clear-float"></div>
		<div class="left-list player-area">
			<div>left player:</div>
			
		</div>
		<div class="right-list player-area">
			<div>right player:</div>
		</div>
		<div class="clear-float"></div>
		<div class="self-list">
			<div>self list:</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/poker.js"></script>
</html>
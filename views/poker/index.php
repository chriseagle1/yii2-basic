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
				<div id="<?=$value?>" class="poker-list <?php if ($key == 0) { echo 'first-poker';}?>" style="background-image: url(/image/poker_pics/<?=$value?>.JPG)"></div>
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
</html>
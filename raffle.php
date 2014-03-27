<!DOCTYPE HTML>
<html>
	<?php 
		# raffle code
		function raffle($raffle) {
			if (!empty($raffle[0])) {
				$raffle = array_values(array_filter($raffle));
				$raffle = implode(',',$raffle);
				$raffle = preg_replace('/<(.|\n)*?>/', ' ',$raffle);
				$array = explode(',',$raffle);
				$max = count($array); $chosen = '';
				while (empty($array[$chosen])) {
					$chosen = rand(0,$max);
				}
				return $array[$chosen];
			}
			else return false;
		}
		function loadraffle($string) {
			if (!empty($string)) {
				if (!is_array($string)) $string = explode(',',$string);
				$raffle = array_values(array_filter($string));
				if (is_array($string)) $string = implode(',',$string);
				$raffle = explode(',',$string);
				$rafflehtml = '';
				foreach($raffle as $participant) {
					if (!empty($participant)) $rafflehtml .= "<input class=span4 type=text name=raffle[] value='$participant' />";
				}
				return $rafflehtml;
			}
		}
	?>
	<head>
		<title>Raffle'it!</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>	
	</head>
	<body>
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/mosh.mods.js"></script>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="index.php">Raffle'it!</a>
					<div class="nav-collapse collapse">
						<ul class="nav"><li><a href="http://moshcode.me" target="_blank">by www.moshcode.me</a></li></ul>
						<ul class="nav pull-right">
							<li class="dropdown">
								<a class="dropdown-toggle" href="#" data-toggle="dropdown">credits<strong class="caret"></strong></a>
								<div class="dropdown-menu span4" style="padding: 15px; padding-bottom: 0px;" >
									<h4>Technologies</h4>
									<a class="link" href="http://twitter.github.io/bootstrap/" target="_blank">Bootsrap</a>, 
									<a class="link" href="http://jquery.com/" target="_blank">JQuery</a> and  
									<a class="link" href="http://php.net/" target="_blank">PHP</a>.
									<h4>Other</h4>
									<p><a href="http://moshcode.me" target="_blank">MoshMage</a> provided the implementation of all technologies.</p>
								</div>
							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="hero-unit">
				<h1>Raffle'it!</h1>
				<p>Find a random value. Of anything.</p>
			</div>
			<div class="row">
				<div class="span6">
						<?php
						if (!empty($_COOKIE['RaffleIt'])) {
							$lastraffle = loadraffle($_COOKIE['RaffleIt']);
							setcookie ("RaffleIt", "", time() - 3600);
						}
						if (!empty($_POST['raffle'])) {
							$inputraffle = '';
							foreach($_POST['raffle'] as $raffler) {
								if (!empty($raffler)) $inputraffle[] = $raffler;
							}
							if (empty($_POST['save'])) {

								$winner = raffle($inputraffle);
								$inputraffle = implode(',',$inputraffle);
								$lastraffle = loadraffle($inputraffle);
								if (!empty($winner)) {
									?>
									<div class="alert alert-success">
										<h3><?php echo $winner; ?></h3>
										<p>Is the Raffle winner :)</p>
									</div>
									<?php
								}
								else {
								?>
								<div class="alert alert-error">
									<h4>Oh my!</h4>
									<p>No winner was found.</p>
									<h5>Did you enter any value?</h5>
								</div>
								<?php
								}
							}
							else {
								if (!empty($inputraffle)) {
									$lifespan = time()+(3600*24)*15;
									$rafflevalues = implode(',',$inputraffle);
									$rafflevalues = preg_replace('/<(.|\n)*?>/', ' ',$rafflevalues);
									setcookie("RaffleIt", $rafflevalues, $lifespan);
									$lastraffle = loadraffle($rafflevalues);
									?>
									<div class="alert alert-info">
										<h4>Raffle saved!</h4>
										<p>Raffle will be deleted uppon next visit or in 15days.</p>
										<h5>See you soon :)</h5>
									</div>
									<?php
								}
								else {
								?>
									<div class="alert alert-error">
										<h4>Oh my!</h4>
										<p>The machine was unable to save your raffle.</p>
										<h5>Did you enter any value?</h5>
									</div>
								<?php
								}
							}
						}
						else {
							?>
							<div class="alert alert-info">
								<h4>Fill in the form</h4>
								<p>And press the raffle button :)</p>
								<h4>If you press 'save'</h4>
								<p>The raffle will be saved to your cookies and the winner will not be announced ^^</p>
								<p><strong>Soon as you visit the website again it will load and delete the cookie.</strong> Otherwise, the cookie has 15days life-span.</p>
							</div>
							<?php
						}

					?>
				</div>
				<div class="span6">
				
						<form method=post >
							<div id="raffleadd" class="row span4 pull-left">
								<?php if (!empty($lastraffle)): echo $lastraffle; ?>
								<?php else: ?>
									<input class="span4 pull-left" type="text" name="raffle[]" />
									<input class="span4 pull-left" type="text" name="raffle[]" />
								<?php endif; ?>
							</div>
							<div class="pull-right">
								<button type=button id="raffleaddbut" class="btn btn-info span1">+</button>
							</div>
							
							<div class="pull-left">
								<button type="submit" class="btn btn-success">Raffle!</button>
								<label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox1" name="save" class="alert" value="1"> Save this raffle
								</label>
							</div>
						</form>
						
						
				</div>
			</div>
		</div>
	</body>
</html>
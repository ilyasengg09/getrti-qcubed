<div class="container">

	<div class="row" style="
    background-color: antiquewhite;
">
		<div class="col-lg-12">
			<h2 style="font-weight:bold;padding-left:10px;"><?php echo $_CONTROL->campaign->Description; ?>
			</h2>
		</div>
	</div>
	<?php include __VIEWS_PATH__.'/searchbox.tpl.php'; ?>
	<div class="row">
		<div class="col-lg-12">
			<br />
			<p><?php echo $_CONTROL->campaign->Longdescription; ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">MP"s Stand on <?php echo $_CONTROL->campaign->Name; ?></h3></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-4">
							<h2 class="text-success"><?php echo $_CONTROL->strMpFor; ?> <small>FOR</small></h2>
						</div>
						<div class="col-lg-4">
							<h2 class="text-danger"><?php echo $_CONTROL->strMpAgainst; ?> <small>AGAINST</small></h2>
						</div>
						<div class="col-lg-4">
							<h2><?php echo $_CONTROL->strMpUndecided; ?> <small>UNDECIDED</small></h2>
						</div>
					</div>
					<div class="row">
						<div class="graph col-lg-12">
							<canvas id="canvasmp" width="350" height="350" class="col-lg-offset-2"></canvas>
						</div>
						<script>
							var pieDataMp = [
								{
									// undecided
									value: <?php echo $_CONTROL->strMpUndecided; ?>,
									color:"#808080"
								},
								{
									// for
									value : <?php echo $_CONTROL->strMpFor; ?>,
									color : "#009933"
								},
								{
									// against
									value : <?php echo $_CONTROL->strMpAgainst; ?> ,
									color : "#CC3300"
								}
								];
							var myPieMp = new Chart(document.getElementById("canvasmp").getContext("2d")).Pie(pieDataMp);
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Citizen's Voice on <?php echo $_CONTROL->campaign->Name; ?></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<h2 class="text-success"><?php echo $_CONTROL->strUsersFor; ?> <small>FOR</small></h2>
						</div>
						<div class="col-lg-6">
							<h2 class="text-danger"><?php echo $_CONTROL->strUsersAgainst; ?> <small>AGAINST</small></h2>
						</div>
					</div>
					<div class="row">
						<div class="graph col-lg-12">
							<canvas id="canvasusers" width="350" height="350" class="col-lg-offset-2"></canvas>
						</div>
						<script>
							var pieDataUsers = [
								{
									// for
									value : <?php echo $_CONTROL->strUsersFor; ?>,
									color : "#009933"
								},
								{
									// against
									value : <?php echo $_CONTROL->strUsersAgainst; ?> ,
									color : "#CC3300"
								}
							];
							var myPieUsers = new Chart(document.getElementById("canvasusers").getContext("2d")).Pie(pieDataUsers);
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
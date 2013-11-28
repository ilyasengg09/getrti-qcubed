<div class="container">
	<?php include __VIEWS_PATH__.'/searchbox.tpl.php'; ?>

	<div class="row">
		<div class="col-lg-12">
			<h2><?php echo $_CONTROL->campaign->Name; ?>
				<small><?php echo $_CONTROL->campaign->Description; ?></small>
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">MPs' Stand on <?php echo $_CONTROL->campaign->Name; ?></h3></h3>
				</div>
				<div class="panel-body">
					<div class="col-lg-8 col-lg-offset-4">
						<?php $_CONTROL->lblMpFor->Render(); ?> <p class="text-success">FOR</p>
						<?php $_CONTROL->lblMpAgainst->Render(); ?> <p class="text-danger">AGAINST</p>
						<?php $_CONTROL->lblMpUndecided->Render(); ?> <p>UNDECIDED</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Users' Stand on <?php echo $_CONTROL->campaign->Name; ?></h3>
				</div>
				<div class="panel-body">
					<div class="col-lg-8 col-lg-offset-4">
						<br />
						<?php $_CONTROL->lblUsersFor->Render(); ?> <p class="text-success">FOR</p>
						<br />
						<?php $_CONTROL->lblUsersAgainst->Render(); ?> <p class="text-danger">AGAINST</p>
						<br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
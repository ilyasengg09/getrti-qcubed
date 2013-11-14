<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="form-horizontal">
				<div class="form-group">
					<?php $_CONTROL->txtSearch->Render(); ?>
					<?php $_CONTROL->btnGo->Render(); ?>
				</div>
			</div>
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
						<?php $_CONTROL->lblUsersFor->Render(); ?> <p class="text-success">FOR</p>
						<?php $_CONTROL->lblUsersAgainst->Render(); ?> <p class="text-danger">AGAINST</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<table class="table">
			<?php $_CONTROL->dtrComments->Render(); ?>
		</table>
		<div class="text-center"><?php $_CONTROL->dtrComments->Paginator->Render(); ?></div>
	</div>
</div>
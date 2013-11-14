<div class="container">
	<div class="row">
		<div class="col-lg-12">
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
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">MP Details</h2>
				</div>
				<div class="panel-body">
					<?php $_CONTROL->lblMpName->Render(); ?>
					<?php $_CONTROL->lblConstituency->Render(); ?>
					<strong><?php $_CONTROL->lblParty->Render(); ?></strong><br />

					<em>Permanent Address:</em>
					<address>
						<?php $_CONTROL->lblPAddress->Render(); ?>
					</address>
					<em>Delhi Address:</em>
					<address>
						<?php $_CONTROL->lblDAddress->Render(); ?>
					</address>
					<?php $_CONTROL->lblEmail->Render(); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">MP's Stand on <?php echo $_CONTROL->strCampaign; ?></h3>
				</div>
				<div class="panel-body">
					<?php $_CONTROL->lblMpStand->Render(); ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Your stand on <?php echo $_CONTROL->strCampaign; ?></h3>
				</div>
				<div class="panel-body">
					<?php $_CONTROL->lblUserStand->Render(); ?>
					<?php echo $_CONTROL->strVoteNow; ?>
					<?php $_CONTROL->btnVoteFor->Render(); ?>
					<?php $_CONTROL->btnVoteAgainst->Render(); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-4">

		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div  style="background-color:lightgrey" class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="form-horizontal">
						<div id="fg2" class="form-group">

							<?php $_CONTROL->txtSearch->Render(); ?>
							<?php $_CONTROL->btnGo->Render(); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="fg2" class="row">
				<div class="col-lg-12">
					<h2>	<?php echo $_CONTROL->campaign->Description; ?>
					</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div style="background-color: antiquewhite;" class="row">
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title">
	<?php $_CONTROL->lblMpName->Render(); ?></h2>
						</div>
						<div class="panel-body">
						
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
				<div class="col-lg-8">
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">MP's Stand on <?php echo $_CONTROL->strCampaign; ?></h3>
									</div>
									<div class="panel-body">
										<?php $_CONTROL->lblMpStand->Render(); ?>
									</div>
								</div>
							</div>
							<div class="row">
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
						</div>
						<div class="col-lg-6">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Constituency Stats</h3>
								</div>
								<div class="panel-body">
									<div class="col-lg-10 col-lg-offset-4">
										<br />
										<br />
										<h1><?php $_CONTROL->lblConstituencyFor->Render(); ?></h1> <p class="text-success">FOR</p>
										<br />
										<br />
										<h1><?php $_CONTROL->lblConstituencyAgainst->Render(); ?></h1> <p class="text-danger">AGAINST</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<?php $_CONTROL->txtCommentBox->Render(); ?>
					<?php $_CONTROL->radioVote->RenderWithName(); ?>
					<?php $_CONTROL->btnCommentSubmit->Render(); ?><br /><br />
				</div>
			</div>
			<div class="row">
				<table class="table">
					<?php $_CONTROL->dtrComments->Render(); ?>
				</table>
				<div class="text-center"><?php $_CONTROL->dtrComments->Paginator->Render(); ?></div>
			</div>
		</div>
	</div>
</div>
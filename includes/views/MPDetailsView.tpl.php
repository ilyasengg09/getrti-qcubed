<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h2 style="
    font-weight: bold;
"><?php echo $_CONTROL->campaign->Description; ?></h2>
		</div>
	</div>
	<div class="row" style="margin-top:20px;">
		<div class="col-lg-12">
			<div class="row" style="background-color: antiquewhite;">
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php $_CONTROL->lblMpName->Render(); ?>
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
										<h3 class="panel-title" style="margin-top: 20px; margin-bottom: 10px; font-size: 24px;" >
											MP's Stand on <?php echo $_CONTROL->campaign->Name; ?>
										</h3>
									</div>
									<div class="panel-body" style="min-height: 254px;">
										<?php $_CONTROL->lblMpStand->Render(); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title" style="font-size: 24px; margin-top: 20px; margin-bottom: 10px;">
										Constituency Stats
									</h3>
								</div>
								<div  class="panel-body" style="min-height:250px;">
									<div class="col-lg-10 col-lg-offset-4">
										<h1><?php $_CONTROL->lblConstituencyFor->Render(); ?></h1> <p class="text-success">FOR</p>
										<h1><?php $_CONTROL->lblConstituencyAgainst->Render(); ?></h1> <p class="text-danger">AGAINST</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div  class="row">
				<div class="col-lg-12">
					<?php $_CONTROL->lblMsg->Render(); ?>
					<div style="background-color:lightgrey;"  class="row">
						<div class="col-lg-12">

							<?php $_CONTROL->txtCommentBox->Render(); ?>
							<?php $_CONTROL->radioVote->RenderWithName(); ?>
							<?php $_CONTROL->btnCommentSubmit->Render(); ?><br /><br />
						</div>
					</div>
				<div class="col-lg-12">
					<div class="row">
						<table class="table">
							<?php $_CONTROL->dtrComments->Render(); ?>
						</table>
						<div class="text-center"><?php $_CONTROL->dtrComments->Paginator->Render(); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
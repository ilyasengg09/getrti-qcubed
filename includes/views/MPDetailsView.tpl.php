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
			<?php $_CONTROL->lblMpName->Render(); ?>
			<strong><?php $_CONTROL->lblParty->Render(); ?></strong><br />
			<em>Permanent Address:</em>
			<blockquote>
				<?php $_CONTROL->lblPAddress->Render(); ?>
			</blockquote>
			<em>Delhi Address:</em>
			<blockquote>
				<?php $_CONTROL->lblDAddress->Render(); ?>
			</blockquote>
			<?php $_CONTROL->lblEmail->Render(); ?>
		</div>
		<div class="col-lg-4">

		</div>
		<div class="col-lg-4">
			<?php $_CONTROL->lblConstituency->Render(); ?>
		</div>
	</div>
</div>
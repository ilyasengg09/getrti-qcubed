<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<?php $_CONTROL->lblMsg->Render(); ?>
			<div role="form">
				<div class="form-group">
					<?php $_CONTROL->txtComment->Render(); ?>
				</div>
				<div class="form-actions">
					<?php $_CONTROL->btnSubmit->Render(); ?>&nbsp;&nbsp;<?php $_CONTROL->lblSkip->Render(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
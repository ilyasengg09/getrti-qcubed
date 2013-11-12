<div class="container">
	<div class="row">
		<?php $_CONTROL->lblMsg->Render(); ?>
		<div class="col-lg-3 col-lg-offset-2">
			<h3>Login to <?php echo __SM_APP_NAME__; ?></h3>
			<div class="form-horizontal">
				<div class="form-group">
					<?php $_CONTROL->txtLogUsername->RenderWithError(); ?>
				</div>
				<div class="form-group">
					<?php $_CONTROL->txtLogPassword->RenderWithError(); ?>
				</div>
				<div class="form-actions">
					<?php $_CONTROL->btnLogin->Render(); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-lg-offset-1">
			<h3>Register a new account</h3>
			<div class="form-horizontal">
				<div class="form-group">
					<?php $_CONTROL->txtRegName->RenderWithError(); ?>
				</div>
				<div class="form-group">
					<?php $_CONTROL->txtRegEmail->RenderWithError(); ?>
				</div>
				<div class="form-group">
					<?php $_CONTROL->txtRegUsername->RenderWithError(); ?>
				</div>
				<div class="form-group">
					<?php $_CONTROL->txtRegPassword->RenderWithError(); ?>
				</div>
				<div class="form-group">
					<?php $_CONTROL->txtRegPasswordRepeat->RenderWithError(); ?>
				</div>
				<div class="form-actions">
					<?php $_CONTROL->btnRegister->Render(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
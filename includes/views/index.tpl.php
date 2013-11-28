<html>
<head>
	<title><?php echo $this->strTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Saurav Modak">
	<link href="<?php echo __SM_SITE_ABSOLUTE__ADDRESS__.__APP_CSS_ASSETS__; ?>/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<?php $this->RenderBegin(); ?>
<?php $this->pnlPageHeader->Render(); ?>
<?php $this->pnlPageMainBody->Render(); ?>
<?php $this->pnlPageFooter->Render(); ?>
<?php $this->RenderEnd(); ?>
<?php
if(QApplication::PathInfo(0)!='campaign'){
	echo '<script src="'.__SM_SITE_ABSOLUTE__ADDRESS__.__APP_JS_ASSETS__.'/jquery.js"></script>';
}
?>
<script src="<?php echo __SM_SITE_ABSOLUTE__ADDRESS__.__APP_JS_ASSETS__; ?>/bootstrap.min.js"></script>
</body>
</html>
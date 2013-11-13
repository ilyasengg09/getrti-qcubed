<html>
<head>
	<title><?php echo $this->strTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo __APP_CSS_ASSETS__ ; ?>/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<?php $this->RenderBegin(); ?>
<?php $this->pnlPageHeader->Render(); ?>
<?php $this->pnlPageMainBody->Render(); ?>
<?php $this->pnlPageFooter->Render(); ?>
<?php $this->RenderEnd(); ?>
<?php
if(QApplication::PathInfo(0)!='campaign'){
	echo '<script src="'.__APP_JS_ASSETS__.'/jquery.js"></script>';
	echo '<script src="'.__APP_JS_ASSETS__.'/bootstrap.min.js"></script>';
}
?>
</body>
</html>